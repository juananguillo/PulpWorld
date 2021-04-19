$(document).on("ready", function () {
    if ($("#obraid").length ) {
    like();
    dislike();
  function like (params) {
    $("#dar").on("click", function () {
      $.post("./funcionesphp/darquitar.php", {
          id_obra: $(".valores").val(),
          id_usuario: $(".valores").prop("id"),
          accion: "dar"
        },
        function (data) {
         $("#dar").html("<i class='fas fa-thumbs-up'> Quitar me gusta</i>");
         $("#dar").removeClass("btn-success");
         $("#dar").addClass("btn-danger");
         $("#dar").prop("id", "quitar");
          dislike();
        });
    });
  }
    function dislike(params) {
      $("#quitar").on("click", function () {
        $.post("./funcionesphp/darquitar.php", {
            id_obra: $(".valores").val(),
            id_usuario: $(".valores").prop("id"),
            accion: "quitar"
          },
          function (data) {
           $("#quitar").html("<i class='fas fa-thumbs-up'> Dar me gusta</i>");
           $("#quitar").removeClass("btn-danger");
           $("#quitar").addClass("btn-success");
           $("#quitar").prop("id", "dar");
            like();
          });
      });
    }
}
else{
    follow();
    unfollow();
    function follow (params) {
        $("#dar").on("click", function () {
          $.post("./funcionesphp/darquitar.php", {
            id_seguido: $(".valores").val(),
            id_seguidor: $(".valores").prop("id"),
            accion: "dar"
            },
            function (data) {
             $("#dar").html("<i class='fas fa-users'> Dejar de seguir</i>");
             $("#dar").removeClass("btn-success");
             $("#dar").addClass("btn-danger");
             $("#dar").prop("id", "quitar");
              unfollow();
            });
        });
    }

    function unfollow(params) {
        $("#quitar").on("click", function () {
          $.post("./funcionesphp/darquitar.php", {
              id_seguido: $(".valores").val(),
              id_seguidor: $(".valores").prop("id"),
              accion: "quitar"
            },
            function (data) {
             $("#quitar").html("<i class='fas fa-users'> Seguir</i>");
             $("#quitar").removeClass("btn-danger");
             $("#quitar").addClass("btn-success");
             $("#quitar").prop("id", "dar");
              follow();
            });
        });
      } 

    
}


});  