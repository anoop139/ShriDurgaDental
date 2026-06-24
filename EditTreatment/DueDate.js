let inpt = document.getElementById("input");
        let input = document.getElementById("input2");
        let error = document.getElementById("Error");
        let dueFom = document.getElementById("dueDate");
        function checkInput(e) {
            if (inpt.value=="") {
                // alert(0)
                error.innerHTML="Enter due date "

                e.preventDefault()
                //return false
            }
            else{
                let x = inpt.value.split("-").reverse().join(" - ")
                let date = Number(x.charAt(0)+x.charAt(1))
                let month = Number(x.charAt(5)+x.charAt(6))
                let year = Number(x.slice(10,14))
                let currentDate = new Date()
                let currentYear       = currentDate.getFullYear()
                let toDay       = currentDate.getDate()
                let thisMonth       = currentDate.getMonth()+1
           if ((date <= toDay || month < thisMonth) && currentYear == year) {
   
            alert("Wrong due date or month");
                e.preventDefault();
                       return false;

                    }

           if (year < currentYear) {
                   alert("Wrong due year");
                 e.preventDefault();
                     return false;
}
            else{
             
                return true//
                 
            }
            }
        }
        oninput =()=>{
         
            error.innerHTML=""
        }

  dueFom.addEventListener("submit", checkInput)      