<html lang="es">

<head>
  <title>Administrar Administradores - Aula Gaming </title>
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
  require("config/config-Aadmin.php");
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
    <h1>Administrar Administradores - AULA GAMING</h1>
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
  <input type='submit'  name='submit1' value='Añadir Administrador' >
  </form>";
    $admins = consultaAdmin($conn);
    if ($admins == NULL) {
      echo "No hay usuarios administradores";
    } else {
      echo "Administradores: <br/><br/>";
      foreach ($admins as $dat) {
        echo "Nombre: " . $dat["nombre"] . " --- Apellido: " . $dat["apellido"] . "<br/>" .
          "Nivel de permisos: " . $dat["permisos"];
        if ($dat["permisos"] == 1) {
          echo "<form id='formu' name='formu' method='post'><br/>
          <input type='hidden' name='email' value='" . $dat["email"] . "'>
          <input type='submit'  name='submit2' value='Quitar permisos administrador' >
          </form> - <br/><br/> ";
        } else {
          echo "<br/> - <br/>";
        }
      }
    }
    if (!empty($_POST)) {
      if (isset($_POST['submit2'])) {
        $nbadmin = $_POST["email"];
        eliminarPermisos($conn, $nbadmin);
        echo "<script>
                 Swal.fire({
                   icon: 'success',
                   title: 'Permisos Eliminado',
                   text: '$nbadmin vuelve a ser un usuario normal'
                  }).then((xd) => {
                    if(xd){
                        window.location= 'Aadmin.php';
                    }
                   });
         </script>";
        exit();
      } elseif (isset($_POST['submit1'])) {
        header("Location: agregaradmin.php");
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