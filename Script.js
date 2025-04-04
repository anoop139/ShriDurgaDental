
function insert() {
	let pname = document.getElementById("name0").value;
	let m = document.getElementById("Male");
let f = document.getElementById("Female");
let value1 = document.getElementById("value")
let date = new Date();
let d = date.getDate()
let mo = date.getMonth()
let y = date.getFullYear()
let toDate = ""
toDate=d.toString()+" - "+mo.toString()+" - "+y
let date2 = document.getElementById("date2")

      let errInfo = document.getElementById("errInfo") 
      let errInfo1 = document.getElementById("errInfo1") 
	let nameErr = document.getElementById("nameErr");
      let phoNo = document.getElementById("pho").value
      let age = document.getElementById("age").value
	  let reg =/^[0-9]*$/
	  let match = reg.test(phoNo);
	  let reg2 = /^[a-z\s]*$/i
       let match2 = reg2.test(name);
   let cap = pname[0].toUpperCase();
   if (pname[0]!=cap) {
	nameErr.innerHTML="The first letter should be in capital letter";
	nameErr.style.background="white";
	return false

	
   }
   else{
	nameErr.innerHTML="";
	nameErr.style.background="";
   }
   if (m.checked==true) {
    value1.value="M"
	date2.value=toDate
    // alert( toDate)        
   }

   else if (f.checked==true) {
    value1.value="F"
   //  alert(value1)
   }

  if(age<0)
  {
	  errInfo1.innerHTML="Enter positive number ";
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
		errInfo.innerHTML="Please enter only numbers "+match;
		return false
	}
   if (match2==false) {
	  nameErr.innerHTML="You entered special symbol"
	  nameErr.style.backgroundColor="white";
	  return false;
}
	else{
		
		errInfo.innerHTML="All good "+pname[0];
		errInfo.style.backgroundColor="white"
    	//return false;
	}

}

function checkInput() {
	// let input = document.getElementById("input1").value
	// if (!input) {
		alert("object")
	// }//
	
}









   //wfuzz -c -z file,/usr/share/wfuzz/wordlist/Injections/params.txt --hc 404 http://demo.testfire.net/index.jsp?FUZZ=test
