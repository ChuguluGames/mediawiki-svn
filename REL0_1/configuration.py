#!/usr/bin/python
# -*- coding: utf-8 -*-
'''
Copyright (C) 2010 by Diederik van Liere (dvanliere@gmail.com)
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details, at
http://www.fsf.org/licenses/gpl.html
'''

__author__ = '''\n'''.join(['Diederik van Liere (dvanliere@gmail.com)', ])
__author__email = 'dvanliere at gmail dot com'
__date__ = '2010-10-21'
__version__ = '0.1'

'''
This file contains settings that are used for constructing and analyzing
the datasets as part of the Editor Dynamics and Anti-Vandalism projects.
'''

from multiprocessing import cpu_count
import ConfigParser
import os
import sys
import platform
import subprocess

try:
    from _winreg import *
    from pywin import win32file
    '''increase the maximum number of open files on Windows to 1024'''
    win32file._setmaxstdio(1024)
except ImportError:
    pass

try:
    import resource
except ImportError:
    pass


class Settings(object):

        def __init__(self, debug=True, process_multiplier=1, **kwargs):
            self.debug = debug
            self.progressbar = True
            self.encoding = 'utf-8'
            self.date_format = '%Y-%m-%d'   #Date format as used by Erik Zachte
            self.timestamp_format = '%Y-%m-%dT%H:%M:%SZ'    # Timestamp format as generated by the MediaWiki dumps

            self.max_xmlfile_size = 4096 * 1024 #67108864   # ==64Mb, see http://hadoop.apache.org/common/docs/r0.20.0/hdfs_design.html#Large+Data+Setsfor reason
            self.number_of_processes = cpu_count() * process_multiplier
            #Change this to match your computers configuration (RAM / CPU)
            self.minimum_python_version = (2, 6)
            self.wp_dump_location = 'http://download.wikimedia.org'
            self.xml_namespace = 'http://www.mediawiki.org/xml/export-0.3/'
            self.ascii_extensions = ['txt', 'csv', 'xml', 'sql', 'json']
            self.windows_register = {'7z.exe': 'Software\\7-Zip', }
            #Extensions of ascii files, this is used to determine the filemode to use
            self.platform = self.determine_platform()

            self.architecture = platform.machine()
            self.working_directory = self.determine_working_directory()
            self.update_python_path()

            self.root = '/' if self.platform != 'Windows' else 'c:\\'
            self.file_locations = self.set_file_locations()
            self.max_filehandles = self.determine_max_filehandles_open()
            self.tab_width = 4 if self.platform == 'Windows' else 8

            self.load_configuration()
            self.set_custom_settings(**kwargs)
            self.dumpversions = {'0': 'http://www.mediawiki.org/xml/export-0.4/',
                                 '1': 'http://www.mediawiki.org/xml/export-0.3/',
                                 }
            self.projects = {'wiki': 'wikipedia',
                             'commons': 'commonswiki',
                             'books': 'wikibooks',
                             'news': 'wikinews',
                             'quote': 'wikiquote',
                             'source': 'wikisource',
                             'versity': 'wikiversity',
                             'tionary': 'wiktionary',
                             'meta': 'metawiki',
                             'species': 'specieswiki',
                             'incubator': 'incubatorwiki',
                             'foundation': 'foundationwiki',
                             'mediawiki': 'mediawikiwiki',
                             'outreach': 'outreachwiki',
                             'strategic_planning': 'strategywiki',
                             'usability_initiative': 'usabilitywiki',
                             'multilingual_wikisource': None
                            }



        def set_custom_settings(self, **kwargs):
            for kw in kwargs:
                setattr(self, kw, kwargs[kw])

        def load_configuration(self):
            if os.path.exists(os.path.join(self.working_directory, 'wiki.cfg')):
                config = ConfigParser.RawConfigParser()
                config.read(os.path.join(self.working_directory, 'wiki.cfg'))
                self.working_directory = config.get('file_locations', 'working_directory')
                self.input_location = config.get('file_locations', 'input_location')
                self.default_project = config.get('wiki', 'project')
                self.default_language = config.get('wiki', 'language')

        def determine_working_directory(self):
            cwd = os.getcwd()
            if not cwd.endswith('editor_trends%s' % os.sep):
                pos = cwd.find('editor_trends') + 14
                cwd = cwd[:pos]
            return cwd

        def determine_platform(self):
           os = platform.system()
           if os == 'Darwin':
               return 'OSX'
           else:
               return os

        #def determine_path_ziptool(self):
        #    return self.detect_installed_program(self.determine_ziptool())


        def verify_environment(self, directories):
            for dir in directories:
                if not os.path.exists(dir):
                    try:
                        os.makedirs(dir)
                    except IOError:
                        raise 'Configuration Error, could not create directory.'

        def detect_windows_program(self, program):
            entry = self.windows_register.get(program, None)
            try:
                key = OpenKey(HKEY_CURRENT_USER, entry, 0, KEY_READ)
                return QueryValueEx(key, 'Path')[0]
            except WindowsError:
                return None

        def detect_linux_program(self, program):
            path = subprocess.Popen(['which', '%s' % program], stdout=subprocess.PIPE).communicate()[0]
            return path.replace('\n', '')

        def detect_installed_program(self, program):
            if self.platform == 'Windows':
                if not program.endswith('.exe'):
                    program = program + '.exe'
                path = self.detect_windows_program(program)
                if path != None:
                    path = path + program
            elif self.platform == 'Linux':
                path = self.detect_linux_program(program)

            return path

        def determine_max_filehandles_open(self):
            if self.platform == 'Windows' and self.architecture == 'i386':
                return win32file._getmaxstdio()
            elif self.platform != 'Windows':
                return resource.getrlimit(resource.RLIMIT_NOFILE)[0]
            else:
                return 500

        def update_python_path(self):
            IGNORE_DIRS = ['wikistats', 'zips']
            dirs = [name for name in os.listdir(self.working_directory) if
               os.path.isdir(os.path.join(self.working_directory, name))]
            for subdirname in dirs:
                if not subdirname.startswith('.') and subdirname not in IGNORE_DIRS:
                   sys.path.append(os.path.join(self.working_directory,
                                                subdirname))



        def set_file_locations(self):
            self.input_location = os.path.join(self.root, 'wikimedia')
            self.input_filename = os.path.join(self.input_location, 'en',
'wiki', 'enwiki-20100916-stub-meta-history.xml')  # Default Input file
            self.log_location = os.path.join(self.working_directory,
'logs') # This is the place where error messages are stored for debugging purposes
            self.csv_location = os.path.join(self.working_directory,
'data', 'csv')
            self.dataset_location = os.path.join(self.working_directory, 'datasets')
            self.binary_location = os.path.join(self.working_directory,
'data', 'objects')
            self.namespace_location = os.path.join(self.working_directory,
'namespaces')
