 onload =()=>{
        document.getElementById("message").style.transform="translateY(100px)";
        setTimeout(() => {
        document.getElementById("message").style.transform="translateY(-40px)";
            
        }, 5000);
    }
   onsubmit =()=>{
   let table = document.getElementById("table")
   const date=table.rows[1].cells[0].innerText.trim();
   if (date.length>0) 
    {
      result =confirm('Are you sure you want to delete due date ? ')
   }
   if (result==true) {
        //  alert('Yes clickeed yee')
        // return false
   }
   else{
    alert('No due date to be deleted')
        return false
   }

    }
//    return false
   //}