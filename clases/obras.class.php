<?php 

class obras
{
    private $id;
    private $autor;
    private $titulo;
    private $sinopsis;
    private $publico;
    private $lecturas;
    private $estado;
    private $likes;
    private $portada;
    private $terminada;
    
    
    public function setid($id) {
        $this->id = $id;
    }

    public function getid(){
        return $this->id;
    }


    public function getterminada(){
        return $this->terminada;
    }


    public function setautor($autor) {
        $this->autor = $autor;
    }

    public function getautor(){
        return $this->autor;
    }

    public function settitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function gettitulo(){
        return $this->titulo;
    }

    public function setsinopsis($sinopsis) {
        $this->sinopsis = $sinopsis;
    }

    public function getsinopsis(){
        return $this->sinopsis;
    }
   

    public function setlecturas($lecturas) {
        $this->lecturas = $lecturas;
    }

    public function getlecturas(){
        return $this->lecturas;
    }

    public function setpublico($publico) {
        $this->publico = $publico;
    }

    public function getpublico(){
        return $this->publico;
    }


    public function setlikes($likes) {
        $this->likes = $likes;
    }

    public function getlikes(){
        return $this->likes;
    }


    public function setestado($estado) {
        $this->estado = $estado;
    }

    public function getestado(){
        return $this->estado;
    }

    public function setportada($portada) {
        $this->portada = $portada;
    }

    public function getportada(){
        return $this->portada;
    }


    

}

?>
