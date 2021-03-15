<?php 

function conectardb(){
    try {
        $conn = new PDO('mysql:host=localhost;dbname=pulpworld', 'pulpad', 'jusaxi88');
        //$conn = new PDO('mysql:host=sql310.epizy.com;dbname=epiz_27521049_cafeses_db', 'epiz_27521049', '82ZsH3AAUH6rg8');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (\Throwable $th) {
        echo $th->getMessage();
        //header("Location: error.php?error=Error al cargar la base de datos");
    }
}

?>