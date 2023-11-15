<?php
require_once("conexion.php");

$sql_total_dias= "SELECT dia_clases FROM parametros";
$STMT = $conn->prepare($sql_total_dias);
$STMT->execute();
$total_dias = $STMT->fetchColumn();

$sql_asistencias = "SELECT dni, COUNT(*) AS asistencias FROM asistencias GROUP BY dni";
$STMT = $conn->prepare($sql_asistencias);
$STMT->execute();
$result = $STMT->fetchAll();

foreach ($result as $row) {
    $dni = $row["dni"];
    $asistencias = $row["asistencias"];   
    $porcentaje = ($asistencias / $total_dias) * 100;

}
$alum_prom = [];
$alum_promPor = [];
$alum_regulares = [];
$alum_regularesPor = [];

$sql_prom = "SELECT paramProm , paramReg  FROM parametros";
$STMT = $conn->prepare($sql_prom);
$STMT->execute();
$resultado = $STMT->fetchAll();
foreach ($resultado as $element) {
    $prom = $element["paramProm"];
    $reg = $element["paramReg"];
}

foreach ($result as $row) {
    $dni = $row["dni"];
    $asistencias = $row["asistencias"];
    $porcentaje = ($asistencias / $total_dias) * 100;
    if ($porcentaje>=$prom){
        $alum_prom[]=$dni;
        $alum_promPor[]=$porcentaje;
    }
    if ($porcentaje <= $reg && $porcentaje <= $prom){
        $alum_regulares[]=$dni;
        $alum_regularesPor[]=$porcentaje;
    }
    
}
?>
