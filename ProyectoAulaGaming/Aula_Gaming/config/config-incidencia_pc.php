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

function registraIncidencia($conn, $pc, $hoy, $text, $nb,$si)
{
    try {
        $stmt = $conn->prepare("INSERT INTO incidencia_pc(id,fecha_incidencia,incidencia,email)
        VALUES (:id,:fecha_incidencia,:incidencia,:email)");
        $stmt->bindParam(':id', $pc);
        $stmt->bindParam(':fecha_incidencia', $hoy);
        $stmt->bindParam(':incidencia', $text);
        $stmt->bindParam(':email', $nb);
        
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE reservar SET incidencia = :reser WHERE   id = :id AND
                                                                                fecha_reserva = :fecha");
        $stmt->bindParam(':reser', $si);
        $stmt->bindParam(':id', $pc);
        $stmt->bindParam(':fecha', $hoy);
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
}

function consultaIncidencia($conn, $hoy, $nb)
{
    $stmt = $conn->prepare("SELECT incidencia FROM reservar
    WHERE fecha_reserva = :dia AND email = :email");

    $stmt->bindParam(':dia', $hoy);
    $stmt->bindParam(':email', $nb);

    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    foreach ($result as $dato) {
        return $dato["incidencia"];
    }
}

function ordenadoresReservadosHoy($conn)
{
    $stmt = $conn->prepare("SELECT id FROM pc ORDER BY id ASC");

    $stmt->execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    
    return $result;
}