<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width" />
   <link rel="stylesheet" type="text/css" href="stylesheets/styles.css">
   <link rel="shortcut icon" href="images/favicon.gif">
   <title>SeqKor</title>
   <script type="text/javascript" src="scripts/script.js"></script>
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
               <a href="index.php" style="color: #4A5928;text-shadow: 0 -2px 2px #bdcd9c;"><span>Home</span></a>
            </li>
            <li id="menu-about"><a href="about.php"><span>About</span></a></li>
            <li id="menu-userguide"><a href="userguide.php"><span>User Guide</span></a></li>
            <li id="menu-references"><a href="references.php"><span>References</span></a></li>
            <li id="menu-contact"><a href="contact.php"><span>Contact</span></a></li>
         </ul>
      </section>
      <article align="center">
         <h2>Data Submission Form</h2>
         <table>
            <tr>
               <td>
                  <form enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="/cgi-bin/form.cgi">
                     <ul class="submission-form" id="fields" align="center">
                        <li>
                           <span class="required">* Denotes Required Field</span>
                        </li>
                        <li>
                           <label>Full Name<span class="required">*</span></label><input type="text" id="firstname" placeholder="First" class="field-divided"/>&nbsp;<input type="text" id="lastname" placeholder="Last" class="field-divided"/>
                        </li>
                        <li><label>Email<span class="required">*</span></label><input type="email" id="email" class="field-long" /></li>
                        <li>
                           <label>Institution<span class="required">*</span></label><input type="text" id="institution" class="field-long"/>
                        </li>
                        <li>
                           <label>
                              Paste positive site coordinates for training in BED format:<span class="required">*</span>
                           </label>
                           <textarea name="training_field" class="field-long field-textarea"></textarea>
                        </li>
                        <li>
                           <label>Or submit a file in BED format:</label>
                           <input name="training_file" size=64 type="file">
                        </li>
                        <li><label>Genome<span class="required">*</span></label>
                           <select name="training_genome" class="field-select" style="font: 16px 'calibri light';">
                              <option style="font: 16px 'calibri light';" value="Human">Human</option>
                              <option style="font: 16px 'calibri light';" value="Mouse">Mouse</option>
                           </select>
                        </li>
                        <li>
                           <label>
                              Paste positive site coordinates for TF prediction in BED format:<span class="required">*</span>
                           </label>
                           <textarea name="prediction_field" class="field-long field-textarea"></textarea>
                        </li>
                        <li>
                           <label>Or submit a file in BED format:</label>
                           <input name="prediction_file" size=64 type="file">
                        </li>
                        <li><label>Genome<span class="required">*</span></label>
                           <select name="prediction_genome" class="field-select" style="font: 16px 'calibri light';">
                              <option style="font: 16px 'calibri light';" value="Human">Human</option>
                              <option style="font: 16px 'calibri light';" value="Mouse">Mouse</option>
                           </select>
                        </li>
                        <li>
                           <input type="submit" value="Submit" onClick="return validate();" style="font: 18px 'calibri light';"/>
                           &nbsp;&nbsp;<input type="reset" value="Clear" style="font: 18px 'calibri light';"/>
                        </li>
                        <li><input type="button" value="Back" onClick="history.back();return false;" style="font: 18px 'calibri light';"></li>
                     </ul>
                  </form>
               </td> 
            </tr>
         </table>
      </article>
   </div>   
   <center><h3>Developed in <a href="http://www.cs.virginia.edu/yanjun/index.htm">CS Dept @ UVa</a></h3></center>
</body>
</html>
