<html lang="es">

<head>
  <title>Inicio - Aula Gaming </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/particle.css">
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
  require("config/config-inicio.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $permisos = permisos($conn, $nb);
    $responsable = responsable($conn, $nb);
  } else {
    header("location: index.php");
    exit(); 
  }
  echo "<a href='index.php'>CERRAR SESIÓN</a>";
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener el ancho de pantalla del cliente
    echo '<script>var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;</script>';
    echo '<script>document.cookie = "screen_width=" + screenWidth;</script>';
  }

  if ($permisos == 2) {
    echo "<h1 style='color: red;' >INICIO AULA GAMING</h1>";
  }elseif ($permisos == 1){
    echo "<h1 style='color: orange;' >INICIO AULA GAMING</h1>";
  }else{
    echo "<h1>INICIO AULA GAMING</h1>";
  }
  ?>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  if ($responsable == 'Si') {
    echo "<B>Bienvenido/a:</B> " . $nom . " " . $ape . ", hoy eres <B>responsable.</B>";
  } else {
    echo "<B>Bienvenido/a:</B> " . $nom . " " . $ape;
  }
  ?>
  <ul>
    <?php
    if ($permisos == null) { //Usuarios normales
    ?>
      <li><a href="calendar.php">Reservar Ordenador</a></li><br>
      <li><a href="anulareserva.php">Anular Reserva</a></li><br>
      <li><a href="consultareserva.php">Consultar Mis Reservas</a></li><br>
      <li><a href="listarReservas.php">Listar reservas</a></li><br>
      
      <?php
      if ($responsable == 'Si') {
      ?>
      	<li><a href="incidencia-pc.php">Registrar Incidencia De Un Ordenador</a></li><br>
        <li><a href="incidencia.php">Registrar Incidencia Alumno</a></li><br>
      <?php
      }
      ?>
    <?php
    }
    if ($permisos == 1) { //Usuarios administradores
    ?>

      <li><a href="calendar.php">Reservar Ordenador</a></li><br>
      <li><a href="anulareserva.php">Anular Reserva</a></li><br>
      <li><a href="consultareserva.php">Consultar Mis Reservas</a></li><br>
      <li><a href="listarReservas.php">Listar reservas</a></li><br>
     
      <?php
      if ($responsable == 'Si') {
      ?>
        <li><a href="incidencia-pc.php">Registrar Incidencia De Un Ordenador</a></li><br>
        <li><a href="incidencia.php">Registrar Incidencia Alumno</a></li><br>
      <?php
      }
      ?>
      <li><a href="consultavetados.php">Consultar Vetados</a></li><br>
      <li><a href="consultarincidencias.php">Consultar Incidencias</a></li><br>
    <?php
    }
    if ($permisos == 2) {  //Usuarios administradores superiores
    ?>
      <li><a href="Avetados.php">Administrar Vetados</a></li><br>
      <li><a href="consultarincidencias.php">Consultar Incidencias</a></li><br>
      <li><a href="Ausuarios.php">Administrar Usuarios</a></li><br>
      <li><a href="Areservas.php">Administrar Reservas</a></li><br>
      <li><a href="Aordenadores.php">Administrar Ordenadores</a></li><br>
      <li><a href="Aadmin.php">Administrar Administradores</a></li><br>
    <?php
    }
    ?>
  </ul>
</body>

</html>