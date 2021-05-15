<?php 

function conectardb(){
    try {
            $conn = new PDO('mysql:host=db5001953685.hosting-data.io;dbname=dbs1597550', 'dbu746757', 'Jusaxi88-2-452');
        //$conn = new PDO('mysql:host=localhost;dbname=pulpworld', 'pulpad', 'jusaxi88');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (\Throwable $th) {
        echo $th->getMessage();
        //header("Location: error.php?error=Error al cargar la base de datos");
    }
}

?>