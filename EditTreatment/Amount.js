// alert(0)
let fom = document.getElementById("amountFom");
let inpt = document.getElementById("input");
        let error = document.getElementById("Error");
        function checkInput(e) {
            if (inpt.value=="") {
                // alert(0)
                error.innerHTML="Enter amount"
                   e.preventDefault();
            }         if (inpt.value<0) {
                // alert(0)
                error.innerHTML="Enter valid amount"
                   e.preventDefault();
            }
        }

        fom.addEventListener("submit", checkInput)
        oninput =()=>{
            error.innerHTML=""
        }