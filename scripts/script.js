function submit() {
	window.location.replace("seqkertool.html")
}
function zoom() {
	document.body.style.zoom="100%"
}
window.onload = function(){ 
  //Get submit button
  var submitbutton = document.getElementById("tfq");
  //Add listener to submit button
  if(submitbutton.addEventListener){
     submitbutton.addEventListener("click", function() {
        if (submitbutton.value == 'Search our website'){//Customize this text string to whatever you want
           submitbutton.value = '';
        }
     });
  }
}