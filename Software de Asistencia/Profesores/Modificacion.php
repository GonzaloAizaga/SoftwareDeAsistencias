
<!DOCTYPE html>
<html>
<head>
    <title>Modificación de Profesor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="../js/sweetAlert.js"></script>
</head>
<body>

<?php
    require_once("../conexion.php");
    if (isset($_POST['botonModificarProfesor'])) {  
        $dniUPDProfesor = $_POST["dniProfesorUPD"];

        $sqlUPDProfesor = "SELECT * FROM profesores WHERE dni=:dni";
        $statement = $conn->prepare($sqlUPDProfesor);
        $statement->bindParam(':dni', $dniUPDProfesor);
        $statement->execute();
        $UPDProf = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($UPDProf as $element) {
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
    <h1>Editar Profesor</h1>
    <form method="POST" action="Modificacion.php">

      <input type="Hidden" name="dniAntiguoP" value="<?php echo $element["dni"]; ?>">   

      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" name="dniNuevoP" value="<?php echo $element["dni"]; ?>" required>
      </div>

      <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input type="text" class="form-control" name="nombreP" value="<?php echo $element["nombre"]; ?>" required>
      </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellidoP" value="<?php echo $element["apellido"]; ?>" required>
        </div>

        <div class="form-group">
            <label for="fechaNacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fechaNacimientoProf" value="<?php echo $element["fechaNacimientoProf"]; ?>" required>
        </div>

        <button type="submit" name="botonActualizarP" class="btn btn-primary">Actualizar Profesor</button>
        <a href='../Profesores.php' class='btn btn-danger'>Volver</a>
    </form>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['botonActualizarP'])) {
    $dniP = $_POST["dniNuevoP"];
    $dniViejoP=$_POST["dniAntiguoP"];
    $nombreP = $_POST["nombreP"];
    $apellidoP = $_POST["apellidoP"];
    $fechaNacimientoP = $_POST["fechaNacimientoProf"];
    
    $queryVerificarDuplicado = "SELECT COUNT(*) as count FROM profesores WHERE dni = :dni";
    $statementVerificarDuplicado = $conn->prepare($queryVerificarDuplicado);
    $statementVerificarDuplicado->bindParam(":dni", $dniP);
    $statementVerificarDuplicado->execute();
    $result = $statementVerificarDuplicado->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo '<script> Swal.fire({
                icon: "error",
                title: "Ya existe un profesor con el mismo DNI",
              }).then(function() {
                window.location.href = "../Profesores.php";
              });</script>';
        exit;
    }

    $fechas = explode("-", $fechaNacimientoP);
    $MenoresEdad = date("Y") - 20;
    if ($MenoresEdad < $fechas [0]){
        echo '<script> Swal.fire({
            icon: "error",
            title: "El profesor no presenta la edad suficiente para ejercer",
          }).then(function() {
            window.location.href = "Modificacion.php";
          });</script>';
      exit;
    }

                

    $sqlUpdateProfesor = "UPDATE profesores SET dni=:dniNuevo, nombre=:nombre, apellido=:apellido, fechaNacimientoProf=:fechaNacimiento WHERE dni=:dniAntiguo";
    $statement = $conn->prepare($sqlUpdateProfesor);

    $statement->bindParam(':nombre', $nombreP);
    $statement->bindParam(':apellido', $apellidoP);
    $statement->bindParam(':fechaNacimiento', $fechaNacimientoP);
    $statement->bindParam(':dniAntiguo', $dniViejoP);
    $statement->bindParam(':dniNuevo', $dniP); 


    if ($statement->execute()) {
        echo 
        '<script>
            Swal.fire({
                icon: "success",
                title: "Profesor modificado con exito",
                showConfirmButton: false,
            }).then(function() {
                window.location.href = "../Profesores.php";
              });</script>';
    } else {
        echo "Error al actualizar: " . $statement->errorInfo()[2];
    }
}
?>