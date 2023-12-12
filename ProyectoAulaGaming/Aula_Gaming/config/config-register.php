<?php

function registerl($email, $nombre, $apellido, $contra)
{

	try {
		$conn = conexion();

		$f_alta = date('Y-m-d');

		$stmt = $conn->prepare("INSERT INTO usuarios(email,nombre,apellido,contra,fecha_alta,vetado,pc_reservados)
			VALUES (:email,:nombre,:apellido,:contra,:fecha_alta,NULL,0)");

		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellido', $apellido);
		$stmt->bindParam(':contra', $contra);
		$stmt->bindParam(':fecha_alta', $f_alta);

		$stmt->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

function comprobarregister($email, $nombre, $apellido, $contra)
{

	$error = false;

	$testemail = "/^[a-záéíóúüñA-ZÁÉÍÓÚÜÑ0-9_.-ç]{2,34}@educa.madrid.org$/";

	if ($email == "") {
		echo "Tienes que añadir un usuario" . "<br>";
		$error = true;
	} else {
		if (!preg_match_all($testemail, $email)) {
			echo "El usuario es erroneo, no está bien escrito." . "<br>";
			$error = true;
		}
		$usucomp = usureg();
		for ($i = 0; $i <= count($usucomp) - 1; $i++) {
			if ($email == $usucomp[$i]) {
				echo "El usuario ya fue registrado anteriormente." . "<br>";
				$error = true;
			}
		}
	}

	if ($nombre == "") {
		echo "Tienes que añadir tu nombre." . "<br>";
		$error = true;
	}

	if ($apellido == "") {
		echo "Tienes que añadir tu apellido." . "<br>";
		$error = true;
	}

	$testcontra = "/^[a-záéíóúüñA-ZÁÉÍÓÚÜÑ0-9?!.,]{6,10}$/";

	if ($contra == "") {
		echo "Tienes que añadir una contra de entre 6 a 10 carácteres." . "<br>";
		$error = true;
	} else {
		if (!preg_match_all($testcontra, $contra)) {
			echo "La contra es errónea (carácteres disponibles: ?!.,) o no tiene entre 6 a 10 carácteres." . "<br>";
			$error = true;
		}
	}

	return $error;
}

function usureg()
{

	try {
		$conn = conexion();

		$stmt = $conn->prepare("SELECT email FROM usuarios");
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$usuariocomp = [];
		$cont = 0;
		foreach ($stmt->fetchAll() as $row) {
			$usuariocomp[$cont] = $row["email"];
			$cont++;
		}
		return $usuariocomp;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}
