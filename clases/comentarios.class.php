<?php 

class comentarios
{
    private $id;
    private $mensaje;
    private $id_usuario;
    private $id_obra;
    private $id_res;
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }



    public function setmensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getmensaje(){
        return $this->mensaje;
    }

    public function setdescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getdescripcion(){
        return $this->descripcion;
    }


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

    public function setid_res($id_res) {
        $this->id_res = $id_res;
    }

    public function getid_res(){
        return $this->id_res;
    }

   
}


  



?>
