<?php 

class marcapaginas
{
    private $id_usuario;
    private $id_obra;
    private $id_capitulo;
    
    
    
    public function setid_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getid_usuario(){
        return $this->id_usuario;
    }

    public function setid_obra($id_obra) {
        $this->id_obra = $id_obra;
    }

    public function getid_obra(){
        return $this->id_obra;
    }

    public function setid_capitulo($id_capitulo) {
        $this->id_capitulo = $id_capitulo;
    }

    public function getid_capitulo(){
        return $this->id_capitulo;
    }


    

}

?>
