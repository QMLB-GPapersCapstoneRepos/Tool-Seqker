var isEmpty = /^\s*$/;


function validate() {
    var fn = document.getElementById("firstname").value;
    var ln = document.getElementById("lastname").value;
    var email = document.getElementById("email").value;
    var inst = document.getElementById("institution").value;
    if(fn == "" || ln == "") {
        alert("Please enter your full name");
        return false;
    }
    if(email == "") {
        alert("Please enter your email");
        return false;
    }
    if(inst == "") {
        alert("Please enter your school");
        return false;
    } else {
        window.location.href='http://localhost:8000/redirect.php/';
        return false;
    }
}
//     //First Name Validation 
//     var fn=document.getElementById('firstname').value;
//     if(fn == ""){
//         alert('Please Enter First Name');
//         document.getElementById('firstname').style.borderColor = "red";
//         return false;
//     }else{
//         document.getElementById('firstname').style.borderColor = "green";
//     }
//     if (/^[0-9]+$/.test(document.getElementById("firstname").value)) {
//         alert("First Name Contains Numbers!");
//         document.getElementById('firstname').style.borderColor = "red";
//         return false;
//     }else{
//         document.getElementById('firstname').style.borderColor = "green";
//     }
//     if(fn.length <=2){
//         alert('Your Name is To Short');
//         document.getElementById('firstname').style.borderColor = "red";
//         return false;
//     }else{
//         document.getElementById('firstname').style.borderColor = "green";
//     }
// }