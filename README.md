# Tool-Seqker

### Technical Details

SeqKer is based on a client-server architecture featuring a server backend for the functionality and a browser-based frontend for the user interface. The application is currently hosted, developed and tested locally on the Windows Apache MySQL PHP server stack. The hosting environment will be configured by qdata services on a university-owned Apache2 web server. Once testing is complete, the application will be migrated from the production server to the hosting environment, so moderations to the apache2.conf file will need to be configured before deployment of the application.

The frontend, or client-side, was built on top of a design template using HTML, CSS and JavaScript and uses the Bootstrap frontend framework primarily for typography, forms, buttons, navigation and other interface components. The frontend is responsible for displaying the user-friendly data submission form and application information and handling form validation. The backend was developed using Python, Perl and Shell and utilizes Kernel-based machine learning algorithms for training and testing the experimental data, following which the calculated scores will appear in separate and downloadable text and color-coded HTML files that are sent directly to the user via email.

When the form is submitted, the standard input is passed into the CGI program. The web server runs the CGI program using the POST method, which is specified in the ACTION parameter in the form’s HTML, and redirects the user to the main data submission page. The CGI object stores the values for all the form fields and parameters specified in the URL. The fields return scalar values in the form of a text string, which are accessed with the defined param() method to verify the selected value.

The training and prediction fields store the input DNA or protein binding data for each sequence variant, estimating the relative degree of protein binding on a scale of 1, maximal, to –1, minimal. When the CGI program is run, the training and testing data are written into two timestamped text files, respectively, located in the input data directory, later to be retrieved and analyzed. 

The Python script takes the following arguments: the email address of the user of which the files will be sent to, the timestamp or job identification number of the user, the sequence type, and the sequence length. Taking the information, the Python script runs the required Shell script based on the sequence type, which leads into running the backend C script algorithms located in the SVM-v1 directory.

The corresponding Shell script will create and output prediction scores to the PRED.txt file located in the output directory. The text file, as well as the color-coded HTML version that differentiates the number of positive and negative results, will be immediately emailed back to the user.
