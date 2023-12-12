<?php

function reservar($conn, $email, $id, $f_reserva, $turno)
{
    $responsable = esResponsable($conn, $f_reserva, $turno);

    try {

        $stmt = $conn->prepare("INSERT INTO reservar(email,id,fecha_reserva,turno,incidencia,responsable)
        VALUES (:email,:id,:fecha_reserva,:turno,NULL,:responsable)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fecha_reserva', $f_reserva);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':responsable', $responsable);


        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function esResponsable($conn, $fecha, $turno)
{
    $stmt = $conn->prepare("SELECT COUNT(id) as total FROM reservar WHERE fecha_reserva = :fecha AND turno = :turno ");

    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':turno', $turno);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        if ($row['total'] == 1 || $row['total'] == null) {
            $result = "Si";
        } else {
            $result = NULL;
        }
    }
    return $result;
}

function yaReservados($conn, $nombre, $fecha)
{
    $stmt = $conn->prepare("SELECT fecha_reserva FROM reservar
    WHERE email = :nombre AND fecha_reserva >= :fecha ");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    
    return $result;
    
//     $cont = NULL;
//     foreach ($result as $row) {
//         $cont = $row["COUNT(id)"];
//     }
//     return $cont;
}

function yaReservadoDia($conn, $nombre, $fec)
{
    $stmt = $conn->prepare("SELECT fecha_reserva FROM reservar
    WHERE email = :nombre and fecha_reserva = :fec ");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':fec', $fec);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cont = false;
    foreach ($stmt->fetchAll() as $row) {
        $cont = true;
    }
    return $cont;
}

function ordenadorPillado($conn, $fec, $id, $turno)
{
    $stmt = $conn->prepare("SELECT id FROM reservar
    WHERE fecha_reserva = :fec and id = :id and turno = :turno ");

    $stmt->bindParam(':fec', $fec);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':turno', $turno);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $cont = false;
    foreach ($stmt->fetchAll() as $row) {
        $cont = true;
    }
    return $cont;
}

function ordenadoresHoy($conn, $fecha, $turno)
{
    $stmt = $conn->prepare("SELECT id,email FROM reservar WHERE fecha_reserva = :fecha AND turno = :turno ORDER BY id ASC");

    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':turno', $turno);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function ordenadorMal($conn)
{
    $stmt = $conn->prepare("SELECT id FROM pc WHERE estado != 'Correcto' ORDER BY id ASC");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function contarOrdenadores($conn)
{
    $stmt = $conn->prepare("SELECT COUNT(id) AS total FROM pc");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}
