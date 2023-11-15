<?php
    require_once("../conexion.php");

    $dniBajaProfesor = $_REQUEST["dniProfesorDLT"];
    $sqlDLTProfesor="DELETE FROM profesores WHERE dni=$dniBajaProfesor";
    $statement = $conn->prepare($sqlDLTProfesor);  
    $statement -> execute();

    if($sqlDLTProfesor){
        header("location: ../Profesores.php");
    }
?>