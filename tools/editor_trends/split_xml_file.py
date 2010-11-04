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

import xml.etree.cElementTree as cElementTree
import codecs
import utils
import re
import json
import os

import progressbar

from utils import utils
import settings

try:
    import psyco
    psyco.full()
except ImportError:
    pass


RE_NUMERIC_CHARACTER = re.compile('&#(\d+);')


def remove_numeric_character_references(text):
    return re.sub(RE_NUMERIC_CHARACTER, lenient_deccharref, text).encode('utf-8')


def lenient_deccharref(m):
    try:
        return unichr(int(m.group(1)))
    except ValueError:
        '''
        There are a few articles that raise a Value Error here, the reason is
        that I am using a narrow Python build (UCS2) instead of a wide build
        (UCS4). The quick fix is to return an empty string...
        Real solution is to rebuild Python with UCS4 support.....
        '''
        return ''


def remove_namespace(element, namespace):
    '''Remove namespace from the XML document.'''
    ns = u'{%s}' % namespace
    nsl = len(ns)
    for elem in element.getiterator():
        if elem.tag.startswith(ns):
            elem.tag = elem.tag[nsl:]
    return element


def load_namespace(language):
    file = '%s_ns.json' % language
    fh = utils.create_txt_filehandle(settings.NAMESPACE_LOCATION, file, 'r', settings.ENCODING)
    ns = json.load(fh)
    fh.close()
    ns = ns['query']['namespaces']
    return ns


def build_namespaces_locale(namespaces):
    '''
    Construct a list of all the non-main namespaces
    '''
    ns = []
    for namespace in namespaces:
        value = namespaces[namespace].get(u'*', None)
        if value != None and value != '':
            ns.append(value)
    return ns


def parse_comments(xml, function):
    revisions = xml.findall('revision')
    for revision in revisions:
        comment = revision.find('comment')
        timestamp = revision.find('timestamp').text
        if comment != None and comment.text != None:
            comment.text = function(comment.text)
    return xml


def is_article_main_namespace(elem, namespace):
    '''
    checks whether the article belongs to the main namespace
    '''
    title = elem.find('title').text
    for ns in namespace:
        if title.startswith(ns):
            return False
    return True


def write_xml_file(element, fh, counter, language):
    '''Get file handle and write xml element to file'''
    size = len(cElementTree.tostring(element))
    fh, counter = create_xml_file_handle(fh, counter, size, language)
    try:
        fh.write(cElementTree.tostring(element))
    except MemoryError:
        print 'Add error capturing logic'
    fh.write('\n')
    return fh, counter


def create_xml_file_handle(fh, counter, size, language):
    '''Create file handle if none is supplied or if file size > max file size.'''
    if not counter:
        counter = 0
    path = os.path.join(settings.XML_FILE_LOCATION, language, '%s.xml' % counter)
    if not fh:
        fh = codecs.open(path, 'w', encoding=settings.ENCODING)
        return fh, counter
    elif (fh.tell() + size) > settings.MAX_XML_FILE_SIZE:
        print 'Created chunk %s' % counter
        fh.close
        counter += 1
        fh = codecs.open(path, 'w', encoding=settings.ENCODING)
        return fh, counter
    else:
        return fh, counter


def split_xml(location, filename, project, language_code):
    '''Reads xml file and splits it in N chunks'''
    #location = os.path.join(settings.XML_FILE_LOCATION, language)
    result = utils.check_file_exists(location, '')
    if result == False:
        result = utils.create_directory(location)
    if not result:
        return

    ns = load_namespace(language_code)
    ns = build_namespaces_locale(ns)

    fh = None
    counter = None
    source = os.path.join(location, filename)
    tag = '{%s}page' % settings.NAME_SPACE

    context = cElementTree.iterparse(source, events=('start', 'end'))
    context = iter(context)
    event, root = context.next()  #get the root element of the XML doc

    try:
        for event, elem in context:
            if event == 'end':
                if elem.tag == tag:
                    elem = remove_namespace(elem, settings.NAME_SPACE)
                    if is_article_main_namespace(elem, ns):
                        elem = parse_comments(elem, remove_numeric_character_references)
                        fh, counter = write_xml_file(elem, fh, counter, language_code)
                    root.clear()  # when done parsing a section clear the tree to safe memory
                    #elem = parse_comments(elem, convert_html_entities)
                    #elem = parse_comments(elem, remove_ascii_control_characters)
                    #print cElementTree.tostring(elem)
    except SyntaxError:
        fh = utils.create_txt_filehandle(ERROR_MESSAGE_FILE_LOCATION, 'split_xml', 'w', settings.ENCODING)
        fh.write(cElementTree.tostring(elem))
        fh.close()


if __name__ == "__main__":
    kwargs = {'location': 'c:\\Source_files\\',
              'filename': settings.XML_FILE,
              'project':'wiki',
              'language_code':'en'
              }
    split_xml(**kwargs)
