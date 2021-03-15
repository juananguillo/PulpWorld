
$(document).on("ready", function () {
    var valor=false;


  $.validator.addMethod('strongPassword', function(value, element) {
    return this.optional(element) 
      || value.length >= 6
      && /\d/.test(value)
      && /[a-z]/i.test(value);
  }, 'La contraseña es debil, tiene que tener seis letras, un numero al menos y un caracter\'.')

  $.validator.addMethod('comparar', function(value, element) {
    alert($("#contrareg").val()+"+"+value);
    return this.optional(element) 
      || value==$("#contrareg").val();
  }, 'No coincide con la primera contraseña\'.')

  $.validator.addMethod('usuarioexiste', function(value, element) {
    var ret = false;
    $.ajax({url:"./funcionesphp/comprobar.php", data: {usuario: value}, type:"POST"
      ,async: false, dataType: "text", success: function(data) { ret= data; }
        }
  
        );  
        if(ret==true) return true;                                            
    },"El usuario existe, prueba otro");

    $.validator.addMethod('emailexiste', function(value, element) {
      var ret = false;
      $.ajax({url:"./funcionesphp/comprobar.php", data: {email: value}, type:"POST"
        ,async: false, dataType: "text", success: function(data) { ret= data; }
          }
    
          );  
          if(ret==true) return true;                                            
      },"Este email ya esta registrado");

  $("#registroform").validate({
    rules: {

        usureg: {
            required: true,
            nowhitespace: true,
            usuarioexiste:true,
            minlength:6,
            maxlength:15
        },
      emailreg: {
        required: true,
        email: true,
        emailexiste: true
      },
      contrareg: {
        required: true,
        strongPassword: true
      },
      contrareg2: {
        required: true,
        comparar: true
       
      },
      
     
    },
    messages: {
      email: {
        required: 'El campo es obligatorio',
        email: 'No es un <em>valid</em> email correcto',
        
      },
      usureg: { required: "El campo es obligatorio", minlength: "El usuario debe tener minimo 6 caracteres",maxlength: "El usuario debe tener minimo 15 caracteres"
    }
    }
  });


  $.validator.addMethod('comprobarusuario', function(value, element) {
    var ret = false;
    $.ajax({url:"./funcionesphp/formulariosusuario.php", data: {usulog: value, contralog: $("#contralog").val()}, type:"POST"
      ,async: false, dataType: "text", success: function(data) { ret= data; }
        }
  
        );  
       
        if(ret==true) return true;                                            
    },"El usuario o contraseña son incorrectos");




  $("#iniciosesion").validate({
    onkeyup: false,
    onclick: false,
    onfocusout: false,
    rules: {
        usulog: {
            required: true,
            nowhitespace: true,
            comprobarusuario:true,
           
        },
      
      contrareg: {
        required: true,
      },
      
      
     
    },
    messages: {
  
      usureg: { required: "El campo es obligatorio", minlength: "El usuario debe tener minimo 6 caracteres",maxlength: "El usuario debe tener minimo 15 caracteres"
    }
    }
  });






});
