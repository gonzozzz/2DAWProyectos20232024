<?php

function mostrarUsuarios($conn)
{
    try {

        $stmt = $conn->prepare("SELECT email FROM usuarios where permisos IS NULL OR permisos = 1");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $row) {
            echo "<option>" . $row["email"] . "</option>" . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function hayUsuarios($conn)
{
    try {

        $stmt = $conn->prepare("SELECT email FROM usuarios where permisos IS NULL OR permisos = 1");
        $stmt->execute();
        $ret = null;
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $row) {
            $ret = "not null";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    return $ret;
}

function agregarPermisos($conn, $nombre, $nivel)
{
    $stmt = $conn->prepare("UPDATE usuarios SET permisos = :nivel WHERE email = :nombre");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':nivel', $nivel);
    $stmt->execute();
}
