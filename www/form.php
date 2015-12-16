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
					<h1>Training and Prediction Data</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<span class="required">* Denotes Required Field</span>
				</div>
			</div>
			<form id="submission-form" enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="/cgi-bin/form.pl">
				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<label class="control-label">Full name<span class="required">*</label>
						</div>
						<div class="col-xs-6">
							<input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" />
						</div>
						<div class="col-xs-6">
							<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<label class="control-label">Email<span class="required">*</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email address" />
						</div>
					</div>
				</div>	

				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<label class="control-label">Institution</label>
							<input type="text" class="form-control" name="institution" id="institution" placeholder="Name of institution" />
						</div>
					</div>
				</div>

				<!-- Sequence type -->
				<div class="row">
					<div class="form-group">
						<div class="col-xs-6">
							<div class="btn-group" data-toggle="buttons">
								<label class="control-label">Type of sequence<span class="required">*</label>
								<label class="btn btn-default"><input type="radio" class="form-control" name="seqtype" id="typeprotein">Protein</label>
								<label class="btn btn-default"><input type="radio" class="form-control" name="seqtype" id="typedna">DNA</label>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="control-label">Maximum length of sequence<span class="required">*</label>
							<input type="text" class="form-control" name="seqlength" id="seqlength" placeholder="e.g., 100" />
						</div>
					</div>
				</div>

				<!-- Training -->
				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<label class="control-label">Custom site coordinates for training (FASTA format only)<span class="required">*</label>
							<textarea name="training_input" id="training_field" class="form-control training" placeholder="e.g., DNA: >chr1:20834611-20834711|1  CGGCCTAACCTGACCGGAAACTCGA"></textarea>
						</div>
					</div>
				</div>

				<!-- Prediction -->
				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<label class="control-label">Custom site coordinates for prediction (FASTA format only)<span class="required">*</label>
							<textarea name="prediction_input" id="prediction_field" class="form-control prediction" placeholder="e.g., Protein: >-1  ADMSKLISL"></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-primary">Clear</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Menu Toggle Script -->
<script>
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
</script>

<!-- Form Validation Script -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#submission-form').formValidation({
			framework: 'bootstrap', // validating Bootstrap form

			icon: { // Feedback icons
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},	
			
			excluded: ':disabled',
			fields: { // list of fields and validation rules
				firstname: {
					validators: {
						notEmpty: {
							message: 'The first name is required'
						}
						regexp: {
							regexp: /^[a-z\s]+$/,
							message: 'The first name can consist of alphabetical characters and spaces only'
						}
					}
				},
				lastname: {
					validators: {
						notEmpty: {
							message: 'The last name is required'
						}
						regexp: {
							regexp: /^[a-z\s]+$/,
							message: 'The last name can consist of alphabetical characters and spaces only'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'The email address is required'
						},
						emailAddress: {
							message: 'The input is not a valid email address'
						}
					}
				},
				institution: {
					validators: {
						regexp: {
							regexp: /^[a-z\s]+$/,
							message: 'The institution name can consist of alphabetical characters and spaces only'
						}
					}
				}
				seqtype: {
					validators: {
						notEmpty: {
							message: 'The sequence type is required'
						}
					}
				}
				seqlength: {
					validators: {
						notEmpty: {
							message: 'The sequence length is required'
						}
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'The input is not a valid sequence length'
						}
					}
				}
				training_input: {
					selector: '.training',
					validators: {
						regexp: {
							regexp: /^\s*>\s*chr(.+)\s*$/,
							message: 'Please enter a sequence or upload a file in FASTA format only'
						} 
						callback: {
							message: 'The input sequence for training is required',
							callback: function(value, validator, $field) {
								var isEmpty = true,
								$fields = validator.getFieldElements('training_input'); // Get the list of fields
								for (var i = 0; i < $fields.length; i++) {
									if ($fields.eq(i).val() !== '') {
										isEmpty = false;
										break;
									}
								}

								if (!isEmpty) {
									validator.updateStatus('training_input', validator.STATUS_VALID, 'callback');
									// Update the status of callback validator for all fields
									return true;
								}
								return false;
							}
						}
					}
				},
				prediction_input: {
					selector: '.prediction',  // Selects the prediction class
					validators: {
						regexp: {
							regexp: /^\s*>\s*chr(.+)\s*$/,
							message: 'Please enter a sequence or upload a file in FASTA format only'
						} 
						callback: {
							message: 'The input sequence for prediction is required',
							callback: function(value, validator, $field) {
								var isEmpty = true,
								$fields = validator.getFieldElements('prediction_input'); // Get the list of fields
								for (var i = 0; i < $fields.length; i++) {
									if ($fields.eq(i).val() !== '') {
										isEmpty = false;
										break;
									}
								}

								if (!isEmpty) {
									validator.updateStatus('prediction_input', validator.STATUS_VALID, 'callback');
									// Update the status of callback validator for all fields
									return true;
								}
								return false;
							}
						}
					}
				}
			}
		});
	});
</script>
</body>
</html>