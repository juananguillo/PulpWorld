<?php 

class usuario
{
    private $id;
    private $email;
    private $usuario;
    private $contra;
    private $nomyape;
    private $tipo;
    private $estado;
    private $foto;
    
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }



    public function setemail($email) {
        $this->email = $email;
    }

    public function getemail(){
        return $this->email;
    }

    public function setusuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getusuario(){
        return $this->usuario;
    }

    public function setcontra($contra) {
        $this->contra = $contra;
    }

    public function getcontra(){
        return $this->contra;
    }


    public function setdni($dni) {
        $this->dni = $dni;
    }

    public function getdni(){
        return $this->dni;
    }

    public function setnomyape($nomyape) {
        $this->nomyape = $nomyape;
    }

    public function getnomyape(){
        return $this->nomyape;
    }

    public function setdireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getdireccion(){
        return $this->direccion;
    }


    public function setprovincia($provincia) {
        $this->provincia = $provincia;
    }

    public function getprovincia(){
        return $this->provincia;
    }


    public function settipo($tipo) {
        $this->tipo = $tipo;
    }

    public function gettipo(){
        return $this->tipo;
    }

    public function setestado($estado) {
        $this->estado = $estado;
    }

    public function getestado(){
        return $this->estado;
    }


    public function setfoto($foto) {
        $this->foto = $foto;
    }

    public function getfoto(){
        return $this->foto;
    }





}

?>
