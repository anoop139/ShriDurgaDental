onload = () => {
    const id = new URLSearchParams(window.location.search).get('id');
        let mess = document.getElementById("updateMessage");

    if (!mess) return;

    mess.style.transform = "translateY(80px)";

    setTimeout(() => {
        mess.style.transform = "translateY(-80px)";
    }, 5000);
};
  //  alert(`Patient updated successfully with ID: ${id}`);
