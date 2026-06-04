window.onload =()=>{
   // alert ("test")
}

const parameters = window.location.search;
console.log(parameters);

const search = new URLSearchParams(parameters);
let id = search.get("id");
var holdId = document.getElementById("Id")
var message = document.getElementById("messageArea")
   
function updateName() {
if (!document.getElementById("token").value) {
   message.innerHTML = "Token not ready, please wait...";
   return false;
}
   let newName = document.getElementById("newName").value;
 


   if(!newName)
   {
	   // alert(parameters+" hi");
      message.innerHTML="Enter new name";
	   return false
   }
   else{
   //  //   alert("Are you sure you want to update "+oldName)
    holdId.value=id  
    return true
   }
	
}
    let csrfToken = ''
   fetch("Gettoken.php")
      .then(response => response.text())
      .then(token => {
         // Do something with the token
         csrfToken = token; 
     let tokenField = document.getElementById("token");
tokenField.value = csrfToken;
// alert("Token received: in input   " +  tokenField.value);
      })

function updateAge() {
   // alert(id);
   if (!document.getElementById("token").value) {
   message.innerHTML = "Token not ready, please wait...";
   return false;
}
   let newAge = document.getElementById("newAge").value

   if (!newAge) {
   //   alert("Enter new age")      
    message.innerHTML="Enter your age";
     return false
   }
   else if (newAge<0 || newAge>=120) {
      message.innerHTML="Enter valid age Less than 120 and greater than 0";
      return false
   }
   else{
   
      holdId.value=id;
      return true
   
   }
  
}
function updateGen() {


   if (!document.getElementById("token").value) {
      message.innerHTML = "Token not ready, please wait...";
      return false;
   }
   // let male = document.getElementById("olf");
   let male = document.getElementById("Male");
   let female = document.getElementById("Female");
   let gender = document.getElementById("gen")
   if (male.checked==false && female.checked==false) {//
      message.innerHTML="Select one option please "
      // message.innerHTML="yes my baby"
      return false     
   }
   if(male.checked==true){
      gender.value = "Male"
      holdId.value = id
      // message.innerHTML="The value of id is "+holdId.value
      return true
   }
   else if(female.checked==true){
      gender.value ="Female"
        holdId.value = id
      // message.innerHTML="The value of id is "+holdId.value
      return true
   }
}


function updatePhone() {
   // message.innerHTML="testing"
   
   if (!document.getElementById("token").value) {
      message.innerHTML = "Token not ready, please wait...";
      return false;
   }
   let phone = document.getElementById("phoneNumber").value
   if (!phone) {
      message.innerHTML="Enter new phone number";
      return false
   }
   else if(phone.length<10)
      {
         message.innerHTML="Number should have 10 digits "
         return false
      }  
      else if(phone.charAt(0)!=9 && phone.charAt(0)!=8 && phone.charAt(0)!=7)
         {
          message.innerHTML="Number should start from 9 or 8 7";
          return false
      
         }

         else{
        
             holdId.value=id      
            // message.innerHTML="good to go id ="+id+"<br> hold == "+holdId.value;
            return true
         }
}
window.oninput =()=>{
   // console.log("hello");
   message.innerHTML=""
}


message.onmouseover =()=>{
   message.style.fontSize="100px";
   console.log("hi");
   
}
message.onmouseout =()=>{
   message.style.fontSize="15px";
   console.log("hi");


   
}