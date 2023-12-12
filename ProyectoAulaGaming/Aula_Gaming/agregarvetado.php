<html lang="es">

<head>
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
  <title>Agregar Vetado - Aula Gaming </title>
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
  require("config/config-agregarvetados.php");
  $conn = conexion();
  session_start();
  if (isset($_SESSION['usuario'])) {
    $nb = $_SESSION['usuario'];
    $permisos = permisos($conn, $nb);
  } else {
    header("location: index.php");
    exit();
  }
  if ($permisos == 2) {
    echo "<a href='inicio.php'>Inicio</a>";
  ?>
    <h1>Agregar Vetado - AULA GAMING</h1>
    <?php
    $datos = inicioUsuario($conn, $nb);
    foreach ($datos as $reco) {
      $nom = $reco["nombre"];
      $ape = $reco["apellido"];
    }
    echo "<B>Usuario:</B> " . $nom . " " . $ape;
    ?>
    <br><br>

    <p>Selecciona el nombre del vetado</p>
    <form id="formu" name="formu" method="post">
      Usuario: <select id="nomb" name="nomb" require>
        <?php
        mostrarUsuarios($conn);
        ?>
      </select>
      <br><br>
      Selecciona el día de inicio del veto: <input type="date" name="fecha" require>
      <br><br>
      Escribe brevemente el motivo de su vetado: <input type="text" name="info" placeholder="40 carácteres máximo" size=50 require>
      <br><br>
      <input type="submit" name="submit" value="Vetar Usuario">
    </form>
  <?php
    if (!empty($_POST)) {
      $nbvetado = $_POST["nomb"];
      $fecha = $_POST["fecha"];
      $info = test_input($_POST["info"]);
      agregarVetado($conn, $nbvetado, $fecha, $info);
      eliminarReservas($conn, $nbvetado);
      echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Usuario Vetado',
      text: '$nbvetado ha sido vetado correctamente'
    }).then((xd) => {
      if(xd){
          window.location= 'Avetados.php';
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