<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Alumnos</title>
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
        <h2 class="text-center" style="color: black">Listado de Alumnos</h2>
    </div>          
    <br>
    <!--Fin del titulo de la tabla -->
    <div class="container-clock">
        <h2 class="text-center" id="time">00:00:00</h2>
        <p class="text-center" id="date">date</p>
    </div>
    <br>
    <div class="container-fluid">
        <a class="btn btn-success" href="Alumnos/Alta.php">Alta <img src="media/person-plus-fill.svg"></a>
    </div>
    <br>

    <script >       
     window.onload = function() {
            const time = document.getElementById('time');
            const date = document.getElementById('date');

            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            const interval = setInterval(() => {

                const local = new Date();

                let day = local.getDate(),
                    month = local.getMonth(),
                    year = local.getFullYear();

                time.innerHTML = local.toLocaleTimeString();
                date.innerHTML = `${day} ${monthNames[month]} ${year}`;

            }, 1000);
        }
    </script>

    
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
                                <th scope="col">Condición</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            <?php 
                                require_once("conexion.php");
                                require_once("Porcentaje.php");
                                $orden="apellido";
                                $queryAlumnos="SELECT * FROM alumnos ORDER BY $orden";
                                $STMT = $conn -> prepare($queryAlumnos);
                                $STMT -> execute();
                                $Alumnos = $STMT-> fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($Alumnos as $element){
                                    $id_alumno=($element["ida"]);
                                    $apellido_alumno=($element["apellido"]);
                                    $nombre_alumno=($element["nombre"]);
                                    $dni_alumno=($element["dni"]);
                                    $fechaNacAlum=($element["fechaNacimiento"]);
                                    $fechaNacimiento_alumno=date("d/m/Y" ,strtotime($fechaNacAlum)); 
                            ?>
                            
                            <tr>
                                <td scope="row"><?php echo ($apellido_alumno); ?></td>
                                <td scope="row"><?php echo ($nombre_alumno); ?></td>
                                <td scope="row"><?php echo ($dni_alumno); ?></td>
                                <td scope="row"><?php echo ($fechaNacimiento_alumno); ?></td>
                                <th scope="row">
                                    <form method="POST" action="Alumnos.php">
                                        <input type="hidden" name="dniAsistenciaA" value="<?php echo $element["dni"]; ?>">
                                        <button type="submit" class="btn btn-success" name="botonAsist"><img src="media/calendar-check.svg"></button>
                                    </form>
                                </th>

                                <th scope="row"><?php
                                if (in_array($dni_alumno, $alum_prom)) {
                                    $key = array_search($dni_alumno, $alum_prom);
                                    echo "Promociona";
                                }
                                else if (in_array($dni_alumno, $alum_regulares)) {
                                    $key = array_search($dni_alumno, $alum_regulares);
                                    echo "Regulariza";
                                }else{
                                    echo"Libre";
                                }
                                ?></th>
                                
                                <th scope="row">
                                    <div class="row">
                                        <div class="col-4">
                                            <form method="POST" action="Alumnos/Modificacion.php">
                                                <input type="hidden" name="dniAlumnoUPD" value="<?php echo ($dni_alumno); ?>">
                                                <button type="submit" class="btn btn-warning" name="botonModificarAlumno"><img src="media/pencil-square.svg"></button>
                                            </form>    
                                        </div>
                                        <div class="col-4">
                                            <form method="POST" action="Alumnos.php">
                                                <input type="hidden" name="dniEliminarAlumno" value="<?php echo $element["dni"]; ?>">
                                                <button type="submit" class="btn btn-danger" name="botonEliminarAlumno"><img src="media/trash3.svg"></button>
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
</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/sweetAlert.js"></script>
</html>
<?php
if (isset($_POST['botonAsist'])) {   
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
    } else {
        echo '<script> Swal.fire({
            icon: "error",
            title: "Asistencia ya registrada",
        }).then(function() {
            window.location.href = "Alumnos.php";
        });</script>';
    }
}

if (isset($_POST['botonEliminarAlumno'])) {  
    $datoDLTAlumno = $_POST["dniEliminarAlumno"];

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
            window.location.href = "Alumnos/Baja.php?dniAlumnoDLT=' . $datoDLTAlumno . '";
        }
    });
  </script>';
}
?> 