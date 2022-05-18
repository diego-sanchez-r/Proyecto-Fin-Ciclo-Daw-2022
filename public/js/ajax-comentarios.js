

function comentar(id){
    var Ruta = Routing.generate('add_comentario_ajax');
    let comentarioValue = document.getElementById("comentario"+id).value;
    $.ajax({
       type:'POST',
       url: Ruta,
       data:({id: id,texto: comentarioValue}),
       async: true,
       dataType: "json",
       success: function(data){
          console.log(data['usuarioNombre']+data['usuarioapellidos']+data['comentario']);
       }
    });
}