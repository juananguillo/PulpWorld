<?php 

class categorias
{
    private $id;
    private $nombre;
    private $sub;
    
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }



    public function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getnombre(){
        return $this->nombre;
    }

    public function setdescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getdescripcion(){
        return $this->descripcion;
    }


    public function setsub($sub) {
        $this->sub = $sub;
    }

    public function getsub(){
        return $this->sub;
    }

   
}


  



?>
