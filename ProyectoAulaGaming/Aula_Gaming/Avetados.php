<html lang="es">

<head>
  <title>Administrar Vetados - Aula Gaming </title>
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
  require("config/config-Avetados.php");
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
    <h1>Administrar Vetados - AULA GAMING</h1>
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
    echo "<form id='formu' name='formu' method='post' >
  <input type='submit'  name='submit1' value='Añadir veto' >
  </form>";
    $vetados = consultaVetado($conn);
    if ($vetados == NULL) {
      echo "No hay usuarios vetados";
    } else {
      echo "Usuarios vetados: <br/><br/>";
      foreach ($vetados as $dat) {
        echo "Nombre: " . $dat["nombre"] . " --- Apellido: " . $dat["apellido"] . "<br/>" .
          "Vetado el día: " . $dat["vetado"] . " --- Motivo del vetado: " . $dat["info_vetado"] . "
          <form id='formu' name='formu' method='post'>
          <input type='hidden' name='vetado' value='" . $dat["vetado"] . "'><br>
          <input type='submit'  name='submit2' value='Quitar veto' >
        </form><br> ";
      }
    }

    if (!empty($_POST)) {
      if (isset($_POST['submit2'])) {
        $nbvetado = $dat["email"];
        eliminarVetado($conn, $nbvetado);
        echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Veto Eliminado',
                   text: '$nbvetado puede volver ha iniciar sesión'
                  }).then((xd) => {
                    if(xd){
                        window.location= 'Avetados.php';
                    }
                   });
         </script>";
        exit();
      } elseif (isset($_POST['submit1'])) {
        header("Location: agregarvetado.php");
        exit();
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