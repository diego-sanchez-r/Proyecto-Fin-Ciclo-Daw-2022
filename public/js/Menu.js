/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
document.getElementById("btnMenu").addEventListener('click',ocultar);

let logo=document.getElementById("logo");

function ocultar(){
  if(logo.style.display === "none"){
    logo.style.display="block";
  }else{
    logo.style.display="none";
  }
}