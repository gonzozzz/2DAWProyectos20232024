<?php
function consultaUsuarios($conn)
{
    $stmt = $conn->prepare("SELECT nombre,apellido,permisos,email FROM usuarios
    WHERE permisos != 2 OR permisos IS NULL AND contra IS NOT NULL");

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function eliminarUsuario($conn, $nombre)
{
    $stmt = $conn->prepare("UPDATE usuarios SET contra = NULL WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
}
