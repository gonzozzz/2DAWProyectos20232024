<?php

function mostrarUsuarios($conn)
{
    try {
        $stmt = $conn->prepare("SELECT email FROM usuarios");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $row) {
            echo "<option>" . $row["email"] . "</option>" . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function mostrarOrdenadores($conn)
{
    try {
        $stmt = $conn->prepare("SELECT id FROM pc");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $row) {
            echo "<option>" . $row["id"] . "</option>" . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function verIncidenciaUsuario($conn, $usu)
{

    $stmt = $conn->prepare("SELECT incidencia,fecha_incidencia FROM incidencia WHERE email=:usu ORDER BY fecha_incidencia ASC");

    $stmt->bindParam(':usu', $usu);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function verIncidenciaPc($conn, $pc)
{

    $stmt = $conn->prepare("SELECT id_incidencia_pc,id,fecha_incidencia,incidencia,email FROM incidencia_pc WHERE id=:pc ORDER BY fecha_incidencia ASC");

    $stmt->bindParam(':pc', $pc);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}
