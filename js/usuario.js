$(document).on("ready", function () {
  

  function showmoreuser() {
    let total = $("#showmorebuttonobra li").size();
   var x=10;
    $('#showLessbuttonobra').hide();
    $('#showmorebuttonobra li:lt('+x+')').show();
    $('#loadMorebuttonobra').click(function () {
       if(x<total){
        x+=10;
        $('#showmorebuttonobra li:lt('+x+')').show();
        $('#showLessbuttonobra').show();
       }
       if(x>total){
          $('#loadMorebuttonobra').hide();
       }
 
    });
    $('#showLessbuttonobra').click(function () {
      
       if(x>10){
        x-=10;
        $('#showmorebuttonobra li').not(':lt('+x+')').hide();
      if(x==10){
       $('#showLessbuttonobra').hide();
   
 
      }
      $('#loadMorebuttonobra').show();
        }else{
     
          $('#showLessbuttonobra').hide();
          $('#loadMorebuttonobra').show();
        }
    });
   }




  if($("#showmorebuttonobra li").size()<10){
    $('#loadMorebuttonobra').hide();
 }



 showmoreuser();


 function showmoreuser2() {
  let total = $("#showmorebuttonobra2 li").size();
 var x1=10;
  $('#showLessbuttonobra2').hide();
  $('#showmorebuttonobra2 li:lt('+x1+')').show();
  $('#loadMorebuttonobra2').click(function () {
     if(x1<total){
      x1+=10;
      $('#showmorebuttonobra2 li:lt('+x1+')').show();
      $('#showLessbuttonobra2').show();
     }
     if(x1>total){
        $('#loadMorebuttonobra2').hide();
     }

  });
  $('#showLessbuttonobra2').click(function () {
    
     if(x1>10){
      x1-=10;
      $('#showmorebuttonobra2 li').not(':lt('+x1+')').hide();
    if(x1==10){
     $('#showLessbuttonobra2').hide();
 

    }
    $('#loadMorebuttonobra2').show();
      }else{
   
        $('#showLessbuttonobra2').hide();
        $('#loadMorebuttonobra2').show();
      }
  });
 }
 if($("#showmorebuttonobra2 li").size()<10){
  $('#loadMorebuttonobra2').hide();
}

 showmoreuser2();


  $("#formusuario :input").change(function() {
   nosave();
  });

  function nosave() {
    $("#alert").text("Existen datos sin guardar");
    $("#alert").addClass("alert alert-danger text-center");
    }

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
      nosave();
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
        ,async: false, dataType: "text", success: function(data) {
           ret= data; }
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
          ,async: false, dataType: "text", success: function(data) { 
            ret= data; }
            }
      
            );  
            if(ret==true) return true;                                            
        },"Este email ya esta registrado");

       

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
       
      },
      messages: {
        email: {
          required: 'El campo es obligatorio',
          email: 'No es un <em>valid</em> email correcto',
          
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

        $.ajax({
          url: "./funcionesphp/actualizaruser.php",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function (data) {
            if(data=="block"){
              window.location.replace("./funcionesphp/sesion.php?logout=yes&index=yes");
            }else{
            $("#emailhidden").val($("#email").val());
            $("#usuariohidden").val($("#usuario").val());
            $("#alert").text("");
            $("#alert").removeClass("alert alert-warning text-center");
           alert("Datos guardados con exito");
            }
          }
        });

        return false;  
    }
    });


    $.validator.addMethod('comparar', function(value, element) {
    
      return this.optional(element) 
        || value==$("#contraold").val();
    }, 'La contraseña no coincide')


   

    
    $("#cambiarcontra").validate({
      rules: {
  
          contraold: {
              required: true,
              strongPassword:true
              
              
          },
        contranew: {
          required: true,
          strongPassword:true,
          comparar: true
          
        },
       
      },
      messages: {
        contranew: {
          required: 'El campo es obligatorio', 
        },
        contraold: {
          required: 'El campo es obligatorio', 
        },
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
        data.append("contra", $("#contranew").val());

        $.ajax({
          url: "./funcionesphp/actualizaruser.php",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function (data) {
            if(data=="block"){
              window.location.replace("./funcionesphp/sesion.php?logout=yes&index=yes");
            }else{
           alert("Contraseña cambiada con exito");
           $("#contranew").val('');
           $("#contraold").val('');
           $("#cerrarmodal").click();
            }
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