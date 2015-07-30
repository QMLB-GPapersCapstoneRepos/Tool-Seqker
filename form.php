<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width" />
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="stylesheets/styles.css">
   <link rel="shortcut icon" href="images/logo.png">
   <title>SeqKor</title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="scripts/script.js"></script>
   <script type="text/javascript">
		function createOptions(id1, id2, id3) {
			var sel1=document.getElementById(id1);
			var sel2=document.getElementById(id2);
			var sel3=document.getElementById(id3);

			while(sel2.options.length) {
			   sel2.remove(0);
			}
			while(sel3.options.length) {
				sel3.remove(0);
			}

			if(sel1.options[sel1.selectedIndex].value == "Human") {
			   var options = ["","GM12878","K562"];
			   var tfoptions = ["","CTCF","JUND"];
			} else if(sel1.options[sel1.selectedIndex].value == "Mouse") {
			   var options = ["","CH12", "MEL"];
			   var tfoptions = ["", "CTCF", "GABP"];
			}

			for(var option of options) {
			   var newOption=document.createElement("option");
			   newOption.text=option;
			   sel2.add(newOption);
			}
			for(var tfoption of tfoptions) {
			   var newOption=document.createElement("option");
			   newOption.text=tfoption;
			   sel3.add(newOption);				
			}
		}
   </script>
</head>

<body>
   <div class="header">
      <img src="images/logo.png" alt="logo">
      <h1>SeqKer</h1>
      <h2>Kernal-based tool for TF-binding prediction</h2>
   </div>

   <div class="menu">
   <ul>
      <li id="menu-home"><a href="index.php"><span>Home</span></a></li>
      <li id="menu-about"><a href="about.php"><span>About</span></a></li>  
      <li id="menu-userguide"><a href="userguide.php"><span>User Guide</span></a></li>
      <li id="menu-references"><a href="references.php"><span>References</span></a></li>
      <li id="menu-recentjobs"><a href="recentjobs.php"><span>Recent Jobs</span></a></li>
   </ul>
   </div>

   <div class="content">
	  <form class="submission-form" enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="/cgi-bin/form.cgi">
		 <fieldset>
		 <h1>Data Submission Form</h1>
		 <ul id="fields" align="center">
			<li>
			   <span class="required">* Denotes Required Field</span>
			</li>
			<li>
			   <label>Full Name<span class="required">*</span></label><input type="text" name="firstname" id="firstname" class="field-divided"/><input type="text" name="lastname" id="lastname" class="field-divided"/>
			</li>
			<li>
				<label>Email<span class="required">*</span></label><input type="email" name="email" id="email" class="field-long" />
			</li>
			<li>
			   <label>Institution</label><input type="text" name="institution" id="institution" class="field-long"/>
			</li>
			<li><label>Select training data:</label>
				<table class="field-select">
					<tr>
						<td>
							<label>Genome</label>
						   <select name="training_genome" id="training_genome" class="field-select" onclick="createOptions(this.id, 'training_celltype', 'training_tf');">
							  <option value=""></option>
							  <option value="Human">Human</option>
							  <option value="Mouse">Mouse</option>
						   </select>
						</td><td>
							<label>Cell Type</label>
						   <select name="training_celltype" id="training_celltype" class="field-select"></select>
						</td><td>
							<label>Transcription Factor</label>
						   <select name="training_tf" id="training_tf" class="field-select"></select>
						</td>
					</tr>
			   </table>
			</li>
			<li><label>Select prediction data:<span class="required">*</span></label>
				<table class="field-select">
					<tr>
						<td>
							<label>Genome</label>
						   <select name="prediction_genome" id="prediction_genome" class="field-select" onchange="createOptions(this.id, 'prediction_celltype', 'prediction_tf');">
							  <option value=""></option>
							  <option value="Human">Human</option>
							  <option value="Mouse">Mouse</option>
						   </select>
						</td><td>
							<label>Cell Type</label>
						   <select name="prediction_celltype" id="prediction_celltype" class="field-select"></select>
						</td><td>
							<label>Transcription Factor</label>
						   <select name="prediction_tf" id="prediction_tf" class="field-select"></select>
						</td>
					</tr>
			   </table>
			</li>
			<li>
				<label>Upload site coordinates for transcription factor prediction:<span class="required">*</span></label>
			   <textarea name="prediction_field" id="prediction_field"class="field-long field-textarea"></textarea>
			</li>
			<li>
			   <label>Or submit a file (BED format only):</label>
			   <input name="prediction_file" id="prediction_file" size=64 type="file">
			</li>
			<li>
			   <label>Upload custom training site:</label>
			   <textarea name="training_field" id="training_field" class="field-long field-textarea"></textarea>
			</li>
			<li>
			   <label>Or submit a file (BED format only):</label>
			   <input name="training_file" id="training_file" size=64 type="file">
			</li>
			<li>
			   <input type="submit" value="Submit" onClick="return processForm();"/>&nbsp;&nbsp;<input type="reset" value="Clear"/>
			</li>
		 </ul>
		 </fieldset>
	  </form>
   </div>
</body>
</html>