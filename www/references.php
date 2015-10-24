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
               <a href="form.php">Prediction and Training</a>
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
               <a href="recentjobs.php">Recent Jobs</a>
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
                  <h2></h2>
                  <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <h1>References</h1>
                  <p>Authors and citations, how to cite SeqKer. To be updated. Please check back later.</p>
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
