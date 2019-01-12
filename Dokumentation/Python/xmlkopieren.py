#!/usr/bin/env python3
import urllib.request

url = 'http://www.heiztechnik-profi.de/raspi/interface.xml'
urllib.request.urlretrieve(url, 'interface.xml')
