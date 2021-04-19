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
      case "biblio":
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
      let error=false;
     $("#formusuario").submit();
    });
     $.validator.addMethod('usuarioexiste', function(value, element) {
      var ret = false;
      if(value==$("#usuariohidden").val()){
        return true;
      }
      $.ajax({url:"./funcionesphp/comprobar.php", data: {usuario: value}, type:"POST"
        ,async: false, dataType: "text", success: function(data) { ret= data; }
          }
    
          );  
          if(ret==true) return true;  
                                                
      },"El usuario existe, prueba otro");

      $.validator.addMethod('emailexiste', function(value, element) {
        var ret = false;

        if(value==$("#emailhidden").val()){
          return true;
        }

        $.ajax({url:"./funcionesphp/comprobar.php", data: {email: value}, type:"POST"
          ,async: false, dataType: "text", success: function(data) { ret= data; }
            }
      
            );  
            if(ret==true) return true;                                            
        },"Este email ya esta registrado");

        $.validator.addMethod('strongPassword', function(value, element) {
          return this.optional(element) 
            || value.length >= 6
            && /\d/.test(value)
            && /[a-z]/i.test(value);
        }, 'La contraseña es debil, tiene que tener seis letras, un numero al menos y un caracter\'.')

     $("#formusuario").validate({
      rules: {
  
          usuario: {
              required: true,
              nowhitespace: true,
              usuarioexiste:true,
              minlength:6,
              maxlength:15
          },
        email: {
          required: true,
          email: true,
          emailexiste: true
        },
        contra: {
          required: true,
          strongPassword: true
        },
        
      
       
      },
      messages: {
        email: {
          required: 'El campo es obligatorio',
          email: 'No es un <em>valid</em> email correcto',
          
        },

        contra:{
          required: 'El campo es obligatorio',
        
        },
        usuario: { required: "El campo es obligatorio", minlength: "El usuario debe tener minimo 6 caracteres",maxlength: "El usuario debe tener minimo 15 caracteres"
      }
      },
      submitHandler: function(form) {
        
        var f = document.getElementById("subidaimg");
        var img = f.files[0];
        var data = new FormData();
  
        data.append('file', img);
        data.append("img", $("#subidaimg").val());
        data.append("username", $("#usuario").val());
        data.append("email", $("#email").val());
        data.append("nomyape", $("#nomyape").val());
        data.append("usuario", $(".valores").val());
        data.append("contra", $("#contra").val());

        $.ajax({
          url: "./funcionesphp/actualizaruser.php",
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

        return false;  
    }
    });


















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