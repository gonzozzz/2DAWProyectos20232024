<?php
function consultaReservas($conn)
{
    $fecha = date('Y-m-d');
    $stmt = $conn->prepare("SELECT email,id,fecha_reserva,turno,responsable FROM reservar
    WHERE fecha_reserva >= :fecha ORDER BY fecha_reserva desc");

    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}

function eliminarReservas($conn, $email, $fecha_reserva)
{
    $stmt = $conn->prepare("DELETE FROM reservar WHERE email = :email AND fecha_reserva = :fecha_reserva");

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':fecha_reserva', $fecha_reserva);
    $stmt->execute();
}
