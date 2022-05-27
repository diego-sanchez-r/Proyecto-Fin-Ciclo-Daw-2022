/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


function myFunctionEstado() {
  var input, filter, section, div, h1, i;
  input = document.getElementById("mySelect");
  filter = input.value.toUpperCase();
  section = document.getElementById("mySection");
  div = section.getElementsByTagName("div");



  for (i = 0; i < div.length; i++) {
    h1 = div[i].getElementsByTagName("h6")[0];
    if (h1) {
      var palabrasEnFiltro = filter.split(' ');
      var hallado = 0;
      for (var filtro of palabrasEnFiltro) {
        if (h1.innerHTML.toUpperCase().indexOf(filtro) > -1) {
          hallado++;
        }
      }

      if (hallado === palabrasEnFiltro.length) {
        div[i].style.display = "";
      } else {
        div[i].style.display = "none";
      }

    }
  }

}