let today = new Date().toISOString().slice(0, 10).split("-").reverse().join("-");
document.getElementById("exportBtn").onclick =()=>{
  let table = document.getElementById("allTable");
  let treatment = document.getElementById("treatment");
   let a =table.outerHTML
   alert("All set to download "+today)//
download(a, `${today}.xls`,'application/vnd.ms-excel')////
}