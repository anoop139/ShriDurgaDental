// onload = ()=>{/
   let  buttonValue =document.getElementById("deleteTreatment")
  
    //  alert("You are del all ")/
// } 
    let treatNo =document.getElementById("noOfTreat").value 
    if (treatNo>1) {
         buttonValue.value="YesAll"
         buttonValue.name="deleteAll"
    }
  
document.getElementById("mainFom").onsubmit=()=>{
 
  if (treatNo==1) {
    // alert("You are del 1")
    return true;
  }
  else if (treatNo>=1) {
    return true
  }
}
   