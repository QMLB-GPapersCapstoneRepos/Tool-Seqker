#!usr/bin/python
import cgi
import os
import re
import cgitb

cgitb.enable()

print("Content-type: text/html")
# os.chdir('../files/')
# with open("file.txt", "r") as f:
formdata = cgi.FieldStorage()
firstname = formdata.getValue("firstname", "")
print(firstname)
