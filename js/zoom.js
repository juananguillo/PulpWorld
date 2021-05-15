$(document).on("ready", function () {
    let divtxt = $('p');
    $('#zoomin').click(function() {
        var curSize = divtxt.css('fontSize');
        var newSize = parseInt(curSize.replace("px", "")) + 1;
        $(divtxt).css("fontSize", newSize + "px");
        });
        $('#zoomout').click(function() {
        var curSize = divtxt.css('fontSize');
        var newSize = parseInt(curSize.replace("px", "")) - 1;
        $(divtxt).css("fontSize", newSize + "px");
        })
    

});