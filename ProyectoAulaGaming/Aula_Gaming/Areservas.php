<html lang="es">

<head>
  <title>Administrar Reservas - Aula Gaming </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/particle.css">
  <link rel="stylesheet" type="text/css" href="css/formulario.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <script type="text/javascript" src="js/particles.min.js"></script>
  <script type="text/javascript" src="js/particles.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
  <style>
    ::selection {
      background-color: #9712FF;
    }

    ::-moz-selection {
      background-color: #9712FF;
    }
  </style>
</head>

<body onload="iniciarParticulas()">
  <div id="particles-js"></div>
  <?php
  require("config/config.php");
  require("config/config-Areservas.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $permisos = permisos($conn, $nb);
  } else {
    header("location: index.php");
  }
  if ($permisos == 2) {
    echo "<a href='inicio.php'>Inicio</a>";
  ?>
    <h1>Administrar Reservas - AULA GAMING</h1>
    <?php
    $datos = inicioUsuario($conn, $nb);
    foreach ($datos as $reco) {
      $nom = $reco["nombre"];
      $ape = $reco["apellido"];
    }
    echo "<B>Usuario:</B> " . $nom . " " . $ape;
    ?>
    <br><br>

  <?php
    $reservas = consultaReservas($conn);
    if ($reservas == NULL) {
      echo "No hay reservas activas";
    } else {
      echo "Reservas: <br/><br/>";
      foreach ($reservas as $dat) {
        echo "Dia: " . $dat["fecha_reserva"] . " --- Turno: " . $dat["turno"] . "<br/>" .
          "Usuario: " . $dat["email"] . " --- ID PC: " . $dat["id"] . "<br/>";
        if ($dat["responsable"] != NULL) {
          echo "Es Responsable" . "<br/>";
        }
        echo "<form id='formu' name='formu' method='post'><br/>
          <input type='hidden' name='email' value='" . $dat["email"] . "'>
          <input type='hidden' name='fecha_reserva' value='" . $dat["fecha_reserva"] . "'>
          <input type='submit'  name='submit' value='Eliminar Reserva' >
          </form> - <br/><br/> ";
      }
    }
    if (!empty($_POST)) {
      $email = $_POST["email"];
      $fecha_reserva = $_POST["fecha_reserva"];
      eliminarReservas($conn, $email, $fecha_reserva);
      echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Reserva Eliminada',
                 }).then((xd) => {
                    if(xd){
                        window.location= 'Areservas.php';
                    }
                   });
         </script>";
      exit();
    }
  } else {
    echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'No tienes permisos',
                   text: 'No deberías estar aquí.',  
                   }).then((xd) => {
                    if(xd){
                        window.location= 'inicio.php';
                    }
                   });   
         </script>";
    exit();
  }
  ?>

</body>

</html>