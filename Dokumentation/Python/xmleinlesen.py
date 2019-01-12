#!/usr/bin/env python3
# XML Einlesen fuer jeweiligen benutzer

#einlesen der xml.etree-libary
import xml.etree.ElementTree as ET

def einlesen():
    tree = ET.parse('interface.xml')
    root = tree.getroot()
    return root