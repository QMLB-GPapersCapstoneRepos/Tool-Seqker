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
                  <h1>About SeqKer</h1>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  	<p><b>User Base</b></p>
					<p>The SeqKer web server draws upon many aspects of molecular biotechnology and will be applicable for the use of
					laboratory techniques to study and modify nucleic acids and proteins. Molecular biotechnology results from the
					convergence of many areas of research, such as molecular biology, genetics, and machine learning. SeqKer’s targeted
					user base includes researchers in the field of molecular biotechnology and in areas such as human and animal health,
					agriculture, and the environment.</p>
					<p>To be able to accurately predict potentially functional transcription factor
					binding sites (TFBS) is an important first step for SeqKer’s success. This way, the targeted user base will utilize
					SeqKer’s functionality because transcription factors are important gene regulators with distinctive roles in
					development, cell signaling and cell cycling.</p>

					<p><b>Technical Details</b></p>
					<p>SeqKer is based on a client-server architecture featuring a server backend for the functionality and a browser-based
					frontend for the user interface. The application is currently hosted, developed and tested locally on the Windows Apache
					MySQL PHP server stack. The hosting environment will be configured by qdata services on a university-owned Apache2 web
					server. Once testing is complete, the application will be migrated from the production server to the hosting environment,
					so moderations to the apache2.conf file will need to be configured before deployment of the application.</p>
					<p>The frontend, or client-side, was built on top of a design template using HTML, CSS and JavaScript and uses the
					Bootstrap frontend framework primarily for typography, forms, buttons, navigation and other interface components. The
					frontend is responsible for displaying the user-friendly data submission form and application information and handling
					form validation. The backend was developed using Python, Perl and Shell and utilizes Kernel-based machine learning
					algorithms for training and testing the experimental data, following which the calculated scores will appear in separate
					and downloadable text and color-coded HTML files that are sent directly to the user via email.</p>
					<p>When the form is submitted, the standard input is passed into the CGI program. The web server runs the CGI program
					using the POST method, which is specified in the ACTION parameter in the form’s HTML, and redirects the user to the main data
					submission page. The CGI object stores the values for all the form fields and parameters specified in the URL. The fields
					return scalar values in the form of a text string, which are accessed with the defined param() method to verify the selected
					value.</p>
					<p>The training and prediction fields store the input DNA or protein binding data for each sequence variant, estimating
					the relative degree of protein binding on a scale of 1, maximal, to –1, minimal. When the CGI program is run, the training
					and testing data are written into two timestamped text files, respectively, located in the input data directory, later to be
					retrieved and analyzed.</p>
					<p>The Python script takes the following arguments: the email address of the user of which the files will be sent to, the
					timestamp or job identification number of the user, the sequence type, and the sequence length. Taking the information, the
					Python script runs the required Shell script based on the sequence type, which leads into running the backend C script algorithms
					located in the SVM-v1 folder.</p>
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
