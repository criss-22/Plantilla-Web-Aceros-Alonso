<?php
session_start();
require_once 'api.php';

$accion = $_POST['accion'] ?? '';
$id_producto = $_POST['id_producto'] ?? '';

//Recolectar todos los campos del formulario
$datosAEnviar = [
    'nombre_producto' => $_POST['nombre_producto'] ?? '',
    'id_categoria'    => $_POST['id_categoria'] ?? '',
    'precio'          => $_POST['precio'] ?? '0',
    'unidad_medida'   => $_POST['unidad_medida'] ?? '',
    'calibre'         => $_POST['calibre'] ?? '',
    'color'           => $_POST['color'] ?? '',
    'ced'             => $_POST['ced'] ?? '',
    'metros'          => $_POST['metros'] ?? '0',
    'kg'              => $_POST['kg'] ?? '0',
    'cm'              => $_POST['cm'] ?? '0',
    'ton'             => $_POST['ton'] ?? '0'
];

// Manejo de Imagen Local
$conArchivoFisico = false;
$nombreImagenVisible = "Sin imagen seleccionada";

if (isset($_FILES['ImagenesProducto']) && $_FILES['ImagenesProducto']['error'] === UPLOAD_ERR_OK) {
    $datosAEnviar['ImagenesProducto'] = new CURLFile(
        $_FILES['ImagenesProducto']['tmp_name'], 
        $_FILES['ImagenesProducto']['type'], 
        $_FILES['ImagenesProducto']['name']
    );
    $conArchivoFisico = true;
    $nombreImagenVisible = $_FILES['ImagenesProducto']['name'];
} else {
    $datosAEnviar['ImagenesProducto'] = $_POST['imagen_actual'] ?? '';
    $nombreImagenVisible = $datosAEnviar['ImagenesProducto'];
}

$datosParaSesion = $datosAEnviar;
if ($conArchivoFisico) {
    $datosParaSesion['ImagenesProducto'] = $nombreImagenVisible;
}


switch ($accion) {
    case 'crear':
        consumirAPI(API_URL, 'POST', $datosAEnviar, $conArchivoFisico);
        $_SESSION['mensaje'] = "Producto guardado con éxito";
        $_SESSION['datos_recientes'] = $datosParaSesion;
        header("Location: agregar.php");
        break;

    case 'editar':
        consumirAPI(API_URL . '/' . $id_producto, 'PUT', $datosAEnviar, $conArchivoFisico);
        $_SESSION['mensaje'] = "Cambios actualizados correctamente";
        $_SESSION['datos_recientes'] = $datosParaSesion;
        header("Location: edit.php?id=" . $id_producto);
        break;

    case 'eliminar':
        // Llamada a la API para borrar
        consumirAPI(API_URL . '/' . $id_producto, 'DELETE');
        
        // Guardamos el aviso de éxito
        $_SESSION['alerta_exito'] = "El producto ha sido eliminado permanentemente del catálogo.";
        
        header("Location: listado.php");
        exit();
        break;
}
exit();