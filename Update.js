const parameters = window.location.search;
console.log(parameters);

const search = new URLSearchParams(parameters);
let oldName = search.get("id");
var message = document.getElementById("messageArea")
   
function updateName() {

   let newName = document.getElementById("newName").value;
 


   if(!newName)
   {
	   // alert(parameters+" hi");
      message.innerHTML="Enter new name new code  ";
	   return false
   }
    if (oldName.length==0) {
        alert("Sorry some problem occured refresh page and try again ")
      
    }
   else{
    //   alert("Are you sure you want to update "+oldName)
          window.location.href=`./UpdateName.php?oldName=${oldName}&newName=${newName}`
       return  false
   }
	
}
   
function updateAge() {
   // alert(oldName);"
   let newAge = document.getElementById("newAge").value

   if (!newAge) {
   //   alert("Enter new age")      
    message.innerHTML="Enter your age";
   //  message.style.backgroundColor="bla//ck"
   }
   else if (newAge<0) {
      message.innerHTML="Enter valid age";
   }
   else{
      alert(oldName)
   //   window.location.href=`./UpdateAge.php?oldName=${oldName}&newAge=${newAge}`

   false
   }
}
function updateGen() {
   let male = document.getElementById("Male");
   let female = document.getElementById("Female");
   let gender = document.getElementById("gen").value;
   if (male.checked==true) {
       gender = male.value[0]
     window.location.href=`./UpdateGen.php?oldName=${oldName}&newAge=${gender}`
      console.log(gender)
   }

   else if (female.checked==true) {
      gender = female.value[0]
      window.location.href=`./UpdateGen.php?oldName=${oldName}&newAge=${gender}`
     
   }
   else{
       message.innerHTML="Select one one option "     
   }
}


function updatePhone() {
   // message.innerHTML="testing"
   let phone = document.getElementById("phoneNumber").value
   if (!phone) {
      message.innerHTML="Enter new phone number";
   }
   else if(phone.length<10)
      {
         message.innerHTML="Number should have 10 digits "
      }  
      else if(phone.charAt(0)!=9 && phone.charAt(0)!=8 && phone.charAt(0)!=7)
         {
          message.innerHTML="Number should start from 9 or 8 7";
      
         }

         else{
            window.location.href=`./UpdatePhone.php?oldName=${oldName}&newPhone=${phone}`//
            // message.innerHTML=oldName
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