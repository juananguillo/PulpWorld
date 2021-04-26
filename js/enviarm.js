$(document).on("ready", function () {
    $("#textomn").on("change keyup keydown paste cut copy", function () {
        if($("#textomn").length){
        if($("#textomn").val().trim()==""){
       
           $("#enviarmn").prop('disabled', true);
        }else{
       
           $("#enviarmn").prop('disabled', false);
        }
    }
     });

     $("#enviarmn").on("click", function () {
        $.post("./funcionesphp/mensajes.php", {
            id1:$(".valores").prop("id"),
            id2:$(".valores").val(),
            contenido:$("#textomn").val(),
            accion: "insertar"
          },
          function (data) {
              alert("El mensaje se ha enviado con exito");
           $(".close").click();
          });
       }); 


});