$(document).on("ready", function () {
   
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
        let error=false;
        
        $("#err").hide();
        $("#titobra").css("border-color", "green");
        if($("#subidaimg").val()=="")
        if($("#titobra").val()=="" || $("#titobra").val().length==0|| /^\s+$/.test($("#titobra").val())){
            $("#titobra").focus();
            $("#titobra").css("border-color", "red");
            $("#err").text("Es necesario añadir un titulo a la obra");
            $("#err").css("color", "red");
            $("#err").show();
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
                  if(data=="block"){
                    window.location.replace("./funcionesphp/sesion.php?logout=yes&index=yes");
                  }else{
                window.location.replace("./obra.php?obra="+data);
                  }
                }
            });
        

        }
  

        
    });

});