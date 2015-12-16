<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel-"stylesheet" href="css/formValidation.min.css">
   <link rel="shortcut icon" href="images/logo.png">
   <title>SeqKor</title>
   <script type="text/javascript" src="js/jquery.min.js"></script>
   <!-- Bootstrap JS -->
   <script src="js/bootstrap.min.js"></script>
   <!-- FormValidation plugin and the class supports validating Bootstrap form -->
   <script src="js/formValidation.js"></script>
   <script src="js/framework/bootstrap.min.js"></script>
</head>

<body>
   <div id="wrapper">
   <!-- Sidebar -->
      <div id="sidebar-wrapper">
         <ul class="sidebar-nav">
            <li class="sidebar-brand">
               <a href="index.php">
                  <h2>SeqKer</h2>
               </a>
            </li>
            <li>
               <a href="index.php">Home</a>
            </li>
            <li>
               <a href="form.php">Training and Prediction</a>
            </li>
            <li>
               <a href="userguide.php">User Guide</a>
            </li>
            <li>
               <a href="about.php">About SeqKer</a>
            </li>
            <li>
               <a href="references.php">References</a>
            </li>
            <li>
               <a href="contact.php">Contact</a>
            </li>
         </ul>
      </div>
      <!-- end sidebar wrapper -->

   <!-- Page Content -->
      <div id="page-content-wrapper">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-4">
                  <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <h1>User Guide</h1>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <p><b>Form Submission Details</b></p>
                  <p>The SeqKer analysis consists of three steps. First, users will choose whether they want to visualize a DNA or protein
                  sequence of interest. In this step, it is also necessary to indicate the length of the sequence, with the maximum length
                  being 1000 bp, as shown in Figure 1.</p>
                  <img src="/images/Figure1.png">
                  <p>Then, users will input the experimental data. Different genomic regions of the selected transcript can be chosen.
                  When the sequences of interest have been examined, the sequence site coordinates for training and prediction are entered
                  in the bottom section of the user interface window shown in Figure 2. In this section, the user enters, in line, the DNA or
                  protein binding data for each sequence variant, estimating the relative degree of protein binding on a scale of 1,
                  maximal, to –1, minimal.</p>
                  <img src="/images/Figure2.png">
                  <p>A sequence in FASTA format begins with a single-line description, followed by lines of sequence data.
                  The description line (defline) is distinguished from the sequence data by a greater-than (">") symbol at the beginning.
                  It is recommended that all lines of text be shorter than 80 characters in length. In Figure 3, there is an illustration of how
                  these experimental data are entered into the proper boxes of the field “Custom site coordinates” for training and
                  prediction. For every gene, all possible transcript variants are listed with a link to the genomic
                  location. This way, the sequences can be analyzed for regulatory differences.</p>
                  <img src="/images/Figure3.png">
                  <p>Lastly, the “Submit” button should be clicked, following which the calculated values will appear in separate and
                  downloadable text and HTML files that are sent directly to the user via email. A single TF may be predicted to bind. In
                  the case where several TFs are predicted, the relevant matches and closeness of fit to the data are evident in the
                  statistical analysis windows. The user can inspect the result of the analysis through a color-coded graphical interface
                  and identify the number of positive and negative results.</p>
                  <p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Menu Toggle Script -->
   <script>
      $("#menu-toggle").click(function(e) {
         e.preventDefault();
         $("#wrapper").toggleClass("toggled");
      });
   </script>

</body>
<html>
