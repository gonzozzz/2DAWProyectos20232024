<html lang="es">

<head>
  <title>Registrar Incidencia De El Día - Aula Gaming </title>
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
  require("config/config-incidencia.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $responsable = responsable($conn, $nb);
  } else {
    header("location: index.php");
  }
  if ($responsable == 'Si') {
  echo "<a href='inicio.php'>Inicio</a>";
  ?>
  <h1>Incidencia Del Día - AULA GAMING</h1>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  echo "<B>Usuario:</B> " . $nom . " " . $ape;
  ?>
  <br><br>

  <form id="formu" name="formu" method="post">
  	Usuario afectado: <select id="usu" name="usu" required>
      <?php
      $actual = date("Y-m-d");
      mostrarUsuarios($conn, $actual);
      ?></select><br/><br/>
    Explica brevemente que ha pasado<br> <textarea type="text" name="exp" maxlength="250" placeholder="Máximo 250 carácteres"></textarea><br><br>
    <input type="submit" name="submit" value="Enviar">
  </form>

  <?php
  $rea = true;
  $hoy = date("Y-n-j"); 
  $datos = consultaPC($conn, $nb, $hoy);
  if ($datos == null) {
    echo "Sin reserva para este día no puedes registrar una incidencia";
    $continua = false;
  } else {
    foreach ($datos as $dat) {
      $pc = $dat["id"];
    }
    $continua = true;
  }
  //Se comenta porque se puede registrar más de una incidencia
  /* if (consultaIncidencia($conn, $hoy, $nb) != null) {
    echo "<script>
    Swal.fire({
      icon: 'warning',
      title: 'Opps...',
      text: 'Ya has registrado una incidencia el dia de hoy',  
      }).then((xd) => {
       if(xd){
           window.location= 'inicio.php';
       }
      });
     
  </script>";
    $rea = false;
  } */
  if (!empty($_POST)) {
    if ($rea && $continua) {
      $text = test_input($_POST["exp"]);
      $usu = test_input($_POST["usu"]);
      registraIncidencia($conn, $nb, $hoy, $text, $usu);
      echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Enhorabuena',
                   text: 'Tu incidencia ha sido registrada',  
                   }).then((xd) => {
                    if(xd){
                        window.location= 'inicio.php';
                    }
                   });
         </script>";
         exit();
    } else {
      echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'Para poder registar una incidencia debes tener una reserva',  
                   }).then((xd) => {
                    if(xd){
                        window.location= 'incidencia.php';
                    }
                   });
         </script>";
    }
  }
} else {
  echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'No puedes',
                   text: 'Necesitas una reserva hoy para poder crear una incidencia.',  
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