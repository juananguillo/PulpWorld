<?php 

class mensajes
{
    private $id;
    private $id_emisor;
    private $id_receptor;
    private $contenido;
    private $leido;
    
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }

    public function setid_emisor($id_emisor) {
        $this->id_emisor = $id_emisor;
    }

    public function getid_emisor(){
        return $this->id_emisor;
    }

    public function setid_receptor($id_receptor) {
        $this->id_receptor = $id_receptor;
    }

    public function getid_receptor(){
        return $this->id_receptor;
    }

    public function setcontenido($contenido) {
        $this->contenido = $contenido;
    }

    public function getcontenido(){
        return $this->contenido;
    }

    public function setleido($leido) {
        $this->leido = $leido;
    }

    public function getleido(){
        return $this->leido;
    }


    

}

?>
