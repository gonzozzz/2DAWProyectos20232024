<?php

function mostrarPc($conn)
{
    try {
        $stmt = $conn->prepare("SELECT id FROM pc");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            echo "<option>" . $row["id"] . "</option>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function consultarEstadoPc($conn, $idPc)
{
    $stmt = $conn->prepare("SELECT estado FROM pc WHERE id = :idPc");

    $stmt->bindParam(':idPc', $idPc);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function cambiarEstadoPc($conn, $idPc, $nuevoEstado)
{
    $stmt = $conn->prepare("UPDATE pc SET estado = :nuevoEstado WHERE id = :idPc");

    $stmt->bindParam(':idPc', $idPc);
    $stmt->bindParam(':nuevoEstado', $nuevoEstado);
    $stmt->execute();
}
