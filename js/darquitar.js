$(document).on("ready", function () {
    if ($("#obraid").length ) {
    like();
    dislike();
  function like (params) {
    $("#dar").one("click", function () {
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
         let likes=parseInt($("#thislikes").text());
         $("#thislikes").text(likes+1);
          dislike();
        });
    });
  }
    function dislike(params) {
      $("#quitar").one("click", function () {
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
           let likes=parseInt($("#thislikes").text());
           $("#thislikes").text(likes-1);
            like();
          });
      });
    }
}
else{
    follow();
    unfollow();
    function follow (params) {
        $("#dar").one("click", function () {
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
             let likes=parseInt($("#thisseguidores").text());
             $("#thisseguidores").text(likes+1);
              unfollow();
            });
        });
    }

    function unfollow(params) {
        $("#quitar").one("click", function () {
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
             let likes=parseInt($("#thisseguidores").text());
             $("#thisseguidores").text(likes-1);
              follow();
            });
        });
      } 

    
}


});  