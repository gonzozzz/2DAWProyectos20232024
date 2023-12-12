<?php
function login($conn, $nombre)
{
    $stmt = $conn->prepare("SELECT email,contra FROM usuarios
    WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    foreach ($result as $dat) {
        return $dat["contra"];
    }
}

function crearSession($email)
{
    $tiempo_expiracion = 7200;
    session_set_cookie_params($tiempo_expiracion);
    session_start();
    $_SESSION["usuario"] = $email;
}

function usuarioVetado($conn, $nombre)
{
    $stmt = $conn->prepare("SELECT vetado,info_vetado FROM usuarios WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}
