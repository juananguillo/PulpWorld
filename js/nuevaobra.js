$(document).on("ready", function () {
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
        alert( $("#subidaimg").val());
        if($("#titobra").val()=="" || $("#titobra").val().length==0|| /^\s+$/.test($("#titobra").val())){
            $("#titobra").focus();
            $("#titobra").css("border-color", "red");
            $("#err").text("Es necesario añadir un titulo a la obra");
            $("#err").css("color", "red");
        }
        else{
            var f=document.getElementById("#imgform");
            var data = new FormData(f);
            jQuery.each(jQuery('#subidaimg')[0].files, function(i, file) {
                data.append('file-'+i, file);
            });
            alert(data);
           
            $.ajax({
                url: "./funcionesphp/nuevaobra.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    alert(data);
                }
            });

        }
  

        
    });

});