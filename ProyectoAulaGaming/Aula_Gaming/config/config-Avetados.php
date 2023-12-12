<?php
function consultaVetado($conn)
{
    $stmt = $conn->prepare("SELECT nombre,apellido,info_vetado,vetado,email FROM usuarios
    WHERE vetado IS NOT NULL ");

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function eliminarVetado($conn, $nombre)
{
    $stmt = $conn->prepare("UPDATE usuarios SET vetado = NULL, info_vetado = NULL WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
}
