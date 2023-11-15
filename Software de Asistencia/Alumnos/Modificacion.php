
<!DOCTYPE html>
<html>
    <head>
        <title>Modificación de Alumno</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../styles.css">
        <script src="../js/sweetAlert.js"></script>
</head>
<body>
    
<?php
    require_once("../conexion.php");
    if (isset($_POST['botonModificarAlumno'])) {  
        $dniUPDAlumno = $_POST["dniAlumnoUPD"];

        $sqlUPDAlumno = "SELECT * FROM alumnos WHERE dni=:dni";
        $statement = $conn->prepare($sqlUPDAlumno);
        $statement->bindParam(':dni', $dniUPDAlumno);
        $statement->execute();
        $UPDAlum = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($UPDAlum as $element) {
        }
    }
?>

<!--Inicio de la barra superior -->
<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
                    <a class="nav-link" href="../Alumnos.php">Alumnos</a>
                    <a class="nav-link" href="../Profesores.php">Profesores</a>
                </div>
            </div>
        </div>
    </nav>
    <a class="nav-link justify-content-end" href="../Configuracion.html">Configuración <img src="../media/gear.svg"></a>
</nav>
<!--Fin de la barra superior -->

<div class="container">
    <h1>Editar Alumno</h1>
    <form method="POST" action="Modificacion.php">

      <input type="Hidden" name="dniAntiguo" value="<?php echo $element["dni"]; ?>">   

      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" name="dniNuevo" value="<?php echo $element["dni"]; ?>" required>
      </div>

      <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input type="text" class="form-control" name="nombre" value="<?php echo $element["nombre"]; ?>" required>
      </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" value="<?php echo $element["apellido"]; ?>" required>
        </div>

        <div class="form-group">
            <label for="fechaNacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fechaNacimiento" value="<?php echo $element["fechaNacimiento"]; ?>" required>
        </div>

        <button type="submit" name="botonActualizarA" class="btn btn-primary">Actualizar Alumno</button>
        <a href='../Alumnos.php' class='btn btn-danger'>Volver</a>
    </form>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php

if (($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['botonActualizarA'])) {
    $dni = $_POST["dniNuevo"];
    $dniViejo=$_POST["dniAntiguo"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    
    $queryVerificarDuplicado = "SELECT COUNT(*) as count FROM alumnos WHERE dni = :dni";
    $statementVerificarDuplicado = $conn->prepare($queryVerificarDuplicado);
    $statementVerificarDuplicado->bindParam(":dni", $dni);
    $statementVerificarDuplicado->execute();
    $result = $statementVerificarDuplicado->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
      echo '<script> Swal.fire({
              icon: "error",
              title: "Ya existe un alumno con el mismo DNI",
            }).then(function() {
              window.location.href = "../Alumnos.php";
            });</script>';
      exit;
    }

    $fechas = explode("-", $fechaNacimiento);
    $MenoresEdad = date("Y") - 17;
    if ($MenoresEdad < $fechas [0]){
        echo '<script> Swal.fire({
            icon: "error",
            title: "El alumno no presenta la edad suficiente para cursar",
          }).then(function() {
            window.location.href = "Modificacion.php";
          });</script>';
      exit;
    }

                

    $sqlUpdateAlumno = "UPDATE alumnos SET dni=:dniNuevo, nombre=:nombre, apellido=:apellido, fechaNacimiento=:fechaNacimiento WHERE dni=:dniAntiguo";
    $statement = $conn->prepare($sqlUpdateAlumno);

    $statement->bindParam(':nombre', $nombre);
    $statement->bindParam(':apellido', $apellido);
    $statement->bindParam(':fechaNacimiento', $fechaNacimiento);
    $statement->bindParam(':dniAntiguo', $dniViejo);
    $statement->bindParam(':dniNuevo', $dni); 


    if ($statement->execute()) {
        echo 
        '<script>
            Swal.fire({
                icon: "success",
                title: "Alumno modificado con exito",
                showConfirmButton: false,
            }).then(function() {
                window.location.href = "../Alumnos.php";
              });</script>';
    } else {
        echo "Error al actualizar: " . $statement->errorInfo()[2];
    }
}
?>
