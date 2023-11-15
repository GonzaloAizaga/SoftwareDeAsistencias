<?php
    class Profesores{
    public $idp;
    public $nombre_p;
    public $apellido_p;
    public $fechaNacimiento_p;
    public $dni_p;

    public function __construct($idp, $nombre_p, $apellido_p, $dni_p, $fechaNacimiento_p){
        $this -> idp = $idp;
        $this -> nombre_p = $nombre_p;
        $this -> apellido_p = $apellido_p;
        $this -> dni_p = $dni_p;
        $this -> fechaNacimiento_p = $fechaNacimiento_p;
    }
}
?>