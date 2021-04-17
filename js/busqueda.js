$(document).on("ready", function () {
$(".guardarobra").on("click", function () {
  
  $.post("./funcionesphp/biblioteca.php", {
    id_o: $(this).val(),
    id_bi: $("#biblioteca").val(),
},
function (data) {
    alert(data);

});

})

});