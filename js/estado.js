$(document).on("ready", function () {
  if ($("#obraid").length ) {
  publicar();
  despublicar();
  bloquear();
  desbloquear();
function publicar() {
  $("#publicar").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_obra: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
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
  $("#publicarcapi").one("click", function () {
    $.post("./funcionesphp/cambiarestado.php", {
      id_capi: $(".valores").val(),
      user:$(".valores").prop("id"),
      accion: "publicar"
    },
    function (data) {
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
     $("#desbloquearcapi").html("Bloquear");
     $("#desbloquearcapi").prop("id", "bloquearcapi");
     bloquearcapi();
    });
  });
}

  }

});