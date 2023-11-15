<!DOCTYPE html>
<html>
<head>
    <title>Alta de Alumno</title>
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
  <h2 class="text-center" style="color: black">Formulario de Alta de Alumno</h2>  
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
        <input type="date" class="form-control" name="fechaNacimiento" required>
      </div>
      
      <br>
      
      <button type="submit" class="btn btn-primary"><img src="../media/check-lg.svg"> Agregar Alumno</button>
      <td><a href='../Alumnos.php' class='btn btn-danger'>Volver</a></td>
    </form>
  </div>
</body>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/sweetAlert.js"></script>
</html>
      <?php
        require_once("../conexion.php");
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $nombre=$_POST["nombre"];
            $apellido=$_POST["apellido"];
            $dni=$_POST["dni"];
            $fechaNacimiento=$_POST["fechaNacimiento"];
            
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
                      window.location.href = "Alta.php";
                    });</script>';
              exit;
            }

            //No me deberia aceptar que un alumno sea menor de 18 (01/01/2006)
            $fechas = explode("-", $fechaNacimiento);
            $MenoresEdad = date("Y") - 17;
            if ($MenoresEdad < $fechas [0]){
              echo '<script> Swal.fire({
                icon: "error",
                title: "El alumno no presenta la edad suficiente para cursar",
              }).then(function() {
                window.location.href = "Alta.php";
              });</script>';
            exit;
            }
            if(($nombre&&$apellido&&$dni&&$fechaNacimiento)<>null){
              $queryInsertAlumno = "INSERT INTO alumnos(nombre,apellido,dni,fechaNacimiento)values(:nombre,:apellido,:dni,:fechaNacimiento)";
              $statement = $conn->prepare($queryInsertAlumno);
              $statement -> bindParam(":nombre",$nombre); 
              $statement -> bindParam(":apellido",$apellido); 
              $statement -> bindParam(":dni",$dni);
              $statement -> bindParam(":fechaNacimiento",$fechaNacimiento);  
              $statement -> execute();
              echo '<script>
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Alumno registrado con exito",
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