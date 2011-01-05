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
__date__ = '2010-11-26'
__version__ = '0.1'

import cStringIO
import xml.etree.cElementTree as cElementTree
import sys
sys.path.append('..')

import configuration
settings = configuration.Settings()

from utils import models
from utils import utils
from utils import messages
import wikitree

class TXTFile(object):

    def __init__(self, file, location, output, output_file, target, **kwargs):
        self.file = file
        self.location = location
        self.target = target
        self.output = output
        self.output_file = output_file
        for kw in kwargs:
            setattr(self, kw, kwargs[kw])

    def __str__(self):
        return '%s' % (self.file)

    def __call__(self, bots):
        self.bots = bots
        self.fr = utils.create_txt_filehandle(self.location, self.file, 'r', settings.encoding)
        self.fw = utils.create_txt_filehandle(self.output, self.output_file, 'w', settings.encoding)
        for line in self.fr:
            line = line.replace('\n', '')
            if line == '':
                continue
            line = line.split('\t')
            self.bots = self.target(line, self.fw, self.bots, self.keys)
            if self.bots == {}:
                break
        self.fr.close()
        self.fw.close()
        return self.bots

class XMLFileConsumer(models.BaseConsumer):

    def run(self):
        while True:
            new_xmlfile = self.task_queue.get()
            self.task_queue.task_done()
            if new_xmlfile == None:
                print 'Swallowed a poison pill'
                break
            print 'Queue is %s files long...' % (messages.show(self.task_queue.qsize) - settings.number_of_processes)
            new_xmlfile()


class XMLFile(object):
    def __init__(self, file, location, output, output_file, target, ** kwargs):
        self.file = file
        self.location = location
        self.output = output
        self.target = target
        self.output_file = output_file
        for kw in kwargs:
            setattr(self, kw, kwargs[kw])

    def create_file_handle(self):
        self.mode = 'a'
        if self.output_file == None:
            self.mode = 'w'
            self.output_file = self.file[:-4] + '.txt'

        self.fh = utils.create_txt_filehandle(self.output, self.output_file, self.mode, settings.encoding)

    def __str__(self):
        return '%s' % (self.file)

    def __call__(self, bots=None):
        if bots != {} and bots != None:
            self.bots = bots
        if settings.debug:
            messages = {}
            vars = {}

        data = xml.read_input(utils.create_txt_filehandle(self.location,
                                                      self.file, 'r',
                                                      encoding=settings.encoding))
        self.create_file_handle()
        for raw_data in data:
            xml_buffer = cStringIO.StringIO()
            raw_data.insert(0, '<?xml version="1.0" encoding="UTF-8" ?>\n')
            try:
                raw_data = ''.join(raw_data)
                xml_buffer.write(raw_data)
                elem = cElementTree.XML(xml_buffer.getvalue())
                bots = self.target(elem, fh=self.fh, bots=self.bots)
            except SyntaxError, error:
                print error
                '''
                There are few cases with invalid tokens, they are ignored
                '''
                if settings.debug:
                    utils.track_errors(xml_buffer, error, self.file, messages)
            except UnicodeEncodeError, error:
                print error
                if settings.debug:
                    utils.track_errors(xml_buffer, error, self.file, messages)
            except MemoryError, error:
                print self.file, error
                print raw_data[:12]
                print 'String was supposed to be %s characters long' % sum([len(raw) for raw in raw_data])
        else:
            self.fh.close()

        if settings.debug:
            utils.report_error_messages(messages, self.target)

        return bots
