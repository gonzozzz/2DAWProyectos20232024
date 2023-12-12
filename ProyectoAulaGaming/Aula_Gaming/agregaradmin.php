<html lang="es">

<head>
  <title>Agregar Administrador - Aula Gaming </title>
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
  require("config/config-agregaradmin.php");
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
    <h1>Agregar Administrador - AULA GAMING</h1>
    <?php
    $datos = inicioUsuario($conn, $nb);
    foreach ($datos as $reco) {
      $nom = $reco["nombre"];
      $ape = $reco["apellido"];
    }
    echo "<B>Usuario:</B> " . $nom . " " . $ape;
    $Musuarios = hayUsuarios($conn);
    if ($Musuarios == NULL) {
      echo "<br/><br/>No hay usuarios o no hay usuarios que no sean administradores";
    } else {
    ?>
      <br><br>
      <p>Selecciona el nombre de la persona a la cuál se le van a otrogar permisos</p>
      <form id="formu" name="formu" method="post">
        Usuario: <select id="nomb" name="nomb" required>
          <?php
          mostrarUsuarios($conn);
          ?>
        </select>
        <br><br>
        Selecciona el nivel de permisos: <input type="text" name="nivel" size="80" placeholder="1 = Administrador Normal, 2 = Administrador Superior como un profesor." required>
        <br><br>
        <input type="submit" name="submit" value="Dar Permisos">
      </form>
  <?php
      if (!empty($_POST)) {
        $nbadmin = $_POST["nomb"];
        $nivel = test_input($_POST["nivel"]);
        if ($nivel != 1 && $nivel != 2) {
          echo "Solo se admiten el nivel de permisos 1 o 2";
        } else {
          agregarPermisos($conn, $nbadmin, $nivel);
          echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Permisos concedidos',
          }).then((xd) => {
            if(xd){
                window.location= 'Aadmin.php';
            }
           });   
        </script>";
          exit();
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