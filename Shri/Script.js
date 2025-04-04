// /////

function insert() {
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

   if (m.checked==true) {
    value1.value="M"
	date2.value=toDate
    // alert( toDate)        
   }

   else if (f.checked==true) {
    value1.value="F"
   //  alert(value1)
   }

      let errInfo = document.getElementById("errInfo") 
      let errInfo1 = document.getElementById("errInfo1") 
    let name = document.getElementById("name").value;
	let nameErr = document.getElementById("nameErr");
      let phoNo = document.getElementById("pho").value
      let age = document.getElementById("age").value
	  let reg =/^[0-9]*$/
	  let match = reg.test(phoNo);
	  let reg2 = /^[a-z\s]*$/i
       let match2 = reg2.test(name);
  if(age<0)
  {
	  errInfo1.innerHTML="Enter positive number ";
	  return false
  }
	  if(phoNo.length<10)
	  {
		  errInfo.innerHTML="Number should have 10 digits ";
		  return false;
	  }
  else if(phoNo.charAt(0)!=9 && phoNo.charAt(0)!=8 && phoNo.charAt(0)!=7)
	   {
		 errInfo.innerHTML="Number should start from 9 or 8 or 7 ";
		 return false
	   }
	 
  if(match==false)
	{
		errInfo.innerHTML="Please enter only numbers "+match;
		return false
	}
   if (match2==false) {
	  nameErr.innerHTML="You entered special symbol"
	  return false;
}
	else{
		errInfo.innerHTML="All good";
		nameErr.innerHTML=""
		//return false;
	}

}











   //wfuzz -c -z file,/usr/share/wfuzz/wordlist/Injections/params.txt --hc 404 http://demo.testfire.net/index.jsp?FUZZ=test
