<?php
require_once("conexion.php");
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numClases"]) && isset($_POST["porcProm"]) && isset($_POST["porcReg"])){
    $dia_clases=$_POST["numClases"];
    $paramProm=$_POST["porcProm"];
    $paramReg=$_POST["porcReg"];

    if($dia_clases&&$paramProm&&$paramReg<>null){
      $queryInsertNumClases = "UPDATE parametros SET dia_clases = $dia_clases, paramProm=$paramProm, paramReg=$paramReg";
      $statement = $conn->prepare($queryInsertNumClases);
      $statement -> execute();
      echo '<script language="javascript">alert("NUMERO DE CLASES REGISTRADO CON EXITO");window.location.href="Configuracion.html"</script>';
    }
    else{
      echo '<script language="javascript">alert("Algo salio mal");window.location.href="Configuracion.html"</script>';
    }
}
?>