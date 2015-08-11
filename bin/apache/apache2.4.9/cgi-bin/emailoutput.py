#!c:\Python34\python.exe
import os
import glob
import re
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email.mime.text import MIMEText
from email import encoders

def get_address(name, in_path):
    address = ""        # path must be folder in harddrive
    in_path += "/%s/%s_info.txt" % (name, name)
    files = glob.glob(in_path)   # glob gets the full path up to *_info.txt as array
    for in_file in files:
        f = open(in_file, 'r')
        address = re.search(r"Email:\s(.*)", f.read()).group(1)
    return address
    f.close()

def send_attachment(fromaddr, password, toaddr, path):
    msg = MIMEMultipart()
    msg['From'] = fromaddr
    msg['To'] = toaddr
    msg['Subject'] = "Job Completed"
     
    body = "Attachment enclosed."
    msg.attach(MIMEText(body, 'plain'))

    filename = "Prediction"
    attachment = open(path, "rb")
     
    part = MIMEBase('application', 'octet-stream')
    part.set_payload((attachment).read())
    encoders.encode_base64(part)
    part.add_header('Content-Disposition', "attachment; filename= %s" % filename)
     
    msg.attach(part)
     
    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.starttls()
    server.login(fromaddr, password)
    text = msg.as_string()
    server.sendmail(fromaddr, toaddr, text)
    server.quit()

# temp paths
out_path = "C:/wamp/www/output"
in_path = "C:/wamp/www/data"
out_dirs = sorted(os.listdir(out_path))
in_dirs = sorted(os.listdir(in_path))

for out_file in out_dirs:
    name = out_file.split(".")[0]  # file.txt
    if name in in_dirs:
        email = get_address(name, "C:/wamp/www/data")
        path = out_path + "/%s.txt" % name
        send_attachment("bryan.chenjin@gmail.com", "thepianist1", email, path)