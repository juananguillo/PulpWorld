
$(document).on("ready", function () {

    //setInterval(function() {  tiemporeal();    },1000);

    $("#mensajes").scrollTop($("#mensajes").scrollHeight);
   $("#enviar").on("click", function () {
     $.post("mensajes.php",{mensaje:$("#mensaje").val()}, function (data) {
        var men="";
        for(var i in data) {
            men+="<p style=text-align:right>"+data[i]+"</p><br>";
        }
        $("#mensajes").append(men);
     }); 
   }); 

   function tiemporeal() {
    $.get("mensajes.php", function (data) {
        var men="";
        for(var i in data) {
            men+="<p style=text-align:right>"+data[i]+"</p><br>";
        }
        $("#mensajes").append(men);

    });
   }


});