   let msg = document.getElementById("errorMessage1")
   let treatExisted = document.getElementById("treatExisted")
   let treat;
         
   function Submit() {
 let date2 = document.getElementById("date2")
 let dueDate = document.getElementById("dueDate")
 let dueDateInput = document.getElementById("dueDateInput")
     treat = document.getElementById("treat1").value 
 let  advance = document.getElementById("Advance") 
 let  online = document.getElementById("onlinePayment") 
 let cashReceived = document.getElementById("receivedAmount")
  let advan =  Number(advance.value) 
  let tot =  Number(cashReceived.value)
  let v   ="0";  
    if (!treat) {
      
      msg.innerHTML="Enter treatment"
      // alert("date is "+date)
          return false 
    }

    if (advance.value<0 || online.value<0) {
        
    alert("Enter positive number");
         return false;
    }
    if (tot<0) {
        alert("Enter valid number");
         return false;
    }
 if (isNaN(advan) || advance.value.trim() === "") {
    advance.value=0;
  // alert("Enter advance number");
    // return false;
}
 else{
         let date = new Date();
         let d = date.getDate()
         let mo = date.getMonth()+1
        let y = date.getFullYear()
        let toDate = ""
        // if (mo<10) {
                  toDate=d.toString()+" - "+mo.toString()+" - "+y
        // }
        // else {
        //           toDate=d.toString()+" - "+mo.toString()+" - "+y
          
        // }
	// date2.value=toDate;
if (dueDate.value) {
    let parts = dueDate.value.split("-");
    dueDateInput.value = parts[2] + " - " + parts[1] + " - " + parts[0]; 
    // alert("Due date in js file"+ dueDateInput.value);
      
  let x =dueDate.value.split("-").reverse().join(" - ")
  let date = x.slice(0, 7)
  let todayDate =x.slice(0, 2)
  let currentMonth = x.slice(4, 7)
  let due = x.slice(0,2)
  let dueMonth = x.slice(5,7)
  let dueYear =x.slice(10,14)
  let currentYear =date2.value.slice(9)// Change to 9

 alert(typeof parts)
//  return false 
  if (due<d && mo==dueMonth) {
    alert("Sorry you entered wrong due date ")
    return false
    
  } 
    if (currentMonth>dueMonth && currentYear==dueYear) {
    alert("Sorry you entered wrong due month")
    return false
    
  }
  if (currentYear>dueYear && x.length!=0) {
    alert("Sorry you entered wrong due year ")
    return false
    }
  else{
    dueDateInput.value=x
    // alert////("Due date is "+x)
    // return false/////////
  }

}
            // alert('hi'/)
}
} 
  
if (advan> 0 && tot==0) {
  
  cashReceived.value = advance.value
  // alert("cash is converted "+cashReceived.value)
  // return false
}

if (dueDate.value.length==0) {
  // alert("no due date And advance is "+dueDate.value)///
  dueDate.value="None"
  }
if (advance.value=="") {
     advance.value=0;
  //alert("no due date And advance is "+dueDate.value)///
  //return false
  
}
else{
}

 window.oninput = (() => {
  msg.innerHTML = "";

  if (treatExisted) {
    treatExisted.innerHTML = "";
  }
});