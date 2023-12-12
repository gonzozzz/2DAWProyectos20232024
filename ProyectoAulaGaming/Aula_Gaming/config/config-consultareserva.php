<?php
function consultaPC($conn, $nombre, $inicio, $fin)
{
    $stmt = $conn->prepare("SELECT email,id,fecha_reserva,turno,responsable FROM reservar
    WHERE email = :nombre AND fecha_reserva >= :inicio AND fecha_reserva <= :fin ORDER BY fecha_reserva DESC");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':inicio', $inicio);
    $stmt->bindParam(':fin', $fin);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}
