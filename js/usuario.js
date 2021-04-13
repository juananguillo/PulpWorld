$(document).on("ready", function () {
  
    $(".redi").on("click", function () {
      var href = $(this).attr('href');
      var usuario = $("#usuid").val();
      window.history.pushState({}, '', '?user=' + usuario + '&section=' + href.substr(1));
  
  
    });
    var section = getParameterByName('section');
  
    switch (section) {
      case "personal":
        $("#navpers").click();
  
        break;
      case "biblioteca":
        $("#navbi").click();
  
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
    });
  
    $("#guardar").on("click", function () {
      $("#err").hide();
      var error = false;
        if ($("#titobra").val() == "" || $("#titobra").val().length == 0 || /^\s+$/.test($("#titobra").val())) {
          $("#titobra").focus();
          $("#titobra").css("border-color", "red");
          $("#err").text("Es necesario añadir un titulo a la obra");
          $("#err").css("color", "red");
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
           alert("Datos guardados con exito");
          }
        });
  
  
      }
  
  
  
    });
  
  });