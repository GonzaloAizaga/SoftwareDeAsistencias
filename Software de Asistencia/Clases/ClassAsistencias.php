<?php 
    class Asistencias{
        public $asistencias;
        public $ausente;
        public $fecha_asistencia;
        public $fecha_ausente;
        public $asistencias_p;
        public $ausentes_p;
        
    public function __construct($asistencias,$ausente,$fecha_asistencia,$fecha_ausente){
        $this -> asistencias = $asistencias;
        $this -> ausente = $ausente;
        $this -> fecha_asistencia = $fecha_asistencia;
        $this -> fecha_ausente = $fecha_ausente;
    }
    public function aumentarfalta($cantidad){
        $this->$asistencias=$this->saldo+$cantidad; 
    }
    }
        
?>