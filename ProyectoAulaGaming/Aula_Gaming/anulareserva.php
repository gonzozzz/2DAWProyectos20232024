<html lang="es">

<head>
  <title>Anular Reservas - Aula Gaming </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/particle.css">
  <link rel="stylesheet" type="text/css" href="css/formulario.css">
  <script type="text/javascript" src="js/particles.min.js"></script>
  <script type="text/javascript" src="js/particles.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery.js"></script>
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
  require("config/config-anulareserva.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
  } else {
    header("location: index.php");
    exit();
  }
  ?>
  <a href="inicio.php">Inicio</a>
  <h1>ANULAR RESERVA</h1>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  echo "<B>Usuario:</B> " . $nom . " " . $ape
  ?>
  <br><br>
  <h3>Reservas Activas</h3>
  <?php

  $hoy = date("Y-m-d");

  $nb = $_SESSION['usuario'];
  $turno = $_COOKIE["turno"];
  $datos = consultaReserva($conn, $nb, $hoy);
  $datos2 = consultaTodasReservas($conn, $hoy);
  $resultado = consultarResponsable($conn, $nb, $hoy, $turno); 
  $responsable = "No";
  foreach ($resultado as $result){
      $responsable = $result["responsable"];
  }
  if ($datos == null){
    echo "Todavia no has realizado reserva<br>Si deseas reservar visita <a href='reserva.php'>Reservar PC</a>";
  }else {
//     $conthoy=0;
//     foreach ($datos as $dat) {
//       $conthoy++;
//     }
      
      if($responsable == "Si"){
        foreach ($datos2 as $dat2){
            if ($dat2["fecha_reserva"] >= $hoy) {
                echo "Usuario: ". $dat2["email"]." --- Dia: " . $dat2["fecha_reserva"] . " --- Ordenador: " . $dat2["id"] . " --- Turno: " . $dat2["turno"] . "
              <form id='formu' name='formu' method='post'>
              <input type='hidden' name='fecha' value='" . $dat2["fecha_reserva"] . "'><br>
              <input type='hidden' name='email' value='" . $dat2["email"] . "'>  
              <input type='submit'  name='submit' value='Anular' >
            </form><br> ";
            }
        }
    }else{
        
        foreach ($datos as $dat) {
              if ($dat["fecha_reserva"] >= $hoy) {
                echo "Dia: " . $dat["fecha_reserva"] . " --- Ordenador: " . $dat["id"] . " --- Turno: " . $dat["turno"] . "
                      <form id='formu' name='formu' method='post'>
                      <input type='hidden' name='fecha' value='" . $dat["fecha_reserva"] . "'><br>
                      <input type='submit'  name='submit' value='Anular' >
                    </form><br> ";
              } /* elseif ($dat["fecha_reserva"] == $hoy && $conthoy == 1){
                echo "No puedes anular una reserva para el mismo día";
              }  */
        }
    }
  }
  if (!empty($_POST)) {
      if($responsable == "Si"){
          $nb = $_POST["email"];
      }
      else{
          $nb = $_SESSION['usuario'];
      }
    $dia = $_POST["fecha"];
    borrarReserva($conn, $nb, $dia);
    echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Enhorabuena',
                   text: 'Tu reserva del $dia fue cancelada con exito',  
                   }).then((xd) => {
                    if(xd){
                        window.location= 'anulareserva.php';
                    }
                   });
         </script>";
         exit();
  }
  ?>

</body>

</html>