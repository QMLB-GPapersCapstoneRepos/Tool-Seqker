#!c:\Python34\python.exe
import os
import re
import smtplib
import shlex
import subprocess
import os.path
import sys
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email.mime.text import MIMEText
from email import encoders
import multiprocessing
import time

if len(sys.argv) < 5: 
    # [0] is script name, [1] is email, [2] is jobID/timestamp, [3] dna or protein, [4] seqlength
    print("Usage: process.py email jobid dna/protein seqlength")
    sys.exit(1)

def run(arg):
    try:
        subprocess.Popen(arg, shell=True)
    except:
        print("Unexpected error:", sys.exc_info()[0])
        raise

def send_attachment(fromaddr, password, toaddr, html_path, txt_path):
    msg = MIMEMultipart()
    msg['From'] = fromaddr
    msg['To'] = toaddr
    msg['Subject'] = "Job Completed ID: %s" % sys.argv[2]
    body = "Attachments enclosed."
    msg.attach(MIMEText(body, 'plain'))
    
    # name the file with timestamp and open the paths as attachments
    filenames = [html_path, txt_path]
    
    # get all the attachments and encode
    for filename in filenames:
        part = MIMEBase('application', 'octet-stream')
        attachment = open(filename)
        part.set_payload((attachment).read())
        encoders.encode_base64(part)
        part.add_header('Content-Disposition', "attachment; filename= %s" % filename)
        msg.attach(part)
    
    # send using smtplib server
    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.starttls()
    server.login(fromaddr, password)
    text = msg.as_string()
    server.sendmail(fromaddr, toaddr, text)
    server.quit()

def bufcount(filename):
    with open(filename) as f:                
        lines = sum(1 for line in f if line.rstrip('\n'))
    return (lines / 2)

def to_html(in_file, out_file):
    try:
        with open(in_file, "r") as f:
            lines = [line.strip('\n') for line in f]
            htmlfile = open(out_file, "w+")

            # track no. of positive and negative site coordinates
            pos = 0
            neg = 0

            htmlfile.write('<html>\n<head>\n')
            htmlfile.write('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\n')
            htmlfile.write('<meta name="viewport" content="width=device-width" />\n')
            htmlfile.write('<title>JOB ID: '+sys.argv[2]+'</title>\n</head>\n\n')  # head of html file
            htmlfile.write('<body style="max-width: 600px; margin: auto">\n<div align="center">\n')
            htmlfile.write('<h1>SeqKer Prediction Results</h1>\n')
            htmlfile.write('<h2>Job ID: '+sys.argv[2]+'</h2>\n</div>')
            htmlfile.write('<div><table border="1">\n')  # write body tag

            # writing Location/Score header
            htmlfile.write('<tr>')
            htmlfile.write('<th style="width: 500px; padding: 15px"><b>Location</b></th>')  # First row defines header
            htmlfile.write('<th style="width: 100px; padding: 15px"><b>Score</b></th>')
            htmlfile.write('</tr>')

            # regex for parsing location and score
            p = re.compile('(chr[0-9A-Za-z]+:[0-9]+-[0-9]+)\t([0-9\-]+)')
            
            # writing lines from file
            for row in lines:
                htmlfile.write('<tr>')
                m = p.match(row)
                loc = m.group(1)
                score = m.group(2)
                htmlfile.write('<td style="width: 500px; padding: 8px">'+loc+'</td>')
                try:
                    if int(score) == 0:
                        color = "#1975D1"  # blue
                    elif int(score) < 0:
                        color = "#CC2900"  # red
                        neg += 1
                    else:
                        color = "#19A347"  # green
                        pos += 1
                    htmlfile.write('<td style="width: 100px; padding: 8px; background-color: '+color+'">'+score+'</td>')
                except ValueError:
                    print("Could not convert data to an integer.")
                htmlfile.write("</tr>")

            # end of rows
            htmlfile.write('</table>\n</div>\n')
            htmlfile.write('<div>\n')
            htmlfile.write('<h2><center>Summary Report<center></h2>')
            htmlfile.write('<p>Number of positive site coordinates: '+str(pos)+'<p>')
            htmlfile.write('<p>Number of negative site coordinates: '+str(neg)+'<p>')
            htmlfile.write('</div>')
            htmlfile.write('</body>\n')
            htmlfile.write('</html>')
    except IOError as e:
        print("HTML File not found: "+e.reason)

if __name__ == "__main__":
    # read input file
    indir = "../svm-v1/data/input/"+sys.argv[2]
    pred_filename = sys.argv[2]+".test.fasta"
    train_filename = sys.argv[2]+".train.fasta"

    while not os.path.isdir(indir):
        time.sleep(1)

    # change to input directory
    if os.path.isdir(indir):
        os.chdir(indir)

    # check if input files are ready and exist after uploading, if not then sleep
    while not os.path.exists(pred_filename) and not os.path.exists(train_filename):
        time.sleep(1)
    if os.path.exists(pred_filename) and os.path.exists(train_filename):
        nsamp = bufcount(train_filename)  #int value of number of lines of training file divided by 2
        ntest = bufcount(pred_filename)  #int value of number of lines of prediction file divided by 2
        os.chdir("../../../")  # to svm-v1 folder

        if sys.argv[3] == "DNA":
            # if DNA sequence, run DNA shell
            command = "sh RunCode_DNA.sh "+sys.argv[2]+" "+str(nsamp)+" "+str(ntest)+" "+sys.argv[4]
            run(command)
        if sys.argv[3] == "Protein":
            # if protein sequence, run protein shell
            command = "sh RunCode_Protein.sh "+sys.argv[2]+" "+str(nsamp)+" "+str(ntest)+" "+sys.argv[4]
            run(command)
    
    email = sys.argv[1]
    html_filename = "PRED.html"
    txt_filename = "PRED.txt"

    # change to output dir
    outdir = "data/output/"+sys.argv[2]
    while not os.path.isdir(outdir):
        time.sleep(1)
    if os.path.isdir(outdir):
        os.chdir(outdir)

    # convert text to html file, test for timeout
    attempts=0
    timeout=20
    while not os.path.exists(txt_filename):
        if attempts < timeout:
            time.sleep(30)
            attempts+=1
        else:
            break

    if os.path.isfile(txt_filename):
        to_html(txt_filename, html_filename)
    else:
        raise ValueError("%s is not a proper file" % txt_filename)

    # send html and txt files, test for timeout
    attempts=0
    timeout=20
    while not os.path.exists(html_filename):
        if attempts < timeout:
            time.sleep(30)
            attempts+=1
        else:
            break

    # send email attachments
    if os.path.isfile(html_filename) and os.path.isfile(txt_filename):
        send_attachment("seqkertool@gmail.com", "Classof2018", email, html_filename, txt_filename)
