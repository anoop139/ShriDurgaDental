let today = new Date().toISOString().slice(0, 10).split("-").reverse().join("-");
document.getElementById("exportBtn").onclick =()=>{
  let table = document.getElementById("allTable");
  let treatment = document.getElementById("treatment");
   let a =table.outerHTML
   let result = confirm("Are you sure you want to download today's record?");

   if (result === false) {

    return false; 
   }
   else{
   
    download(a, `${today}.xls`,'application/vnd.ms-excel')////
      return true
   }
}