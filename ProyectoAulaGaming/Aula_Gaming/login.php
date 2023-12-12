<html lang="es">

<head>
    <title>Login - Aula Gaming</title>
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
    require("config/config-login.php");
    $conn = conexion();
    echo "<a href='inicio.php'>Inicio</a>";
    ?>
    <h1>INICIO DE SESIÓN</h1>

    <form id="formu" name="formu" method="post">
        <br />
        Email: <input type="text" name="email" size="40">
        <br /><br />
        Contraseña: <input type="password" name="password"><br /><br />

        <input type="submit" name="submit" value="Entrar">
    </form>
    <?php
    if (!empty($_POST)) {
        $realizar = true;
        if ($_POST["email"] == "" && $_POST["password"] == "") {
            echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No has introducido ni el nombre ni la contraseña'
          });   
        </script>";
            echo "Introduce el nombre y la contraseña<br/>";
            $realizar = false;
        }
        if ($_POST["email"] == "" && $realizar) {
            echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No has introducido el email de usuario'
          });
        </script>";
            echo "Introduce el email de usuario<br/>";
            $realizar = false;
        }
        if ($_POST["password"] == "" && $realizar) {
            echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No has introducido la contraseña'
          }); 
        </script>";
            echo "Introduce la contraseña<br/>";
            $realizar = false;
        }
        if ($_POST["email"] != "" && $_POST["password"] != "") {
            $nb = $_POST["email"];
            $datosVetado = usuarioVetado($conn, $nb);
            foreach ($datosVetado as $dat) {
                $fechaVetado = $dat["vetado"];
                $infoVetado = $dat["info_vetado"];
            }
            if ($datosVetado == null && $realizar == true) {
                echo "<script>
                     Swal.fire({
                       icon: 'error',
                       title: 'Error',
                       text: 'La usuario no existe'
                       });
                </script>";
                echo "Introduce un usuario válido.";
                $realizar = false;
            } else {
                if ($fechaVetado != null && $infoVetado != null) {
                    echo "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Estás vetado desde el $fechaVetado',
                    text: '$infoVetado'
                    }); 
                    </script>";
                    echo "Estás vetado desde el $fechaVetado" . "<br/>";
                    echo "Se más responsable la proxima vez ;)";
                    $realizar = false;
                }
            }
            if ($realizar) {
                if (login($conn, $nb) == $_POST["password"]) {
                    crearSession($_POST["email"]);
                    echo "<script>
                     Swal.fire({
                       icon: 'success',
                       title: 'Enhorabuena',
                       text: 'Bienvenido $nb'
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
                       text: 'La contraseña no es correta'
                       });
                </script>";
                    echo "Introduce una contraseña válida.";
                }
            }
        }
    }
    ?>

</body>

</html>