<?php
function consultaReserva($conn, $nombre, $hoy)
{
    $stmt = $conn->prepare("SELECT email,id,fecha_reserva,turno FROM reservar
    WHERE email = :nombre AND fecha_reserva >= :hoy ORDER BY fecha_reserva");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':hoy', $hoy);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return $result;
}



function borrarReserva($conn, $nombre, $dia)
{
    $stmt = $conn->prepare("DELETE FROM reservar WHERE email = :nombre AND fecha_reserva = :dia");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':dia', $dia);
    $stmt->execute();
}

 function consultaTodasReservas($conn, $hoy)
{
    $stmt = $conn->prepare("SELECT email,id,fecha_reserva,turno,responsable FROM reservar
    WHERE fecha_reserva = :hoy ORDER BY fecha_reserva");
    
    $stmt->bindParam(':hoy', $hoy);
    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    
    return $result;
}

function consultarResponsable($conn,$nb, $fecha, $turno)
{
    $stmt = $conn->prepare("SELECT email,id,fecha_reserva,turno,responsable FROM reservar WHERE email = :nb AND fecha_reserva = :fecha AND turno = :turno ");
    
    $stmt->bindParam(':nb', $nb);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':turno', $turno);
    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
//     foreach ($result as $row) {
//         if ($row['responsable'] == "Si") {
//             $result = "Si";
//         } else {
//             $result = "No";
//         }
//     }
    return $result;
} 