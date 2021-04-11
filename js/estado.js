$(document).on("ready", function () {
  if ($("#obraid").length ) {
  publicar();
  despublicar();
  bloquear();
  desbloquear();
function publicar() {
  $("#publicar").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
      alert(data);
     $("#publicar").html("Despublicar");
     $("#publicar").prop("id", "despublicar");
     despublicar();
    });
  });
}

function despublicar() {
  $("#despublicar").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "despublicar"
    },
    function (data) {
     $("#despublicar").html("Publicar");
     $("#despublicar").prop("id", "publicar");
     publicar();
    });
  });
}

function bloquear() {
  $("#bloquear").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      accion: "bloquear"
    },
    function (data) {
     $("#bloquear").html("Desbloquear");
     $("#bloquear").prop("id", "desbloquear");
     desbloquear();
    });
  });
}

function desbloquear() {
  $("#desbloquear").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      accion: "desbloquear"
    },
    function (data) {
     $("#desbloquear").html("Bloquear");
     $("#desbloquear").prop("id", "bloquear");
     bloquear();
    });
  });
}
  }else{
    publicarcapi();
    despublicarcapi();
    bloquearcapi();
    desbloquearcapi();

function publicarcapi() {
  $("#publicarcapi").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
      alert(data);
     $("#publicarcapi").html("Despublicar");
     $("#publicarcapi").prop("id", "despublicarcapi");
     $("#alert").text("El capitulo ha sido publicado, si la obra no es publica nadie lo podra leer!");
     $("#alert").addClass("alert alert-success text-center");
     despublicarcapi();
    });
  });
}

function despublicarcapi() {
  $("#despublicarcapi").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "despublicar"
    },
    function (data) {
      alert(data);
      $("#alert").text("");
      $("#alert").removeClass("alert alert-success text-center");
     $("#despublicarcapi").html("Publicar");
     $("#despublicarcapi").prop("id", "publicarcapi");
     publicarcapi();
    });
  });
}

function bloquearcapi() {
  $("#bloquearcapi").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      accion: "bloquear"
    },
    function (data) {
     $("#bloquearcapi").html("Desbloquear");
     $("#bloquearcapi").prop("id", "desbloquearcapi");
     desbloquearcapi();
    });
  });
}

function desbloquearcapi() {
  $("#desbloquearcapi").on("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      accion: "desbloquear"
    },
    function (data) {
     $("#desbloquearcapi").html("Bloquear");
     $("#desbloquearcapi").prop("id", "bloquearcapi");
     bloquearcapi();
    });
  });
}

  }

});