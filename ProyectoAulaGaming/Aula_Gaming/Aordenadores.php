<html lang="es">

<head>
  <title>Administrar Ordenadores - Aula Gaming </title>
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
  require("config/config-Aordenadores.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $permisos = permisos($conn, $nb);
  } else {
    header("location: index.php");
    exit();
  }
  if ($permisos == 2){
  echo "<a href='inicio.php'>Inicio</a>";
  ?>
  <h1>Administrar Ordenadores - AULA GAMING</h1>
  <?php
  $datos = inicioUsuario($conn, $nb);
  foreach ($datos as $reco) {
    $nom = $reco["nombre"];
    $ape = $reco["apellido"];
  }
  ?>
  <br><br>
  <form id="formu" name="formu" method="post">
    Pc: <select id="id" name="id" required>
      <?php
      mostrarPc($conn);
      ?>
    </select><br /><br />
    <input type="submit" name="submit1" value="Consultar Estado">
    <br /><br />
    Nuevo Estado: <input type="text" name="estado" value="" size=50 placeholder="Si el ordenador está bien escribe (Correcto)">
    <br /><br />
    <input type="submit" name="submit2" value="Cambiar Estado">
  </form>
  <?php
  if (isset($_POST['submit1'])) {
    $idPc = $_POST["id"];
    $EstadoPc = consultarEstadoPc($conn, $idPc);
    foreach ($EstadoPc as $dat) {
      echo "El estado del Pc: " . $idPc . " es: " . $dat["estado"] . "<br/>";
      if ($dat["estado"] == "Correcto") {
        echo "Por lo qué el ordenador se puede reservar";
      } else {
        echo "Por lo qué el ordenador No se puede reservar hasta que esté (Correcto)";
      }
    }
  } elseif (isset($_POST['submit2'])) {
    $idPc = $_POST["id"];
    $nuevoEstado = $_POST["estado"];
    cambiarEstadoPc($conn, $idPc, $nuevoEstado);
    echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Estado Cambiado',
                   text: 'El estado del Pc: $idPc ha cambiado!'
                  });
         </script>";
    echo "El estado del Pc: " . $idPc . " ha cambiado ha: " . $nuevoEstado . "<br/>";
    if ($nuevoEstado == "Correcto") {
      echo "Por lo qué el ordenador se puede reservar";
    } else {
      echo "Por lo qué el ordenador No se puede reservar hasta que esté (Correcto)";
    }
  }
}else{
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