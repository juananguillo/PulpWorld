
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


     $("#textobusqueda").on("change keyup keydown paste cut copy", function () {
      if($("#textobusqueda").length){
      if($("#textobusqueda").val().trim()==""){
     
         $("#busqueda").prop('disabled', true);
      }else{
     
         $("#busqueda").prop('disabled', false);
      }
  }
   });

    setInterval(function() { 
        $.post("./funcionesphp/mensajes.php", {
            id1:$("#usuid").val(),
            id2:$("#receptor").val(),
            contenido:$("#mn").val(),
            accion: "comprobar"
          },
          function (data) {
            if(data>$("#totalm").val()){
                leer($("#receptor").val());
            }
          });
            }
        ,5000);

        setInterval(function() { 

          let array=[];
          $(".chatid").each(function () { 
            array.push($(this).prop("id"));
              });
          $.post("./funcionesphp/mensajes.php", {
              chats: array,
              id1:$("#usuid").val(),
              accion: "actualizar"
            },
            function (data) {
              console.log(data);
             for (let index = 0; index < data.length; index++) {
             if(data[index]!=0){
            
             }
             //console.log($("#"+index).prop("id"));


             //console.log($(".msinleer")[index].text());
               
             }
            });
         
              }
          ,5000);

    

    $(".chatid").on("click", function () {
      
        leer($(this).prop("id"));
        
          
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
          let men="<div class='mt-1  border rounded border-primary mdiv1'><p class='text text-justify'><strong>"+$("#mn").val()+"</strong></p></div><br>";
        $(".cajam").append(men);
         document.getElementById("mencaja").scrollTop = document.getElementById("mencaja").scrollHeight;
         $("#mn").val('');
      });
   }); 

  

  function leer (us) {  
    $(".cajam").empty();
    $.post("./funcionesphp/mensajes.php", {
        id1:$("#usuid").val(),
        id2:us,
        accion: "listar"
      },
      function (data) {
        $(".cajam").append(data);
        document.getElementById("mencaja").scrollTop = document.getElementById("mencaja").scrollHeight;
        window.history.pushState({}, '', '?chat='+us);
        $("#mn").prop('disabled', false);
     
      });
     
    }


    $("#busqueda").on("click", function () {
         
      $.post("./funcionesphp/mensajes.php", {
        palabras:$("#textobusqueda").val(),
        id1:$("#usuid").val(),
        accion: "filtrar"
      },
      function (data) {
          $("#chats").empty();
          $("#chats").append(data);
          $(".chatid").on("click", function () {
      
            leer($(this).prop("id"));
            
              
        });
      });
    })

});