<?php
function conexion()
{
  $servername = "localhost";
  $username = "leonardodavinci";
  $password = "Gamingdavid";
  $dbname = "gaming";

  /* $servername = "localhost";
  $username = "id21558546_david";
  $password = "Servidordavid1993.";
  $dbname = "id21558546_gaming"; */
  
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $conn;
}

//Limpiar variables.

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function inicioUsuario($conn, $nombre)
{
  $stmt = $conn->prepare("SELECT nombre,apellido FROM usuarios
    WHERE email = :nombre ");

  $stmt->bindParam(':nombre', $nombre);
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $result = $stmt->fetchAll();

  return $result;
}

function permisos($conn, $nombre)
{
    $stmt = $conn->prepare("SELECT permisos FROM usuarios
    WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    foreach ($result as $dat) {
        return $dat["permisos"];
    }
}

function responsable($conn, $nombre)
{
    $hoy = date('Y-m-d');

    $stmt = $conn->prepare("SELECT responsable FROM reservar
    WHERE email = :nombre AND fecha_reserva = :hoy");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':hoy', $hoy);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    foreach ($result as $dat) {
        return $dat["responsable"];
    }
}