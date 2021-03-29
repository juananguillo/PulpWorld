$(document).on("ready", function () {
  
  $(".redi").on("click", function () { 
    var href=$(this).attr('href');
    var obra=$("#obraid").val()
    window.history.pushState( {} , '', '?obra='+obra+'&section='+href.substr(1) );
   
    
  });
  var section= getParameterByName('section');

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
                  
        $('#categorias option[value='+$(this).attr('id')+']').prop("disabled", true);
        $(".sel").on("click", function () {
            $('#categorias option[value='+$(this).attr('id')+']').prop("disabled", false);
            $(this).remove();
        });
    })
   
    $("#categorias").on("change", function () {
      $("#err2").hide(); 
        if($(".sel").length<=3) {
      $("#selecat").html(function (i, orig) {  
          return orig + " <p id="+$("#categorias").val()+" class='btn btn-primary sel'>"+$('#categorias option:selected').text()+" <span aria-hidden='true'>&times;</span></p>";
      });
      $('#categorias option:selected').prop("disabled", true);
      $("#categorias").val(0);
      $(".sel").on("click", function () {
          $('#categorias option[value='+$(this).attr('id')+']').prop("disabled", false);
          $(this).remove();
      });
  }   
    });
      function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#port').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
  
        $("#subidaimg").on("change",function() {
          readURL(this);
        });
  
      $("#guardar").on("click", function () {
          var error=false;
          if($("#subidaimg").val()=="")
          if($("#titobra").val()=="" || $("#titobra").val().length==0|| /^\s+$/.test($("#titobra").val())){
              $("#titobra").focus();
              $("#titobra").css("border-color", "red");
              $("#err").text("Es necesario añadir un titulo a la obra");
              $("#err").css("color", "red");
              error=true;
          }
           if($(".sel").length==0){
              $("#err2").show();
              $("#err2").text("Es necesario añadir una categoria");
              $("#err2").css("color", "red");
              error=true;
          }
          if(!error){
              var f=document.getElementById("subidaimg");
               var img =f.files[0];
              var data = new FormData();
  
              data.append('file', img);
              data.append("img", $("#subidaimg").val());
              data.append("titulo", $("#titobra").val());
              data.append("sinopsis", $("#sinopsisobra").val());
              data.append("sinopsis", $("#sinopsisobra").val());
              data.append("autor", $("#autor").val());
              var array=[];
              
              $(".sel").each(function () {
                  
                  array.push($(this).attr('id'));
              })
           
              
              data.append("cat", array);
             
              
              $.ajax({
                  url: "./funcionesphp/crearobra.php",
                  data: data,
                  cache: false,
                  contentType: false,
                  processData: false,
                  method: 'POST',
                  type: 'POST',
                  success: function(data){
                     
                  window.location.replace("./obra.php?obra="+data);
                  }
              });
          
  
          }
    
  
          
      });
  
  });