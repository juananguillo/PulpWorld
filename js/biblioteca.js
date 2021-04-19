$(document).on("ready", function () {

  guardarobra();
  quitarobra();

function guardarobra() {
  $(".guardarobra").on("click", function () {
  let b=$(this);
    $.post("./funcionesphp/biblioteca.php", {
      id_o: $(this).val(),
      id_bi: $("#biblioteca").val(),
      accion: "guardar"
  },
  function (data) {
    b.html("<i class='fas fa-book-open'> Quitar</i>");
    b.addClass("quitarobra");
    b.removeClass("guardarobra");
    b.removeClass("btn-success");
    b.addClass("btn-danger");
    quitarobra();
  
  });
  
  });
}


function quitarobra() {
  $(".quitarobra").on("click", function () {
    let b=$(this);
    $.post("./funcionesphp/biblioteca.php", {
      id_o: $(this).val(),
      id_bi: $("#biblioteca").val(),
      accion: "quitar"
  },
  function (data) {
   b.html("<i class='fas fa-book-open'> Guardar</i>");
   b.addClass("guardarobra");
   b.removeClass("quitarobra");
   b.removeClass("btn-danger");
   b.addClass("btn-success");
    guardarobra();
  });
  
  });
 
}

});