<?php
function consultaAdmin($conn)
{
    $stmt = $conn->prepare("SELECT nombre,apellido,permisos,email FROM usuarios
    WHERE permisos IS NOT NULL");

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function eliminarPermisos($conn, $nombre)
{
    $stmt = $conn->prepare("UPDATE usuarios SET permisos = NULL WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
}
