 let fom = document.getElementById("onlineFom");
 let inpt = document.getElementById("input");
        let error = document.getElementById("Error");
        function checkInput(e) {
            if (inpt.value=="") {
                // alert(0)
                error.innerHTML="Enter amount"
                e.preventDefault()
            }
        }
        oninput =()=>{
            error.innerHTML=""
        }


fom.addEventListener("submit", checkInput)