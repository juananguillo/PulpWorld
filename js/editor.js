tinymce.init({
    selector: 'textarea', // change this value according to your HTML
    menubar: 'edit insert ',
    statusbar: false, // skip file
    language: 'es',
    alignjustify: {
        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img',
        classes: 'full'
    },

    plugins : "paste",
    paste_as_text: true,
    //plugins: 'tinymcespellchecker',
    //spellchecker_active: true,
    toolbar: 'spellchecker | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    spellchecker_dialog: true,
    setup: function (editor) {
		editor.on('init', function (e) {
		   editor.execCommand('JustifyFull', false);
		});
	}

    
});


$(document).on("ready", function () {
    setInterval(guardar, 300000);
    function guardar() {
        var htmldata = tinymce.get('textarea').getBody().innerHTML;
        var titulo = $("#titulocap").val();
        var idcap = $("#idcap").val();
        $.post("./funcionesphp/editcapitulo.php", {
                id: idcap,
                titulo: titulo,
                contenido: htmldata
            },
            function (data) {
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                $("#gauto").text(time);

            });

      }
    $("#guardar").on("click", function () {
      guardar();
    });
});