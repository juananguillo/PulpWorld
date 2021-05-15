$(document).on("ready", function () {

function block(params) {
  console.log(params);
  if(params=="block"){
    window.location.replace("./funcionesphp/sesion.php?logout=yes&index=yes");
  }
}


  if ($("#obraid").length ) {
  publicar();
  despublicar();
  bloquear();
  desbloquear();
  terminar();
  desterminar();
  eliminar();

  function eliminar() {
  
    $("#eliminar").one("click", function () {
      if(confirm("Si borra la obra, ya no se podra recuperar, seguro que desea borrarla?")){
        $.post("./funcionesphp/cambiarestado.php", {
          id_obra: $(".valores").val(),
          user:$(".valores").prop("id"),
          accion: "eliminar"
        },
        function (data) {
          block(data);
          window.location = 'usuario.php?user=' + $(".valores").prop("id");
        });
      
      }
      eliminar();
    });
   
  }

  function terminar() {
    $("#terminar").one("click", function () {
      $.post("./funcionesphp/cambiarestado.php", {
        id_obra: $(".valores").val(),
        user:$(".valores").prop("id"),
        accion: "terminar"
      },
      function (data) {
        block(data);
       $("#terminar").html("Desfinalizar");
       $("#terminar").prop("id", "desterminar");
       $("#estadoobra").html("Estado: <strong>Terminada</strong>");
       desterminar();
      });
    });
  }
  

  
  function desterminar() {
    $("#desterminar").one("click", function () {
      $.post("./funcionesphp/cambiarestado.php", {
        id_obra: $(".valores").val(),
        user:$(".valores").prop("id"),
        accion: "desterminar"
      },
      function (data) {
        block(data);
       $("#desterminar").html("Finalizar");
       $("#desterminar").prop("id", "terminar");
       $("#estadoobra").html("Estado: <strong>Sin terminar</strong>");
       terminar();
      });
    });
  }




function publicar() {
  
  $("#publicar").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
      block(data);
     $("#publicar").html("Despublicar");
     $("#publicar").prop("id", "despublicar");
     despublicar();
    });
  });
}

function despublicar() {
  $("#despublicar").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "despublicar"
    },
    function (data) {
      block(data);
     $("#despublicar").html("Publicar");
     $("#despublicar").prop("id", "publicar");
     publicar();
    });
  });
}

function bloquear() {
  $("#bloquear").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      accion: "bloquear",
      user:$(".valores").prop("id")
    },
    function (data) {
      block(data);
     $("#bloquear").html("Desbloquear");
     $("#bloquear").prop("id", "desbloquear");
     desbloquear();
    });
  });
}

function desbloquear() {
  $("#desbloquear").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      accion: "desbloquear",
      user:$(".valores").prop("id")
    },
    function (data) {
      block(data);
     $("#desbloquear").html("Bloquear");
     $("#desbloquear").prop("id", "bloquear");
     bloquear();
    });
  });
}
  }else if($("#navcapi").length ){
    bloquearuser();
    desbloquearuser();
    eliminar();


    function eliminar() {
  
      $("#eliminar").one("click", function () {
        if(confirm("Si borra el usuario, perdera todo su información, obras y capitulos, desea?")){
          $.post("./funcionesphp/cambiarestado.php", {
            id_user: $(".valores").val(),
            accion: "eliminar"
          },
          function (data) {
            block(data);
            window.location = './funcionesphp/sesion.php?logout=yes&index=yes'
          });
        
        }
        eliminar();
      });
     
    }

    function bloquearuser() {
      $("#bloquearuser").one("click", function () {
        $.post("./funcionesphp/cambiarestado.php", {
          id_user: $(".valores").val(),
          accion: "bloquear",
        },
        function (data) {
          block(data);
         $("#bloquearuser").html("Desbloquear");
         $("#bloquearuser").prop("id", "desbloquearuser");
         desbloquearuser();
        });
      });
    }
    
    function desbloquearuser() {
      $("#desbloquearuser").one("click", function () {
        $.post("./funcionesphp/cambiarestado.php", {
          id_user: $(".valores").val(),
          accion: "desbloquear",
        },
        function (data) {
          block(data);
         $("#desbloquearuser").html("Bloquear");
         $("#desbloquearuser").prop("id", "bloquearuser");
         bloquearuser();
        });
      });
    }
  }

  else{
    publicarcapi();
    despublicarcapi();
    bloquearcapi();
    desbloquearcapi();
    eliminar();


    function eliminar() {
  
      $("#eliminar").one("click", function () {
        if(confirm("Si borra el capitulo, ya no se podra recuperar, seguro que desea borrarlo?")){
          $.post("./funcionesphp/cambiarestado.php", {
            id_capi: $(".valores").val(),
            user:$(".valores").prop("id"),
            obra_capi:$("obracapi").val(),
            accion: "eliminar"
          },
          function (data) {
            block(data);
            window.location = 'obra.php?obra=' + $("#obracapi").val();
          });
        
        }
        eliminar();
      });
     
    }

function publicarcapi() {
  $("#publicarcapi").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
      console.log(data);
      block(data);
     $("#publicarcapi").html("Despublicar");
     $("#publicarcapi").prop("id", "despublicarcapi");
     $("#alert").text("El capitulo ha sido publicado, si la obra no es publica nadie lo podra leer!");
     $("#alert").addClass("alert alert-success text-center");
     despublicarcapi();
    });
  });
}

function despublicarcapi() {
  $("#despublicarcapi").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "despublicar"
    },
    function (data) {
      block(data);
      $("#alert").text("");
      $("#alert").removeClass("alert alert-success text-center");
     $("#despublicarcapi").html("Publicar");
     $("#despublicarcapi").prop("id", "publicarcapi");
     publicarcapi();
    });
  });
}

function bloquearcapi() {
  $("#bloquearcapi").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      accion: "bloquear",
      user:$(".valores").prop("id"),
    },
    function (data) {
      block(data);
     $("#bloquearcapi").html("Desbloquear");
     $("#bloquearcapi").prop("id", "desbloquearcapi");
     desbloquearcapi();
    });
  });
}

function desbloquearcapi() {
  $("#desbloquearcapi").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      accion: "desbloquear",
      user:$(".valores").prop("id"),
    },
    function (data) {
      block(data);
     $("#desbloquearcapi").html("Bloquear");
     $("#desbloquearcapi").prop("id", "bloquearcapi");
     bloquearcapi();
    });
  });
}

  }

});