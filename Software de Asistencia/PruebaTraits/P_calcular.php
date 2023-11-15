<?php
    require_once("P_main.php");
    trait Calculo{
        public function Calcularr($estudiante){
            $porcentaje=$estudiante["porcentaje"];
            $nota1=$estudiante["nota1"];
            $nota2=$estudiante["nota2"];
            $promedioNotas = ($nota1 + $nota2) /2; 
            $resultado="";
            if ($porcentaje >=80 && $promedioNotas >= 8){
                $resultado= "PROMOCION";
            }
            elseif (($porcentaje <=100 && $porcentaje >=60) && $promedioNotas >= 6){
                $resultado= "REGULAR";
            }
            else{
                $resultado= "LIBRE";
            }
        return $resultado;
    }   
}
?> 
