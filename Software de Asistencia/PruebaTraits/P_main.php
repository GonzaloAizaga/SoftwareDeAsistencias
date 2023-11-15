<?php
    require_once("P_calcular.php");
 
    class Estudiante{
        use Calculo;
        public $porcentaje; 
        public $nota1;
        public $nota2;
        public function __construct($porcentaje, $nota1, $nota2){
            $this->porcentaje = $porcentaje;
            $this->nota1 = $nota1;
            $this->nota2 = $nota2;
        }
        public function getResul(){
            return [
                "porcentaje" => $this->porcentaje,
                "nota1" => $this->nota1,
                "nota2" => $this->nota2,
            ];
        }   
    }
    $estudiante = new Estudiante(100, 5, 7);
    $resultado = $estudiante->Calcularr([
        "porcentaje" => $estudiante->porcentaje,
        "nota1" => $estudiante->nota1,
        "nota2" => $estudiante->nota2,
    ]);
    
    echo $resultado;
?> 

