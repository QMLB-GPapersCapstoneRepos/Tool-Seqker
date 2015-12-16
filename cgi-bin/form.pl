#!c:\wamp\bin\perl\bin\perl.exe
use strict;
use warnings FATAL => "all";
use CGI qw(:standard);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use File::Basename;

my $q = new CGI;

# redirect to submitted page, which will be redirected to form page.
my $url = "http://qdata.cs.virginia.edu/submitted.php";
print CGI::redirect($url);

print CGI::header();
print start_html("Form Submitted");

sub getLoggingTime {
    my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime(time);
    my $time = sprintf ("%04d%02d%02d%02d%02d%02d",$year+1900,$mon+1,$mday,$hour,$min,$sec);
    return $time;
}

my $timestamp = getLoggingTime();

# make directory in data, need to change
my $dir = "/var/www/svm-v1/data/input/$timestamp/"; 			# exporting and uploading file to the following directory
mkdir $dir unless -d $dir; 							# Check if dir exists. If not create it.
my $infofn = $timestamp . ".info.txt";				#info file for form info

# retrieving fields
open my $infofh, ">", "$dir/$infofn" or die "Can't open $dir/$infofn $!";
my $firstname = $q->param('firstname');
my $lastname = $q->param('lastname');
my $email = $q->param('email');
my $institution = $q->param('institution');
my $seqlength = $q->param('seqlength');
my $typedna = $q->param('typedna');
my $typeprotein = $q->param('typeprotein');
my $seqtype = "";
if (defined $typedna) {
	$seqtype = "DNA";
}
if (defined $typeprotein) {
	$seqtype = "Protein"
}

# writing to file
print $infofh "Name: $firstname $lastname\n";
print $infofh "Email: $email\n";
if (defined $institution) {
	print $infofh "Institution: $institution\n\n";
} else {
	print $infofh "Institution: ";
}
close $infofh;

# Writing to training file, need to test for file
my $training = $q->param('training_field');
my $trainfn = $timestamp . ".train.fasta";
# my $upload_tfname = $q->param('training_file')

if (defined $training) {							# if test if the field has text value
	# create a new file and name it jobid.train.txt because user input field
	open my $trainfh, ">", "$dir/$trainfn" or die "Can't open $dir/$trainfn $!";
	print $trainfh "$training";
	close $trainfh;
}
# if (defined $upload_tfname) {
# 	# user instead uploaded a file
# 	$upload_tfname =~ tr/ /_/;
# 	my ($tname, $tpath, $textension) = fileparse($upload_tfname, '..*');
# 	$upload_tfname = $tname . $textension;
# 	my $upload_tfh = $q->upload("training_file");
# 	open(UPLOAD_TF, ">", "$dir/$trainfn") or die "Can't open $dir/$trainfn $!";
# 	binmode UPLOAD_TF;
# 	while(<$upload_tfh>) {
# 		print UPLOAD_TF;
# 	}
# 	close UPLOAD_TF;
# }

# Writing to predicting file, need to test for file
my $prediction = $q->param('prediction_field');
my $predictfn = $timestamp . ".test.fasta";
# my $upload_pfname = $q->param('prediction_file');

if (defined $prediction) {
	open my $predictfh, ">", "$dir/$predictfn" or die "Can't open $dir/$predictfn $!";
	print $predictfh "$prediction";
	close $predictfh;
}
# if (defined $upload_pfname) {
# 	$upload_pfname =~ tr/ /_/;
# 	my ($pname, $ppath, $pextension) = fileparse($upload_pfname, '..*');
# 	$upload_pfname = $pname . $pextension;
# 	my $upload_pfh = $q->upload("prediction_file");
# 	open(UPLOAD_PF, ">", "$dir/$upload_pfname") or die "Can't open $dir/$upload_pfname $!";
# 	binmode UPLOAD_PF;
# 	while(<$upload_pfh>) {
# 		print UPLOAD_PF;
# 	}
# 	close UPLOAD_PF;
# }

# run python script
my $pydir = "/var/www/py";
my $pycmd = "python $pydir/process.py $email $timestamp $seqtype $seqlength";
system($pycmd);


print end_html;
