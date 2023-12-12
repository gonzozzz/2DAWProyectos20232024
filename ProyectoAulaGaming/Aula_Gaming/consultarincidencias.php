<html lang="es">

<head>
  <title>Consultar Incidencias - Aula Gaming </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/particle.css">
  <link rel="stylesheet" type="text/css" href="css/formulario.css">
  <script type="text/javascript" src="js/particles.min.js"></script>
  <script type="text/javascript" src="js/particles.js"></script>
  <title>Consultar Incidencias - Aula Gaming </title>
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
  require("config/config-consultarincidencias.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $permisos = permisos($conn, $nb);
  } else {
    header("location: index.php");
  }
  if ($permisos == 2 || $permisos == 1) {
  echo "<a href='inicio.php'>Inicio</a>";
  ?>
  <h1>Consultar Incidencias - AULA GAMING</h1>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  echo "<B>Usuario:</B> " . $nom . " " . $ape;
  ?>
  <br><br>

  <p>Selecciona el usuario u ordenador para ver sus incidencias</p>
  <form id="formu" name="formu" method="post">
    Usuario: <select id="usu" name="usu" required>
      <?php
      mostrarUsuarios($conn);
      ?>
    </select>&nbsp;&nbsp;
    <input type="submit" name="submit1" value="Ver Incidencias Usuarios">
    <br><br>
    PC: <select id="pc" name="pc" required>
      <?php
      mostrarOrdenadores($conn);
      ?>
    </select>&nbsp;&nbsp;
    <input type="submit" name="submit2" value="Ver Incidencias Ordenadores">
  </form>
  <?php
  if (!empty($_POST)) {
    if (isset($_POST['submit1'])) {
      $usu = $_POST["usu"];
      $datosUsuario = verIncidenciaUsuario($conn, $usu);
      if ($datosUsuario == null) {
        echo "El usuario no ha realizado ninguna incidencia";
      } else {
          echo "<table border = '1'>
          <tr>
          <th>Día</th>
          <th>Incidencia</th>
          </tr>";
        foreach ($datosUsuario as $dat) {
          /* echo "Dia: " . $dat["fecha_incidencia"] . "<br/>";
          echo "Incidencia: " . $dat["incidencia"] . "<br/>"; */
          echo "<tr>
                      <th>".$dat["fecha_incidencia"]."</th>
                      <th>".$dat["incidencia"]."</th>
                </tr>";
          /* echo "-<br/>"; */
        }
      }
    } elseif (isset($_POST['submit2'])) {
      $pc = $_POST["pc"];
      $datosPc = verIncidenciaPc($conn, $pc);
      if ($datosPc == null) {
        echo "El pc no tiene ninguna incidencia";
      } else {
          echo "<table border = '1'>
          <tr>
          <th>Día</th>
          <th>Ordenador</th>
          <th>Incidencia</th>
          <th>Escrita por</th>
          </tr>";
        foreach ($datosPc as $dat) {
          /* echo "Dia: " . $dat["fecha_reserva"] . " --- Ordenador: " . $pc . "<br/>";
          echo "Incidencia: " . $dat["incidencia"] . "<br/>";
          echo "Escrita por: " . $dat["email"] . "<br/>"; */
            echo "<tr>
                      <th>".$dat["fecha_incidencia"]."</th>
                      <th>".$pc."</th>
                      <th>".$dat["incidencia"]."</th>
                      <th>".$dat["email"]."</th>
                </tr>";
          /* echo "-<br/>"; */
        }
      }
    }
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