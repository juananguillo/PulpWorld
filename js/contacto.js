$(document).on("ready", function () {

    $("#formcontact").validate({
        rules: {
    
            nombre: {
                required: true,
                nowhitespace: true,
            },
          email: {
            required: true,
            email: true
          },
          motivos: {
            required: true,
        
          },

          mensaje: {
            required: true,
            minlength:10,
            maxlength:250
        
          }
          
         
        },
        messages: {
          email: {
            required: 'El campo es obligatorio',
            email: 'No es un email correcto',
            
          },
    
          motivos:{
            required: 'El campo es obligatorio',
          },
          nombre: { required: "El campo es obligatorio", minlength: "El usuario debe tener minimo 6 caracteres",maxlength: "El usuario debe tener minimo 15 caracteres"
        },

        mensaje:{
            required: "El campo es obligatorio",  minlength: "El mensaje debe tener minimo 10 palabras",maxlength: "El mensaje debe tener maximo 250 palabras"
        }



        }
      });



});