

function comentar(id){
    var Ruta = Routing.generate('add_comentario_ajax');
    let comentarioValue = document.getElementById("comentario"+id).value;
    let contenido = document.getElementById("nuevo"+id).innerHTML;
    let nuevoComentario = document.getElementById("nuevo"+id);
    $.ajax({
       type:'POST',
       url: Ruta,
       data:({id: id,texto: comentarioValue}),
       async: true,
       dataType: "json",
       success: function(data){
            nuevoComentario.innerHTML = contenido+
                  "<div class='foto_usuarioComentario' style='background-image: url(/imagenes/img_users/"+data['usuarioimagen']+")'></div>"+
                  "<div class='contenido rounded-pill'>"+
                  "<div class='nombreUsuComentarios fw-bold'>"+data['usuarioNombre']+" "+data['usuarioapellidos']+"<br></div>"+
                  "<div class='comentario'>"+data['comentario']+"</div>"+
                  "</div>"+
                  "<br/>";
       }
    });
}