
$(document).on("ready", function () {

    document.getElementById("mencaja").scrollTop = document.getElementById("mencaja").scrollHeight;
    if($("#receptor").length){
        $("#mn").prop('disabled', false);
    }
    $("#mn").on("change keyup keydown paste cut copy", function () {
        if($("#receptor").length){
        if($("#mn").val().trim()==""){
       
           $("#enviar").prop('disabled', true);
        }else{
       
           $("#enviar").prop('disabled', false);
        }
    }
     });

    //setInterval(function() {  tiemporeal();    },1000);

    $(".chatid").on("click", function () {  
        $(".cajam").empty();
       let us= $(this).prop("id");
        $.post("./funcionesphp/mensajes.php", {
            id1:$("#usuid").val(),
            id2:us,
            accion: "listar"
          },
          function (data) {
            $(".cajam").append(data);
            window.history.pushState({}, '', '?chat='+us);
            $("#mn").prop('disabled', false);
            document.getElementById("mencaja").scrollTop = document.getElementById("mencaja").scrollHeight;
          });
          
    });


    $("#mensajes").scrollTop($("#mensajes").scrollHeight);
   $("#enviar").on("click", function () {
    $.post("./funcionesphp/mensajes.php", {
        id1:$("#usuid").val(),
        id2:$("#receptor").val(),
        contenido:$("#mn").val(),
        accion: "insertar"
      },
      function (data) {
          let men="<div class='text-right mt-1 border rounded border-primary'><strong class='ml-3 mr-3 text'>"+$("#mn").val()+"</strong></div><br>";
        $(".cajam").append(men);
      });
   }); 

   function tiemporeal() {
    $.get("mensajes.php", function (data) {
        //var men="";
        for(var i in data) {
            men+="<p style=text-align:right>"+data[i]+"</p><br>";
        }
        $("#mensajes").append(men);

    });
   }


});