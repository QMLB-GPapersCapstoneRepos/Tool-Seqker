<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width" />
   <link rel="stylesheet" type="text/css" href="stylesheets/styles.css">
   <link rel="shortcut icon" href="images/favicon.gif">
   <title>Form Submitted</title>
   <script type="text/javascript" src="scripts/script.js"></script>
   <IfModule mod_rewrite.c>
       RewriteEngine On
       # Removes index.php from ExpressionEngine URLs
       RewriteCond $1 !\.(gif|jpe?g|png)$ [NC]
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ /index.php/$1 [L]
   </IfModule>
</head>

<body>
   <header>
      <h1><i>SeqKer</i></h1>
      <h2><i>Kernel based tool for TF binding prediction</i></h2>
   </header>   

   <div class="page width">
      <section id="menu">
         <ul>
            <li id="menu-home" style="background: #89A34E;border-top-left-radius:20px;border-top-right-radius: 20px;">
               <a href="http://localhost:8000/index.php" style="color: #4A5928;text-shadow: 0 -2px 2px #bdcd9c;"><span>Home</span></a>
            </li>
            <li id="menu-about"><a href="about.php"><span>About</span></a></li>
            <li id="menu-userguide"><a href="userguide.php"><span>User Guide</span></a></li>
            <li id="menu-references"><a href="references.php"><span>References</span></a></li>
            <li id="menu-contact"><a href="contact.php"><span>Contact</span></a></li>
         </ul>
      </section>
      <article align="center">
         <h2>Thank you. Your form has been submitted. </h2>
      </article>
   </div>   
   <center><h3>Developed in <a href="http://www.cs.virginia.edu/yanjun/index.htm">CS Dept @ UVa</a></h3></center>
</body>
</html>
