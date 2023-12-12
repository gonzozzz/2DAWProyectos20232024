<html lang="es">

<head>
	<title>Registro - AulaGaming</title>
	<meta charset="UTF-8">
	<a href="inicio.php">Inicio</a>
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
	require "config/config.php";
	require "config/config-register.php";
	?>
	<div class="container">
		<h1>Registro</h1>
		<form id="" name="" action="" method="post">
			<label for="email">Usuario:</label>
			<input type="text" id="email" name="email" size="40" placeholder="Correo">
			<br><br>
			<label for="nombre">Nombre:</label>
			<input type="text" id="nombre" name="nombre">
			<br><br>
			<label for="apellido">Apellido:</label>
			<input type="text" id="apellido" name="apellido">
			<br><br>
			<label for="contraseña">Contraseña:</label>
			<input type="password" id="contraseña" name="contraseña" placeholder="Entre 6 a 10 carácteres">
			<br><br>
			<a href="normativa.php" target="_blank" id="normativa-link">->Normativa<-</a>
			<input type="checkbox" id="myCheckbox" name="normativa" disabled required>
			<label id="check" for="myCheckbox"></label>
			<script>
				const normativaLink = document.getElementById('normativa-link');
				const checkbox = document.getElementById('myCheckbox');

				normativaLink.addEventListener('click', function(e) {
					checkbox.removeAttribute('disabled');
				});
			</script>
			<br><br>
			<input type="submit" value="Registrarse">
		</form>
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if ($_POST["email"] == "") {
				echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'No has rellenado el campo email'
                   });
                  
         </script>";
			} else {
				$email = $_POST["email"];
			}

			if ($_POST["nombre"] == "") {
				echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'No has rellenado el campo nombre'
                   });
                  
        		</script>";
			} else {
				$nombre = $_POST["nombre"];
			}

			if ($_POST["apellido"] == "") {
				echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'No has rellenado el campo apellido'
                   });
                  
        		</script>";
			} else {
				$apellido = $_POST["apellido"];
			}

			if ($_POST["contraseña"] == "") {
				echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'No has rellenado el campo contraseña'
                   });
                  
        		</script>";
			} else {
				$contraseña = $_POST["contraseña"];
			}
			 if (empty($_POST["normativa"])) {
			    echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'Debe aceptar la normativa para poder registrarse'
                 });
         	</script>";
			} 
			
			
			//Limpiamos los valores:

			$email = test_input($_POST["email"]);
			$nombre = test_input($_POST["nombre"]);
			$apellido = test_input($_POST["apellido"]);
			$contraseña = test_input($_POST["contraseña"]);

			//Comprobamos los valores:
			$compreg = comprobarregister($email, $nombre, $apellido, $contraseña);

			if ($compreg == true) {
				echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'Rellene correctamente los campos'
                   });
        		</script>";
				if (empty($_POST["normativa"])) {
				    echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'Debe aceptar la normativa para poder registrarse'
                 });
         	</script>";
				}
			} else {
			    if (empty($_POST["normativa"])) {
			        echo "<script>
                 Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'Debe aceptar la normativa para poder registrarse'
                 });
         	</script>";
			    }else{
				    registerl($email, $nombre, $apellido, $contraseña);
				    echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Enhorabuena',
                        text: 'Usuario $nombre registrado correctamente'
                     }).then((xd) => {
                        if(xd){
                            window.location= 'index.php';
                        }
                     });
         	          </script>";
				exit();
			            
			    }
			}
		}
		?>
	</div>
</body>

</html>