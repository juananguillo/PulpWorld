/*$(document).on("ready", function () {

$(".busqueda").on("click", function () {
    
    if($("#textobusqueda").val().length < 1) { 
       var res;
        var cat=$("#categorias").val();
        var or=$("#orden").val();
        $.ajax({url:"./funcionesphp/filtrar.php", data: {sinpalabras:true, categoria: cat, orden:or}, type:"POST"
        ,async: false, dataType: "text", success: function(data) { res= data; }
          });

          $("#coleccion").html(
            

          )
    }
    else{

    }

});


});*/