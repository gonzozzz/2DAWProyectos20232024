<?php
function consultaPC($conn, $nombre, $hoy)
{
    $stmt = $conn->prepare("SELECT id FROM reservar
    WHERE email = :nombre AND fecha_reserva = :hoy");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':hoy', $hoy);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function registraIncidencia($conn, $email, $fecha, $texto, $usu)
{
    try {
        $stmt = $conn->prepare("INSERT INTO incidencia(email,fecha_incidencia,incidencia,email_afectado)
        VALUES (:email,:fecha_incidencia,:incidencia,:email_afectado)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_incidencia', $fecha);
        $stmt->bindParam(':incidencia', $texto);
        $stmt->bindParam(':email_afectado', $usu);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function consultaIncidencia($conn, $hoy, $email)
{
    $stmt = $conn->prepare("SELECT incidencia FROM incidencia
    WHERE fecha_incidencia = :dia AND email = :email");
    $stmt->bindParam(':dia', $hoy);
    $stmt->bindParam(':email', $email);

    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    foreach ($result as $dato) {
        return $dato["incidencia"];
    }
}

function mostrarUsuarios($conn, $actual)
{
    try {
        $stmt = $conn->prepare("SELECT email FROM reservar WHERE fecha_reserva = :actual");
        $stmt->bindParam(':actual', $actual);
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
