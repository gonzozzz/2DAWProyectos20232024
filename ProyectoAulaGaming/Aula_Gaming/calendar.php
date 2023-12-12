<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require("config/config.php");
	require("config/config-calendar.php");
	$conn = conexion();
	session_start();
	if (isset($_SESSION['usuario'])) {
		$nb = $_SESSION['usuario'];
	} else {
		header("location: index.php");
		exit();
	}
	?>
	<title>Calendario</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="css/calendar.css">
	<link rel="stylesheet" type="text/css" href="css/particle.css">
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
	$datos = inicioUsuario($conn, $nb);
	foreach ($datos as $reco) {
		$nom = $reco["nombre"];
		$ape = $reco["apellido"];
	}
	echo "<a href='inicio.php'>Inicio</a><br><br>";
	echo "<B>Usuario:</B> " . $nom . " " . $ape;

	mostrarSweetAlert();
	?>


	<?php
	function mesESP($mes)
	{
		$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
		return $nombreMes;
	}
	?>

	<?php
	// Establecer la zona horaria
	date_default_timezone_set("Europe/Madrid");
	// Obtener el año actual
	$year = date("Y");
	echo "<h1>$year</h1>";
	// Recorrer los meses del año
	for ($month = 1; $month <= 12; $month++) {
		// Imprimir el título del mes
		$monthName = date("F", mktime(0, 0, 0, $month, 1, $year));

		echo "<h2>" . mesESP($monthName) . "</h2>";
		// Imprimir la tabla del mes
		echo "<form id='formu' name='formu' method='post' >";
		echo "<table>";
		// Imprimir la fila de los días de la semana
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			// Obtener el ancho de pantalla del cliente
			echo '<script>var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;</script>';
			echo '<script>document.cookie = "screen_width=" + screenWidth;</script>';
		  }
			// Obtener el ancho de pantalla almacenado en las cookies
				$screenWidth = $_COOKIE['screen_width'];

			// Verificar si el ancho de pantalla es mayor de 500 px
			if ($screenWidth < 1050) {
				echo "<tr>";
				echo "<th>L</th>";
				echo "<th>M</th>";
				echo "<th>X</th>";
				echo "<th>J</th>";
				echo "<th>V</th>";
				echo "<th>S</th>";
				echo "<th>D</th>";
				echo "</tr>";
			} else {
				echo "<tr>";
				echo "<th>Lunes</th>";
				echo "<th>Martes</th>";
				echo "<th>Miércoles</th>";
				echo "<th>Jueves</th>";
				echo "<th>Viernes</th>";
				echo "<th>Sábado</th>";
				echo "<th>Domingo</th>";
				echo "</tr>";
			}
		
		$a = 0;
		// Obtener el primer día del mes
		$firstDay = date("N", mktime(0, 0, 0, $month, 1, $year));
		// Obtener el número de días del mes
		$numDays = date("t", mktime(0, 0, 0, $month, 1, $year));
		// Imprimir las filas con los días del mes
		$currentDay = 1;
		for ($row = 1; $row <= 6; $row++) {
			echo "<tr>";
			for ($col = 1; $col <= 7; $col++) {
				if ($row == 1 && $col < $firstDay) {
					echo "<td></td>";
				} else if ($currentDay > $numDays) {
				} else {
					//FESTIVOS
					if (
						$col > 5 || ($monthName == "September" && $currentDay < 8) || ($monthName == "October" && ($currentDay == 12 || $currentDay == 31)) ||
						($monthName == "November" && $currentDay == 1) || ($monthName == "December" && (($currentDay > 4 && $currentDay < 9) || ($currentDay > 23)))
						|| ($monthName == "January" && $currentDay < 8) || ($monthName == "February" && $currentDay > 24) || ($monthName == "March" && ($currentDay == 20 || $currentDay == 31))
						|| ($monthName == "April" && $currentDay < 11) || ($monthName == "May" && $currentDay < 3) || ($monthName == "June" && $currentDay > 13) || ($monthName == "July") || ($monthName == "August")
					) {
						echo "<td style=color:red >" . $currentDay . "</td>";
						$currentDay++;
					} else {

						echo "<td><input id='letras' type='submit'  name='submit' value='$currentDay'></td>";
						$currentDay++;
					}
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "<input type='hidden'  name='fecha' value='$year'>";
		echo "<input type='hidden'  name='month' value='$month'>";
		echo "</form>";
		if (!empty($_POST)) {

			// Asignar valores a las variables
			$dia = $_POST["submit"];
			echo $dia;
			$mes = $_POST["month"];
			$anio = $_POST["fecha"];

			// Crear la cookie
			setcookie("reserva", "$anio-$mes-$dia", time() + 3600); // Expira en 1 hora

			//Redirige a la página de seleccionar un pc.
			header("Location: reserva.php");
			exit();
		}
	}
	?>
</body>

</html>