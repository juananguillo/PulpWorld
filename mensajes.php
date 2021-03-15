<?php 
    include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="mensajes.css">
    <script src="js/mensajes.js"></script>
    </head>
<body>
<?php 
    include("Includes/nav.php");
    ?>
<div class="container">
<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
            <div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history" id="mensajes">
          <?php   
   try {
    $conn = new PDO('mysql:host=localhost;dbname=bda', 'BDA1', 'jefazo');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (\Throwable $th) {
    echo $th->getMessage();
}
   
   $sentencia = $conn->prepare("SELECT mensaje FROM mensajes WHERE id_emisor like 1 AND id_receptor like 2");
    $sentencia->execute();
    $array= array();
    $i=0;
    while($datos = $sentencia->fetch() ){
    ?>
     <div class="incoming_msg">
              <div class="incoming_msg_img"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p><?php echo $datos[0]; ?></p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <?php  
        
    }
    ?>


           
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all
                  solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
            
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
     
      
    </div></div>
    </body>

 <?php 
include("Includes/footer.php")
?>
</body>


</html>