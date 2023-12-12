<html lang="es">

<head>
  <title>Listado Reservas - Aula Gaming </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/particle.css">
  <link rel="stylesheet" type="text/css" href="css/formulario.css">
  <script type="text/javascript" src="js/particles.min.js"></script>
  <script type="text/javascript" src="js/particles.js"></script>
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
  require("config/config-listareserva.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
  } else {
    header("location: index.php");
  }
  ?>
  <a href="inicio.php">Inicio</a>
  <h1>LISTADO - AULA GAMING</h1>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  echo "<B>Usuario:</B> " . $nom . " " . $ape
  ?>
  <br><br>


  <form id="formu" name="formu" method="post">
    Fecha Desde: <input type="date" class="gaming-date" name="inicio"><br><br>
    Fecha Hasta: <input type="date" class="gaming-date" name="fin"><br><br>
    <input type="submit" name="submit" value="Consultar">
  </form>

  <?php
  if (!empty($_POST)) {
    $hoy = date("Y-m-d");
    $realizar = true;
    $inicio = $_POST["inicio"];
    $fin = $_POST["fin"];
    if ($inicio == "") {
       echo "<p id='err'>ERROR: La fecha de inicio es obligatoria</p>";
       $realizar = false;
    }
    if ($fin == "") {
       echo "<p id='err'>ERROR: La fecha de fin es obligatoria</p>";
       $realizar = false;
    }
    if ($inicio != "" && $fin != "" && $_POST["fin"] < $_POST["inicio"]) {
      echo "<p id='err'>ERROR: La fecha de fin es mayor a la de inicio</p>";
      $realizar = false;
    }
    if ($realizar) {
      $cont = 0;
      if ($fin < $hoy) {
        $cont++;
        echo "<b>RESERVAS ANTIGUAS</b><br><br>";
      }
      $nb = $_SESSION['usuario'];
      $datos = listarReserva($conn, $nb, $inicio, $fin);
      if ($datos == null) {
        echo "Todavia no has realizado reserva";
        echo "<table border = '1'>
          <tr>
          <th>Usuario</th>
          <th>Día</th>
          <th>Ordenador</th>
          <th>Turno</th>
          <th>Responsable</th>
          </tr>";
        foreach ($datos as $dat) {
            echo "<tr>
                        <th>".$dat["email"]."</th>
                        <th>".$dat["fecha_reserva"]."</th>
                        <th>".$dat["id"]."</th>
                        <th>".$dat["turno"]."</th>";
            if ($dat["responsable"] != NULL && $dat["fecha_reserva"] < $hoy) {
                echo "<th>Fuiste El Responsable</th>";
            } 
            "</tr>";
          /* if ($dat["fecha_reserva"] < $hoy) {
            echo "Usuario:".$dat["email"]." --- Dia: " . $dat["fecha_reserva"] . " --- Ordenador: " . $dat["id"] . " --- Turno: " . $dat["turno"] . "<br>";
            if ($dat["responsable"] != NULL) {
              echo "Fuiste El Responsable" . "<br/>";
            }
          } */
        }
      } else {
          echo "<table border = '1'>
          <tr>
          <th>Usuario</th>
          <th>Día</th>
          <th>Ordenador</th>
          <th>Turno</th>
          <th>Responsable</th>
          </tr>";
        foreach ($datos as $dat) {
               echo "<tr>    
                        <th>".$dat["email"]."</th>
                        <th>".$dat["fecha_reserva"]."</th>
                        <th>".$dat["id"]."</th>
                        <th>".$dat["turno"]."</th>";
               if ($dat["responsable"] != NULL && $dat["fecha_reserva"] < $hoy) {
                        echo "<th>Fuiste El Responsable</th>";
               } else {
                   if($dat["responsable"] != NULL){
                        echo "<th>Eres El Responsable</th>";
                   } else {
                        echo "<th>Alumno</th>";
                   }
               }
                    "</tr>";
            
            
          /* echo "Usuario:".$dat["email"]." --- Dia: " . $dat["fecha_reserva"] . " --- Ordenador: " . $dat["id"] . " --- Turno: " . $dat["turno"] . "<br>";*/
          /* if ($dat["responsable"] != NULL && $dat["fecha_reserva"] < $hoy) {
            echo "Fuiste El Responsable" . "<br/>";
          } else {
            echo "Eres El Responsable" . "<br/>";
          } */ 
        }
        echo "</table>";
      }
    }
  }
  ?>

</body>

</html>
