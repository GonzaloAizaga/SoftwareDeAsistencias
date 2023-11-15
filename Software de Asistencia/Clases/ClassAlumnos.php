<?php
class Alumnos{
    public $nombre;
    public $apellido;
    public $dni;
    public $fechaNacimiento;
        
    public function __construct($nombre, $apellido, $dni, $fechaNacimiento){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->fechaNacimiento = $fechaNacimiento;
    }
    public static function obtenerDatosAlumno($dni){
        $queryDatos=("SELECT * FROM alumnos WHERE dni = $dni");
        return $queryDatos;
    }   
        
}
?> 