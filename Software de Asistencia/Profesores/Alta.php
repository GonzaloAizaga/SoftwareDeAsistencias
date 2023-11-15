<!DOCTYPE html>
<html>
<head>
    <title>Alta de Profesor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

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
  <br>
  <div class="container">
    <h2 class="text-center" style="color: black">Formulario de Alta de Profesor</h2>     
    <form method="POST" action="Alta.php">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>

      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" class="form-control" name="apellido" required>
      </div>

      <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" name="dni" required>
      </div>

      <div class="form-group">
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" name="fechaNacimientoProf" required>
      </div>

      <br>

      <button type="submit" class="btn btn-primary"><img src="../media/check-lg.svg"> Agregar Profesor</button>
      <td><a href='../Profesores.php' class='btn btn-danger'>Volver</a></td>
    </form>
  </div>
</body>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/sweetAlert.js"></script>
</html>
<?php
  require_once("../conexion.php");

  if($_SERVER["REQUEST_METHOD"]=="POST"){
      $nombre_p=$_POST["nombre"];
      $apellido_p=$_POST["apellido"];
      $dni_p=$_POST["dni"];
      $fechaNacimientoProf=$_POST["fechaNacimientoProf"];

      $queryVerificarDuplicado = "SELECT COUNT(*) as count FROM profesores WHERE dni = :dni";
      $statementVerificarDuplicado = $conn->prepare($queryVerificarDuplicado);
      $statementVerificarDuplicado->bindParam(":dni", $dni_p);
      $statementVerificarDuplicado->execute();
      $result = $statementVerificarDuplicado->fetch(PDO::FETCH_ASSOC);

      if ($result['count'] > 0) {
        echo '<script> Swal.fire({
                icon: "error",
                title: "Ya existe un profesor con el mismo DNI",
              }).then(function() {
                window.location.href = "Alta.php";
              });</script>';
        exit;
      }

      //No me deberia aceptar que un profesor sea menor de 20 (01/01/2003)
      $fechas = explode("-", $fechaNacimientoProf);
      $MenoresEdad = date("Y") - 20;
      if ($MenoresEdad < $fechas [0]){
        echo '<script> Swal.fire({
          icon: "error",
          title: "El profesor no presenta la edad suficiente para ejercer",
        }).then(function() {
          window.location.href = "Alta.php";
        });</script>';
      exit;
      }
      if(($nombre_p&&$apellido_p&&$dni_p&&$fechaNacimientoProf)<>null){
        $queryInsertProfesor = "INSERT INTO profesores(dni,nombre,apellido,fechaNacimientoProf)values(:dni,:nombre,:apellido,:fechaNacimientoProf)";
        $statement = $conn->prepare($queryInsertProfesor);
        $statement -> bindParam(":dni",$dni_p);
        $statement -> bindParam(":nombre",$nombre_p); 
        $statement -> bindParam(":apellido",$apellido_p); 
        $statement -> bindParam(":fechaNacimientoProf",$fechaNacimientoProf);  
        $statement -> execute();

        echo '<script>
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Profesor registrado con exito",
                showConfirmButton: false,
                timer: 1500
              });
              </script>';
      }
      else{
        echo "Un espacio no ha sido completado ";
      }
  }
?>