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
                  <h1>Welcome to SeqKer Tool</h1>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <p>The Kernel-based tool for transcription factor binding prediction</p>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <p>SeqKer is a virtual laboratory and Kernel-based tool for the identification, prediction and training of
                  transcription factorbinding sites (TFBS) from a species or groups of species of interest. The user can
                  inspect the result of the search through a graphical HTML interface and downloadable text files. SeqKer is
                  developed and maintained by the <a href="http://www.cs.virginia.edu/yanjun/index.htm">University of Virginia
                  Department of Computer Science.</a> To begin, click below.
                  </p>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <a href="form.php" class="btn btn-primary">Begin</a>
               </div>
            </div>
         <div>
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
</html>
