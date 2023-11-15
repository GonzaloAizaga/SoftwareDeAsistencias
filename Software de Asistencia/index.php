<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software de Asistencia</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <script src="js/sweetAlert.js"></script>
    <!--Inicio de la barra superior -->
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                  <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                  <a class="nav-link" href="Alumnos.php">Alumnos</a>
                  <a class="nav-link" href="Profesores.php">Profesores</a>
                </div>
            </div>
            </div>
        </nav>
        <a class="nav-link justify-content-end" href="Configuracion.html">Configuración <img src="media/gear.svg"></a>
    </nav>
    <!--Fin de la barra superior -->
    <br>
    <h1>Bienvenido</h1>
    <br>
    <div class="d-flex justify-content-center">
        <form action="index.php" method="post"> 
            <label for="dato">Ingrese el DNI:</label>
            <input type="text" name="dato" required>
            <input class="btn btn-primary" type="submit" value="Enviar">
        </form>
    </div>          

    <!--  Boton Trait Simulacro Parcial  -->       
     <!--
        <div class="contenedor">
            <a class="btn btn-primary justify-content-end" href="PruebaTraits/P_main.php">CALCULAR </a>
        </div> 
     -->

<?php   
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dato"])) {
    $dato = $_POST["dato"];
    
    $sql = "SELECT nombre, apellido, dni FROM alumnos WHERE dni = :dato";
    $STMT = $conn->prepare($sql);
    $STMT->bindParam(":dato", $dato, PDO::PARAM_STR);
    $STMT->execute();
    
    $rowCount = $STMT->rowCount();

    if ($rowCount == 0) { 
        ?>
            <div class="container mt-3">

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                    El DNI no pertenece a ningún alumno.
                </div>
            </div>
        <?php
    } else {
        $Alum = $STMT->fetchAll(PDO::FETCH_ASSOC);
        foreach ($Alum as $element) {
            $nombre_alum = $element["nombre"];
            $apellido_alum = $element["apellido"];
            $dni_alum = $element["dni"];
        ?>
    <br>
    <br>
    
    <div class="position-relative">
        <div class="p-3 mb-2 bg-light-subtle text-emphasis-light">
            <div class="text-center">   
                <div class="h2">
                    <div ><?php echo $nombre_alum." ".$apellido_alum; ?></div>
                    <div class="text-success"><?php echo $dni_alum; ?></div>
                        
                    <form method="POST" action="index.php">
                        <input type="hidden" name="dniAsistenciaA" value="<?php echo $dni_alum;?>">
                        <br>
                        <button type="submit" class="btn btn-success" name="botonAsistIndex"><img src="media/calendar2-check.svg"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php 
        }
    }
}
    ?>
    </body>
<script src="js/bootstrap.min.js"></script>
</html>

<?php
if (isset($_POST['botonAsistIndex'])) {   
    $dniSumAsist=$_POST["dniAsistenciaA"];
    $sql = "SELECT dni FROM asistencias";
    $STMT = $conn -> prepare($sql);
    $STMT -> execute();
    $Asist = $STMT-> fetchAll();
    foreach($Asist as $element){
        $dni_alum =($element["dni"]);

    }
    $sqlVerificarAsistencia = "SELECT COUNT(*) AS existencia FROM asistencias WHERE dni = :dni AND DATE(asistencia) = CURDATE()";
    $STMTVerificar = $conn->prepare($sqlVerificarAsistencia);
    $STMTVerificar->bindParam(":dni", $dniSumAsist);
    $STMTVerificar->execute();
    $resultadoVerificar = $STMTVerificar->fetch(PDO::FETCH_ASSOC);

    if ($dniSumAsist && $resultadoVerificar["existencia"] == 0) {
        $sqlInsert = "INSERT INTO asistencias(dni, asistencia) VALUES (:dni, NOW())";
        $STMTInsert = $conn->prepare($sqlInsert);
        $STMTInsert->bindParam(":dni", $dniSumAsist);
        $STMTInsert->execute();

        echo '<script> Swal.fire({
            icon: "success",
            title: "Asistencia registrada con exito",
        }).then(function() {
            window.location.href = "index.php";
        });</script>';

    } else {
        echo '<script> Swal.fire({
            icon: "error",
            title: "Asistencia ya registrada",
        }).then(function() {
            window.location.href = "index.php";
        });</script>';
    }
}