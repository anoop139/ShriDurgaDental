		input = document.getElementById("input1");


document.getElementById("input").onsubmit=()=> {
	// alert('test')
//	return false
	if (!input.value) {
      errInfo.innerHTML="Enter name please"; 
	// alert("Enter your name "+errInfo.innerHTML)
		return false
	}

	else{
    if (!window.sessionStorage.getItem("name")) {
    window.sessionStorage.setItem("name", input.value);
	input2.value =window.sessionStorage.getItem("name")
    re
    
  }
}
}
