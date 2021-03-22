$(document).on("ready", function() {
   ta = $(".com").size();
   alert(ta);
    x=3;
    $('.com div:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('#myList li:lt('+x+')').show();
    });
    $('#showLess').click(function () {
        x=(x-5<0) ? 3 : x-5;
        $('#myList li').not(':lt('+x+')').hide();
    });






   $("#mn").on("change keyup keydown paste cut copy", function () {
      if($("#mn").val()==""){
     
         $("#enviarcoment").prop('disabled', true);
      }else{
     
         $("#enviarcoment").prop('disabled', false);
      }
   });

   $("#submit_comment").on("click", function () {
    
      resp1();
  
      $("#commentarionew").text("");
     
      
   }); 

   $(".resp2").on("click", function () {
     
      var res=$(this).data("id");
      var us=$(this).data("value");
      $("#commentarionew").text("Responder a @"+us);
      resp2(res, us);
     
           

   });

   function resp1() {
      var is_sending = 0;
    
      var res;
      $("#enviarcoment").unbind().bind("click", function () {
        if(is_sending==1) return false;
         $.ajax({url:"./funcionesphp/insertarcomentario.php", data: {id_usuario:$("#sesionnum").text(), mensaje:$("#mn").val(), id_obra:$("#obranum").text()}, type:"POST"
         , dataType: "text", 
         
          complete: function () {
            is_sending = 0;
          },
           
         beforeSend: function () {
            is_sending = 1;
          },
         
         success: function(data) { 
            is_sending = 0;
           
            res= data; 
            $("#comments-wrapper").html(res);
            $("#comments_count").text(function (i, orig) {
               return parseInt(orig)+1;
             
            }); 
   
            $("#coment").modal('toggle');
               $("#mn").val("");
               $("#commentarionew").text("");
               $("#enviarcoment").prop('disabled', true);

               $("#submit_comment").on("click", function () {
                  resp1();
               });
               $(".resp2").on("click", function () {
        
                  var res=$(this).data("id");
                  var us=$(this).data("value");
                  $("#commentarionew").text("Responder a @"+us);
                  resp2(res, us);
                 
                       
            
               });

         }
           }
     
           );
         

            


      });

     

   }

   function resp2(res,us) {
     
      var respuesta;
      $("#enviarcoment").unbind().bind("click", function () {
         $("#commentarionew").text("");
         $.ajax({url:"./funcionesphp/insertarcomentario.php", data: {id_usuario:$("#sesionnum").text(), mensaje:"@"+us+" "+$("#mn").val(), id_obra:$("#obranum").text(), res:res}, type:"POST"
         , dataType: "text", success: function(data) { 
            
            respuesta= data; 
            $("#comments-wrapper").html(respuesta);
            $("#comments_count").text(function (i, orig) {
               return parseInt(orig)+1;
             
            }); 
   
            $("#coment").modal('toggle');
            $("#mn").val("");
            $("#enviarcoment").prop('disabled', true);
            $("#submit_comment").on("click", function () {
               resp1();
            });
            $(".resp2").on("click", function () {
     
               var res=$(this).data("id");
               var us=$(this).data("value");
               $("#commentarionew").text("Responder a @"+us);
               resp2(res, us);
              
                    
         
            });
         
         }
           }
     
           );
          
       
        
 

      });
     
   }


});