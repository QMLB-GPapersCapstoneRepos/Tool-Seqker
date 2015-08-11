#!c:\wamp\bin\perl\bin\perl.exe
use strict;
use warnings FATAL => "all";
use CGI qw(:standard);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use File::Basename;
use Mail::Sendmail;

my $q = new CGI;
# $CGI::POST_MAX = 1024 * 2000;	# max 2 MB size
print CGI::header();
print start_html("Form Submitted");
# print $q->redirect(-url=>'http://localhost:8000/redirect.php/');
# print "Location: http://localhost:8000/redirect.php/\n\n";

sub getLoggingTime {
    my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime(time);
    my $time = sprintf ("%04d%02d%02d%02d%02d%02d",$year+1900,$mon+1,$mday,$hour,$min,$sec);
    return $time;
}

my $timestamp = getLoggingTime();
my $infofn = $timestamp . "_info.txt";
my $trainfn = $timestamp . "_train.txt";
my $predictfn = $timestamp . "_predict.txt";

# uploading file
my $upload_dir = "C:/wamp/www/upload/$timestamp";
mkdir $upload_dir unless -d $upload_dir;
my $trainingfn = $q->param('training_file');
$trainingfn =~ tr/ /_/;
my ($tname, $tpath, $textension) = fileparse($trainingfn, '..*');
$trainingfn = $tname . $textension;
my $upload_tfh = $q->upload("training_file");
open(UPLOAD_TF, ">", "$upload_dir/$trainingfn") or die "Can't open $upload_dir/$trainingfn $!";
binmode UPLOAD_TF;
while(<$upload_tfh>) {
	print UPLOAD_TF;
}
close UPLOAD_TF;

my $predictionfn = $q->param('prediction_file');
$predictionfn =~ tr/ /_/;
my ($pname, $ppath, $pextension) = fileparse($predictionfn, '..*');
$predictionfn = $pname . $pextension;
my $upload_pfh = $q->upload("prediction_file");
open(UPLOAD_PF, ">", "$upload_dir/$predictionfn") or die "Can't open $upload_dir/$predictionfn $!";
binmode UPLOAD_PF;
while(<$upload_pfh>) {
	print UPLOAD_PF;
}
close UPLOAD_PF;

# exporting file
my $dir = "C:/wamp/www/data/$timestamp/";
mkdir $dir unless -d $dir; # Check if dir exists. If not create it.

# Writing to info file
open my $infofh, ">", "$dir/$infofn" or die "Can't open $dir/$infofn $!";
my $firstname = $q->param('firstname');
my $lastname = $q->param('lastname');
my $email = $q->param('email');
my $institution = $q->param('institution');
print $infofh "Name: $firstname $lastname\n";
print $infofh "Email: $email\n";
print $infofh "Institution: $institution";
close $infofh;

# Writing to training file, need to test for file
open my $trainfh, ">", "$dir/$trainfn" or die "Can't open $dir/$trainfn $!";
my $training = $q->param('training_field');
my $training_genome = $q->param('training_genome');
my $training_celltype = $q->param('training_celltype');
my $training_tf = $q->param('training_tf');
print $trainfh "Genome: $training_genome\n";
print $trainfh "Cell type: $training_celltype\n";
print $trainfh "TF: $training_tf\n\n";
print $trainfh "$training";
close $trainfh;

# Writing to predicting file, need to test for file
open my $predictfh, ">", "$dir/$predictfn" or die "Can't open $dir/$predictfn $!";
my $prediction = $q->param('prediction_field');
my $prediction_genome = $q->param('prediction_genome');
my $prediction_celltype = $q->param('prediction_celltype');
my $prediction_tf = $q->param('prediction_tf');
print $predictfh "Genome: $prediction_genome\n";
print $predictfh "Cell type: $prediction_celltype\n";
print $predictfh "TF: $prediction_tf\n\n";
print $predictfh "$prediction";
close $predictfh;
print end_html;
# print "Content-type: text/html\n\n";
# print <<ENDHTML;
# <!doctype html>
# <html>
# <head>
#    <meta charset="utf-8">
#    <meta name="viewport" content="width=device-width" />
#    <link rel="stylesheet" type="text/css" href="stylesheets/styles.css">
#    <link rel="shortcut icon" href="images/favicon.gif">
#    <title>Form Submitted</title>
#    <script type="text/javascript" src="scripts/script.js"></script>
#    <IfModule mod_rewrite.c>
#        RewriteEngine On
#        # Removes index.php from ExpressionEngine URLs
#        RewriteCond $1 !\.(gif|jpe?g|png)$ [NC]
#        RewriteCond %{REQUEST_FILENAME} !-f
#        RewriteCond %{REQUEST_FILENAME} !-d
#        RewriteRule ^(.*)$ /index.php/$1 [L]
#    </IfModule>
# </head>

# <body>
#    <header>
#       <h1><i>SeqKer</i></h1>
#       <h2><i>Kernel based tool for TF binding prediction</i></h2>
#    </header>   

#    <div class="page width">
#       <section id="menu">
#          <ul>
#             <li id="menu-home" style="background: #89A34E;border-top-left-radius:20px;border-top-right-radius: 20px;">
#                <a href="http://localhost:8000/index.php" style="color: #4A5928;text-shadow: 0 -2px 2px #bdcd9c;"><span>Home</span></a>
#             </li>
#             <li id="menu-about"><a href="about.php"><span>About</span></a></li>
#             <li id="menu-userguide"><a href="userguide.php"><span>User Guide</span></a></li>
#             <li id="menu-references"><a href="references.php"><span>References</span></a></li>
#             <li id="menu-contact"><a href="contact.php"><span>Contact</span></a></li>
#          </ul>
#       </section>
#       <article align="center">
#          <h2>Thank you. Your form has been submitted. </h2>
#       </article>
#    </div>   
#    <center><h3>Developed in <a href="http://www.cs.virginia.edu/yanjun/index.htm">CS Dept @ UVa</a></h3></center>
# </body>
# </html>

# ENDHTML;
