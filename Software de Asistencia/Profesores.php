<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Profesores</title>
</head>
<body>
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
    <!--Inicio del titulo de la tabla -->
    <br>
    <div class="container">
        <h2 class="text-center" style="color: black">Listado de Profesores</h2>
    </div>          
    <br>
    <!--Fin del titulo de la tabla -->
    <div class="container-clock">
        <p class="text-center" id="date">date</p>
    </div>
    <br>

    <script >       
     window.onload = function() {
            const date = document.getElementById('date');

            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            const interval = setInterval(() => {

                const local = new Date();

                let day = local.getDate(),
                    month = local.getMonth(),
                    year = local.getFullYear();

                date.innerHTML = `${day} ${monthNames[month]} ${year}`;

            }, 1000);
        }
    </script>

    <div class="container-fluid">
        <a class="btn btn-success" href="Profesores/Alta.php">Alta <img src="media/person-plus-fill.svg"></a>
    </div>
    <br>
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
                <div class="col-16">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Apellido</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Fecha de Nacimiento</th>
                                <th scope="col">Asistencias</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            <?php 
                                require_once("conexion.php");
                                $ordenProfesores="apellido";
                                $queryProfesores="SELECT * FROM profesores ORDER BY $ordenProfesores";
                                $STMT = $conn->prepare($queryProfesores);
                                $STMT->execute();
                                $Profesores = $STMT->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($Profesores as $element){
                                    $idp=($element["idp"]);
                                    $apellido_p=($element["apellido"]);
                                    $nombre_p=($element["nombre"]);
                                    $dni_p=($element["dni"]);
                                    $fechaNacProf=($element["fechaNacimientoProf"]); 
                                    $fechaNacimiento_p=date("d/m/Y" ,strtotime($fechaNacProf));
                            ?>
                            
                            <tr>
                                <td scope="row"><?php echo ($apellido_p); ?></td>
                                <td scope="row"><?php echo ($nombre_p); ?></td>
                                <td scope="row"><?php echo ($dni_p); ?></td>
                                <td scope="row"><?php echo ($fechaNacimiento_p); ?></td>

                                <th scope="row">
                                    <form method="POST" action="Profesores.php">
                                        <input type="hidden" name="dniAsistenciaP" value="<?php echo ($dni_p); ?>">
                                        <button type="submit" class="btn btn-success" name="botonAsist"><img src="media/calendar-check.svg"></button>
                                    </form>
                                </th>

                                <th scope="row">
                                    <div class="row">
                                        <div class="col-3">                                        
                                            <form method="POST" action="Profesores/Modificacion.php">
                                                <input type="hidden" name="dniProfesorUPD" value="<?php echo $element["dni"]; ?>">
                                                <button type="submit" class="btn btn-warning" name="botonModificarProfesor"><img src="media/pencil-square.svg"></button>
                                            </form>
                                        </div>
                                        <div class="col-4">
                                            <form method="POST" action="Profesores.php">
                                                <input type="hidden" name="dniEliminarProfesor" value="<?php echo $element["dni"]; ?>">
                                                <button type="submit" class="btn btn-danger" name="botonEliminarProfesor"><img src="media/trash3.svg"></button>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                                
                            </tr>
                            <?php 
                            } 
                            ?>
                        </tbody>
                    </table> 
                </div>
        </div>
    </div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/sweetAlert.js"></script>
</html>
<?php 

if (isset($_POST['botonAsist'])) {   
    $dniSumAsist=$_POST["dniAsistenciaP"];
    $sql = "SELECT dni FROM asistencias";
    $STMT = $conn -> prepare($sql);
    $STMT -> execute();
    $Asist = $STMT-> fetchAll();
    foreach($Asist as $element){
        $dni_prof =($element["dni"]);

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
    } else {
        echo '<script> Swal.fire({
            icon: "error",
            title: "Asistencia ya registrada",
        }).then(function() {
            window.location.href = "Profesores.php";
        });</script>';
    }
}

if (isset($_POST['botonEliminarProfesor'])) {  
    $datoDLTProfesor = $_POST["dniEliminarProfesor"];

    echo '<script>
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "Profesores/Baja.php?dniProfesorDLT=' . $datoDLTProfesor . '";
        }
    });
  </script>';
}
?>