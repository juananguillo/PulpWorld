tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
menubar: 'edit insert ',
statusbar: false,  // skip file
language: 'es',
alignjustify: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
plugins: 'tinymcespellchecker',
//spellchecker_active: true,
toolbar: 'spellchecker | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
spellchecker_dialog: true
});


$(document).on("ready", function () {
    $("#guardar").on("click", function () {
        var htmldata = tinymce.get('textarea').getBody().innerHTML;
//alert(htmldata);
tinymce.get('textarea').getBody().innerHTML=htmldata+"Gurad";
    });
});