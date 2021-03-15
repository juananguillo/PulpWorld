<?php 

class capitulos
{
    private $id;
    private $titulo;
    private $contenido;
    private $publico;
    private $estado;
    private $id_obra;
    
    
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }



    public function setcontenido($contenido) {
        $this->contenido = $contenido;
    }

    public function getcontenido(){
        return $this->contenido;
    }

    public function settitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function gettitulo(){
        return $this->titulo;
    }


   

    public function setpublico($publico) {
        $this->publico = $publico;
    }

    public function getpublico(){
        return $this->publico;
    }




    public function setestado($estado) {
        $this->estado = $estado;
    }

    public function getestado(){
        return $this->estado;
    }

    public function setid_obra($id_obra) {
        $this->id_obra = $id_obra;
    }

    public function getid_obra(){
        return $this->id_obra;
    }


    

}

?>
