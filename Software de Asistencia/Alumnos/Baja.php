<?php
    require_once("../conexion.php");

    $dniBajaAlumno = $_REQUEST["dniAlumnoDLT"];
    $sqlDLTAlumno="DELETE FROM alumnos WHERE dni=$dniBajaAlumno";
    $statement = $conn->prepare($sqlDLTAlumno);  
    $statement -> execute();

    if($sqlDLTAlumno){
        header("location: ../Alumnos.php");
    }
?>