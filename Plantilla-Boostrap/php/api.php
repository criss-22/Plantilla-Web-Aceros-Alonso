<?php
define('API_URL', 'https://grupoctic.com/genesis/api/productos');

function consumirAPI($url, $metodo = 'GET', $datos = null, $conArchivoFisico = false) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    if ($datos !== null) {
        if ($conArchivoFisico) {
            // Envío como Form-Data para archivos
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
        } else {
            // Envío como JSON para datos simples
            $jsonData = json_encode($datos);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
    }
    
    $respuesta = curl_exec($ch);
    curl_close($ch);
    return json_decode($respuesta, true);
}
?>

