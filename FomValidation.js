	let errInfo; 
  let errInfo1; 
  let input;
  let input2
  window.onload = function () {
    // alert('UPDATED nee');

    errInfo = document.getElementById("errInfo");
    errInfo1 = document.getElementById("errInfo1");
		input = document.getElementById("input1");
		input2 = document.getElementById("input2");
	
    document.getElementById("pho").oninput = function () {
        errInfo.innerHTML = "";
    };
	 document.getElementById("age").oninput = function () {
			errInfo1.innerHTML = "";
		};
}


function insert() {
	let pname = document.getElementById("name0").value;
	let m = document.getElementById("Male");
let f = document.getElementById("Female");
let value1 = document.getElementById("value")
let date = new Date();
let d = date.getDate()
let mo = date.getMonth()+1
let y = date.getFullYear()
let toDate = ""
if (mo<10) {
	mo = 0+mo.toString() 
	// alert("hello "+d)
}
if (d<10) {
	d = 0+d.toString() 

}
toDate=d.toString()+" - "+mo.toString()+" - "+y
let date2 = document.getElementById("date2")
	// alert("hello "+toDate)
     
	let nameErr = document.getElementById("nameErr");
      let phoNo = document.getElementById("pho").value
      let age = document.getElementById("age").value
	  let reg =/^[0-9]*$/
	  let match = reg.test(phoNo);
	  let reg2 = /^[a-z\s]*$/i
       let match2 = reg2.test(pname);
	   if (!pname) return false;
   let cap = pname[0].toUpperCase();
   if (pname[0]!=cap) {
	nameErr.innerHTML="The first letter should be in capital letter "
	nameErr.style.background="white";
	return false

	
   }
   else{
	nameErr.innerHTML="";
	nameErr.style.background="";
   }
   if (m.checked==true) {
    value1.value="M"
	
    // alert( toDate)        
   }

   else if (f.checked==true) {
    value1.value="F"
   // 
   }
   date2.value=toDate

  if(age<0)
  {
	  errInfo1.innerHTML="Enter positive number please ";
	  errInfo1.style.backgroundColor="white"
	  return false
  }
	  if(phoNo.length<10)
	  {	  
		errInfo.innerHTML="Number should have 10 digits ";
		  errInfo.style.backgroundColor="white"
		  return false;
	  }
  else if(phoNo.charAt(0)!=9 && phoNo.charAt(0)!=8 && phoNo.charAt(0)!=7)
	   {
		 errInfo.innerHTML="Number should start from 9 or 8 7";
		 errInfo.style.backgroundColor="white"
		 return false
	   }
	 
  if(match==false)
	{
		errInfo.innerHTML="<span style='font-size:20px'>Please enter only numbers</span>" 
		errInfo.style.backgroundColor="white"
		return false
	}
   if (match2==false) {
	  nameErr.innerHTML="You entered special symbol"
	  nameErr.style.backgroundColor="white";
	  return false;
}
	else{
/////
		date2.value=toDate;
	    // errInfo.innerHTML=datne2
		//  alert("You are solving "+date2.value)//
		//  return false/////
	}

}
	
function checkInput() {
	// let input = document.getElementById("input1").value//;
    // let input2 = document.getElementById("input2").value;

	if (!input.value) {
      errInfo.innerHTML="Enter name"; 
	// alert("Enter your name "+errInfo.innerHTML)
		return false
	}

	else{
    if (!window.sessionStorage.getItem("name")) {
    window.sessionStorage.setItem("name", input.value);
	input2.value =window.sessionStorage.getItem("name")

    
  }
// \
}
}function checkNumberInput() {
	// let input = document.getElementById("input1").value//;
    // let input2 = document.getElementById("input2").value;

	if (!input.value) {
      errInfo.innerHTML="Enter number"; 
	// alert("Enter your name "+errInfo.innerHTML)
		return false
	}

	else{
    if (!window.sessionStorage.getItem("name")) {
    window.sessionStorage.setItem("name", input.value);
	input2.value =window.sessionStorage.getItem("name")

    
  }
// \
}
}