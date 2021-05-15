$(document).on("ready", function () {


  $("#formobra :input").change(function() {
    nosave();
   });

   function nosave() {
    $("#alert").text("Existen datos sin guardar");
    $("#alert").addClass("alert alert-danger text-center");
    }


  $(".redi").on("click", function () {
    var href = $(this).attr('href');
    var obra = $("#obraid").val()
    window.history.pushState({}, '', '?obra=' + obra + '&section=' + href.substr(1));


  });
  var section = getParameterByName('section');

  switch (section) {
    case "comentarios":
      $("#navcom").click();

      break;
    case "sinopsis":
      $("#navdet").click();

      break;

    case "obra":
      $("#navcapi").click();

      break;

    default:
      break;
  }

  function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }

  $(".sel").each(function () {

    $('#categorias option[value=' + $(this).attr('id') + ']').prop("disabled", true);
    $(".sel").on("click", function () {
      $('#categorias option[value=' + $(this).attr('id') + ']').prop("disabled", false);
      $(this).remove();
    });
  })

  $("#categorias").on("change", function () {
    $("#err2").hide();
    if ($(".sel").length <= 3) {
      $("#selecat").html(function (i, orig) {
        return orig + " <p id=" + $("#categorias").val() + " class='btn btn-primary sel'>" + $('#categorias option:selected').text() + " <span aria-hidden='true'>&times;</span></p>";
      });
      $('#categorias option:selected').prop("disabled", true);
      $("#categorias").val(0);
      $(".sel").on("click", function () {
        $('#categorias option[value=' + $(this).attr('id') + ']').prop("disabled", false);
        $(this).remove();
      });
    }
    else{
      $("#categorias").val(0);
    }
    nosave();

  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#port').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#subidaimg").on("change", function () {
    readURL(this);
    nosave();
  });

  $("#guardar").on("click", function () {
    $("#err1").hide();
    $("#titobra").css("border-color", "green");
    var error = false;
      if ($("#titobra").val() == "" || $("#titobra").val().length == 0 || /^\s+$/.test($("#titobra").val())) {
        $("#titobra").focus();
        $("#titobra").css("border-color", "red");
        $("#err1").show();
        $("#err1").text("Es necesario añadir un titulo a la obra");
        $("#err1").css("color", "red");
        error = true;
      }
    if ($(".sel").length == 0) {
      $("#err2").show();
      $("#err2").text("Es necesario añadir una categoria");
      $("#err2").css("color", "red");
      error = true;
    }
    if (!error) {
      var f = document.getElementById("subidaimg");
      var img = f.files[0];
      var data = new FormData();

      data.append('file', img);
      data.append("img", $("#subidaimg").val());
      data.append("titulo", $("#titobra").val());
      data.append("sinopsis", $("#sinopsisobra").val());
      data.append("sinopsis", $("#sinopsisobra").val());
      data.append("obra", $(".valores").val());
      data.append("usuario", $(".valores").prop("id"));
      var array = [];

      $(".sel").each(function () {

        array.push($(this).attr('id'));
      })

      data.append("cat", array);


      $.ajax({
        url: "./funcionesphp/actualizarobra.php",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function (data) {
          console.log(data);
          if(data=="block"){
            window.location.replace("./funcionesphp/sesion.php?logout=yes&index=yes");
          }else{
            $("#alert").text("");
            $("#alert").removeClass("alert alert-warning text-center");
            $("#sinopsisobra").css("border-color", "green");
            alert("Datos guardados con exito");
          }
       
        }
      });


    }



  });

});