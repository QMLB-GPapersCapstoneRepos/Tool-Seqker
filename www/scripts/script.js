var isEmpty = /^\s*$/;

function validate(id) {
    var text=document.getElementById(id).value;
    if(!text.match(/\S/)) {
        return false;
    } else {
        return true;
    }
}
function processForm() {
    if((validate('firstname')||validate('lastname')||validate('email')||
    } else {
        return true;
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