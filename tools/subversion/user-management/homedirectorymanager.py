#!/usr/bin/python
import sys, traceback, os, datetime, ldapsupportlib, shutil, pwd, re, pycurl
from optparse import OptionParser
from cStringIO import StringIO

try:    
	import ldap
	import ldap.modlist
except ImportError:
	sys.stderr.write("Unable to import LDAP library.\n")
	sys.exit(1)

class HomeDirectoryManager:

	def __init__(self):
		###################################################
		# Configuration options                           #
		###################################################

		# Change this if we change the home directory location!
		self.basedir = '/home/'

		# Directory to move deleted user's home directories
		self.savedir = self.basedir + 'SAVE/'

		# Add to this array if we add LDAP accounts that shouldn't
		# have NFS mounted home directories.
		self.excludedFromCreation = []

		# Add to this array if we add directories that don't have
		# LDAP accounts associated with them
		self.excludedFromModification = ['lost+found', 'SAVE', 'svn-private']

		# Skeleton files to add to the user's home directory
		self.skelFiles = {}
		self.skelFiles['/etc/skel/'] = ['.bashrc', '.profile', '.bash_logout']

		self.dryRun = False
		self.debugStatus = False

		if (os.path.exists('/usr/sbin/nscd')):
			os.system('nscd -i passwd')
			os.system('nscd -i group')

	def run(self):
		parser = OptionParser(conflict_handler="resolve")
		parser.set_usage("homedirectorymanager.py [options]\n\nexample: homedirectorymanager.py --dry-run")

		ldapSupportLib = ldapsupportlib.LDAPSupportLib()
		ldapSupportLib.addParserOptions(parser)

		parser.add_option("--dry-run", action="store_true", dest="dryRun", help="Show what would be done, but don't actually do anything")
		parser.add_option("--debug", action="store_true", dest="debugStatus", help="Run in debug mode (you likely want to use --dry-run with this)")
		(self.options, args) = parser.parse_args()

		self.dryRun = self.options.dryRun
		self.debugStatus = self.options.debugStatus

		# use proxy agent by default
		ldapSupportLib.setBindInfoByOptions(self.options, parser)

		base = ldapSupportLib.getBase()

		ds = ldapSupportLib.connect()
		self.logDebug("Connected")

		# w00t We're in!
		try:
			# get all user's uids
			UsersData = ldapSupportLib.getUsers(ds, '*')
			self.logDebug("Pulled the user information")

			# We are going to use a dictionary (associative array) as a hash bucket (keys pointing to dictionaries)
			# for the AllUsers data structure.
			# The data structure will look like this:
			# {"<uid>": {"uidNumber": <uidNumber>, "gidNumber": <gidNumber>, "sshPublicKey": ['key1', 'key2']}, 
			#  "<uid>": {"uidNumber": <uidNumber>, "gidNumber": <gidNumber>, "sshPublicKey": ['key1', 'key2']}}
			AllUsers = {}
			for user in UsersData:
				uid = user[1]['uid'][0]
				# uidNumber and gidNumber come back from LDAP as strings, we need ints here.
				uidNumber = int(user[1]['uidNumber'][0])
				gidNumber = int(user[1]['gidNumber'][0])
				sshPublicKey = user[1]['sshPublicKey']

				AllUsers[uid] = {}
				AllUsers[uid]["uidNumber"] = uidNumber
				AllUsers[uid]["gidNumber"] = gidNumber
				AllUsers[uid]["sshPublicKey"] = sshPublicKey

			self.changeGid(AllUsers)
			self.changeUid(AllUsers)
			self.moveUsers(AllUsers)
			self.createHomeDir(AllUsers)
			
		except ldap.UNWILLING_TO_PERFORM, msg:
			sys.stderr.write("The search returned an error. Error was: %s\n" % msg[0]["info"])
			ds.unbind()
			sys.exit(1)
		except Exception:
			try:
				sys.stderr.write("There was a general error, please contact an administrator via the helpdesk. Please include the following stack trace with your report:\n")
				traceback.print_exc(file=sys.stderr)
				ds.unbind()
			except Exception:
				pass
			sys.exit(1)

		ds.unbind()
		sys.exit(0)

	# Creates home directories for new users. Will not create home directories
	# for users that already have a directory in SAVE
	def createHomeDir(self, users):
		alreadyCreated = []

		for user in users.keys():
			if user in self.excludedFromCreation:
				continue

			if os.path.exists(self.savedir + user):
				# User's home directory already exists
				alreadyCreated.append(user)
				continue

			if os.path.exists(self.basedir + user):
				continue

			self.log( "Creating a home directory for %s at %s%s" % (user, self.basedir, user) )
			self.mkdir(self.basedir + user, 0700)
			self.mkdir(self.basedir + user + '/.ssh', 0700)
			self.writeKeys(user, users[user]['sshPublicKey'])
			self.chmod(self.basedir + user + '/.ssh/authorized_keys', 0600)
			for skeldir,skels in self.skelFiles.iteritems():
				for skel in skels:
					self.copy(skeldir + skel, self.basedir + user + "/")
					self.chmod(self.basedir + user + "/" + skel, 0600)
			newGid = users[user]['gidNumber']
			newUid = users[user]['uidNumber']
			self.chown(self.basedir + user, newUid, newGid)
			for root, dirs, files in os.walk(self.basedir + user):
				for name in files:
					self.chown(os.path.join(root, name), newUid, newGid)
				for name in dirs:
					self.chown(os.path.join(root, name), newUid, newGid)

		if alreadyCreated != []:
			self.log( "The following users already have a home directory in the SAVE directory: " + ", ".join(alreadyCreated) )

	def fetchKeys(self, location):
		keys = []
		if re.match('^http', location):
			buffer = StringIO()
			c = pycurl.Curl()
			c.setopt(c.URL, location)
			c.setopt(c.WRITEFUNCTION, buffer.write)
			c.perform()
			c.close()
			raw_keys = buffer.getvalue().splitlines(True)
		else:
			file = open(location, 'r')
			raw_keys = file.readlines()
		for raw_key in raw_keys:
			if (re.match('^$', raw_key) or re.match('^#', raw_key)):
				continue
			keys.append(raw_key)
		return self.uniqueKeys(keys)

	def uniqueKeys(self, keys):
		uniqueKeys = []
		[uniqueKeys.append(i) for i in keys if not uniqueKeys.count(i)]

		return uniqueKeys

	# Write a list of keys to the user's authorized_keys file
	def writeKeys(self, user, keys):
		self.writeFile(self.basedir + user + '/.ssh/authorized_keys', "\n".join(keys) + "\n")

	# Moved deleted users to SAVE
	def moveUsers(self, users):
		for userdir in os.listdir(self.basedir):
			if os.path.isdir(self.basedir + userdir) and userdir not in self.excludedFromModification:
				try:
					stat = os.stat(self.basedir + userdir)
					uidNumber = stat.st_uid
					# index 0 of getpwuid's return tuple is pw_name
					uid = pwd.getpwuid(uidNumber)[0]
					if userdir != uid:
						# User name has changed, rename the home directory
						self.renameUser(userdir, uid)
						continue
				except KeyError:
					pass
				if userdir not in users.keys():
					try:
						# Ensure the user isn't local
						checkexist = pwd.getpwnam(userdir)[0]
					except KeyError:
						self.deleteUser(userdir)

	def renameUser(self, olduserdir, newuserdir):
		self.rename(self.basedir + olduserdir, self.basedir + newuserdir)

	def deleteUser(self, userdir):
		# User has been deleted, move user's home directory to SAVE
		if os.path.isdir(self.savedir + userdir):
			self.log( userdir + " exists at both " + self.basedir + userdir + " and " + self.savedir + userdir )
		else:
			self.rename(self.basedir + userdir, self.savedir + userdir)

	# Changes the group ownership of a directory when a user's gid changes
	def changeGid(self, users):
		for userdir in os.listdir(self.basedir):
			if not os.path.isdir(self.basedir + userdir) or userdir in self.excludedFromModification:
				continue

			stat = os.stat(self.basedir + userdir)
			gid = stat.st_gid
			if userdir not in users.keys() or users[userdir]["gidNumber"] == gid:
				continue

			newGid = users[userdir]["gidNumber"]
			self.log( "Changing group ownership of %s%s to %s; was set to %s" % (self.basedir, userdir, newGid, gid) )

			# Python doesn't have a recursive chown, so we have to walk the directory
			# and change everything manually
			self.logDebug("Doing chgrp for: " + self.basedir + userdir + " with gid: " + str(gid))
			self.chown(self.basedir + userdir, -1, newGid)
			for root, dirs, files in os.walk(self.basedir + userdir):
				for name in files:
					self.chown(os.path.join(root, name), -1, newGid)
				for name in dirs:
					self.chown(os.path.join(root, name), -1, newGid)

	# Changes the ownership of a directory when a user's uid changes
	def changeUid(self, users):
		for userdir in os.listdir(self.basedir):
			if not os.path.isdir(self.basedir + userdir) or userdir in self.excludedFromModification:
				continue

			stat = os.stat(self.basedir + userdir)
			uid = stat.st_uid
			if userdir not in users.keys() or users[userdir]["uidNumber"] == uid:
				continue

			newUid = users[userdir]["uidNumber"]
			self.log( "Changing ownership of %s%s to %s; was set to %s" % (self.basedir, userdir, newUid, uid) )
			# Python doesn't have a recursive chown, so we have to walk the directory
			# and change everything manually
			self.chown(self.basedir + userdir, newUid, -1)
			for root, dirs, files in os.walk(self.basedir + userdir):
				for name in files:
					self.chown(os.path.join(root, name), newUid, -1)
				for name in dirs:
					self.chown(os.path.join(root, name), newUid, -1)

	def log(self, logstring):
		print datetime.datetime.now().strftime("%m/%d/%Y - %H:%M:%S - ")  + logstring

	def logDebug(self, logstring):
		if self.debugStatus  == True:
			sys.stderr.write("Debug: " + logstring + "\n")

	def chown(self, path, user, group):
		if not self.dryRun:
			os.chown(path, user, group)
		if self.dryRun or self.debugStatus:
			self.log('chown %s %d %d' % (path, user, group))
	
	def mkdir(self, path, mode):
		if not self.dryRun:
			os.mkdir(path, mode)
		if self.dryRun or self.debugStatus:
			self.log('mkdir %s %o' % (path, mode))
	
	def chmod(self, path, mode):
		if not self.dryRun:
			os.chmod(path, mode)
		if self.dryRun or self.debugStatus:
			self.log('chmod %s %o' % (path, mode))
	
	def writeFile(self, path, contents):
		if not self.dryRun:
			f = open(path, 'w')
			f.write(contents)
			f.close()
		if self.dryRun or self.debugStatus:
			self.log("write file %s:\n%s" % (path, contents))

	def rename(self, oldPath, newPath):
		if not self.dryRun:
			os.rename(oldPath, newPath)
		if self.dryRun or self.debugStatus:
			self.log('rename %s %s' % (oldPath, newPath))

	def copy(self, srcPath, dstPath):
		if not self.dryRun:
			shutil.copy(srcPath, dstPath)
		if self.dryRun or self.debugStatus:
			self.log('copy %s %s' % (srcPath, dstPath))

def main():
	homeDirectoryManager = HomeDirectoryManager()
	homeDirectoryManager.run()

if __name__ == "__main__":
	main()
