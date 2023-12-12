<html lang="es">

<head>
    <title>Inicio - Aula Gaming</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/particle.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
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
    $conn = conexion();
    setcookie("PHPSESSID", "", time() - 3600, "/");
    ?>
    <h1>AULA GAMING LEONARDO</h1>
    <h3 id="mensaje"></h3>
    <a href="register.php">Registrarse</a>
    <br /><br />
    <a href="login.php">Iniciar Sesion</a>
    <br />
        <img class="imgcentral" src=".\img\central.png">
    <footer>
        <p id="mensaje2"></p>
    </footer>

    <script>
        let ima = "https://picsum.photos/200/100";
        if (localStorage.getItem('visited')) {
            document.getElementById('mensaje').innerText = '¡Bienvenido de nuevo!';
            document.getElementById('mensaje2').innerText = 'IES Leonardo Da Vinci';
        } else {
            Swal.fire({
                title: 'Bienvenido',
                text: 'Bienvenido por primera vez a la página web Aula Gaming del Leonardo Da Vinci',
                iconHtml: '<img src="./img/favicon.png" style="width:150px">',
                confirmButtonText: 'Gracias'
            });
            document.getElementById('mensaje').innerText = '¡Bienvenido a nuestra página web!';
            document.getElementById('mensaje2').innerText = 'Página web creada por los alumnos Adrián Alonso y Guillermo Moreno (V2.3.6)';
            localStorage.setItem('visited', true);
        }
    </script>

</body>

</html>