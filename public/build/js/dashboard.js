document.addEventListener("DOMContentLoaded",(function(){document.referrer!=window.location.origin||sessionStorage.getItem("runOnce")||(sessionStorage.setItem("runOnce",!0),Swal.fire({title:"Bienvenido!",timer:1e3,allowOutsideClick:!1,showConfirmButton:!1,didOpen:()=>{timerInterval=setInterval(()=>{b.textContent=Swal.getTimerLeft()},100)},willClose:()=>{clearInterval(timerInterval)}}))}));const cerrarSesion=document.querySelector("#cerrar-sesion");cerrarSesion&&cerrarSesion.addEventListener("click",()=>{sessionStorage.removeItem("runOnce")});