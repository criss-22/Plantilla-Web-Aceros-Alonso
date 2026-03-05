<?php
// session_start SIEMPRE debe ser la línea 1, sin espacios antes.
session_start();
require_once 'api.php';
$productos = consumirAPI(API_URL, 'GET');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin | Listado de Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../ACASALogoAcerosA.png" type="image/png" sizes="16px">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-slate-100">
    
    <?php if (isset($_SESSION['mensaje_toast'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof mostrarToast === "function") {
                mostrarToast("<?php echo $_SESSION['mensaje_toast']; ?>", "exito");
            } else {
                console.log("<?php echo $_SESSION['mensaje_toast']; ?>");
            }
        });
    </script>
    <?php unset($_SESSION['mensaje_toast']); ?>
    <?php endif; ?>

    <header class="navbar navbar-dark bg-slate-900 shadow-md sticky-top px-4 py-2">
        <div class="container-fluid justify-content-between">
            <section class="d-flex align-items-center gap-3">
                <button id="btn-admin-menu" class="navbar-toggler d-md-none border-0 shadow-none text-white p-0">
                    <svg width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>
                </button>
                <img src="../../ACASALogoAcerosA.png" alt="Logo" style="width: 40px;">
                <h2 class="h5 m-0 fw-bold text-white d-none d-sm-block">Aceros Alonso</h2>
            </section>
            <nav><a href="../Login/CerrarSesion.php" class="btn btn-cerrar-sesion btn-sm fw-bold">Cerrar Sesión</a></nav>
        </div>
    </header>

    <aside id="admin-aside" class="bg-slate-900 border-top border-slate-700 d-none d-md-block">
        <div class="container-fluid py-2">
            <ul class="nav flex-column flex-md-row gap-md-3">
                <li class="nav-item"><a href="listado.php" class="nav-link-custom border border-white border-opacity-25">Productos</a></li>
            </ul>
        </div>
    </aside>

    <?php if (isset($_SESSION['alerta_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 rounded-3 d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <div>
                    <strong class="d-block">¡Operación Exitosa!</strong>
                    <span class="small"><?php echo $_SESSION['alerta_exito']; ?></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alerta_exito']); ?>
        <?php endif; ?>

    <main class="container-xl py-5 flex-grow-1">
        <h1 class="h3 fw-bold text-slate-800 border-orange-bottom pb-2 d-inline-block mb-4">Administrar Productos</h1>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
            <h2 class="h5 fw-semibold text-slate-700 m-0">Catálogo (Total: <?php echo is_array($productos) ? count($productos) : 0; ?>)</h2>
            <a href="agregar.php" class="btn btn-orange-custom fw-bold px-4 shadow-sm mt-3 mt-sm-0">+ Agregar Nuevo Producto</a>
        </div>

        <div class="card rounded-lg shadow-md overflow-hidden border border-slate-200 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-100 border-bottom border-slate-200">
                        <tr class="text-slate-700 fw-bold">
                            <th class="px-4 py-3">Imagen</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos) && is_array($productos)): ?>
                            <?php foreach ($productos as $prod): ?>
                            <tr class="border-bottom border-slate-100">
                                <td class="px-4 py-3">
                                    <?php 
                                        $imgData = $prod['ImagenesProducto'] ?? '';
                                        $rutaImagen = "https://dummyimage.com/100x100/e2e8f0/475569&text=Sin+Imagen"; 

                                        if (!empty($imgData) && $imgData !== 'WWW') {
                                            if (strpos($imgData, 'http') === 0) {
                                                $rutaImagen = $imgData;
                                            } else {
                                                $rutaImagen = "https://grupoctic.com/genesis/imagenes/" . $imgData;
                                            }
                                        }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($rutaImagen); ?>" 
                                        class="product-img rounded border border-slate-200 shadow-sm" 
                                        alt="Producto"
                                        style="width: 50px; height: 50px; object-fit: cover; background-color: #f8fafc;">
                                </td>
                                <td class="px-4 py-3 fw-semibold text-slate-800">
                                    <?php echo htmlspecialchars($prod['nombre_producto'] ?? 'Sin nombre'); ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="edit.php?id=<?php echo $prod['id_producto'] ?? ''; ?>" class="btn btn-edit btn-sm fw-bold px-3 me-1">Editar</a>

                                    <form action="procesar.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_producto" value="<?php echo $prod['id_producto'] ?? ''; ?>">
                                        <button class="btn btn-delete btn-sm fw-bold px-3" type="submit" name="accion"
                                            value="eliminar" onclick="confirmarEliminacion(event)">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 fw-bold text-slate-500">
                                    No se encontraron productos o no hay conexión con la API.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white border-0 py-3 rounded-top-4">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="modalConfirmacionLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    Confirmar Acción
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center py-5">
                <div class="mb-3 text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-trash3-fill opacity-25" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>
                </div>
                <h4 class="fw-bold text-dark mb-2">¿Estás seguro?</h4>
                <p class="text-muted mb-0 px-4">
                    Esta acción eliminará el producto de forma permanente. No podrás deshacer este cambio.
                </p>
            </div>

            <div class="modal-footer bg-light border-0 d-flex justify-content-center pb-4 rounded-bottom-4">
                <button type="button" class="btn btn-light border fw-bold px-4 py-2 me-2 shadow-sm" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger fw-bold px-4 py-2 shadow-sm" id="btn-confirmar-accion">
                    Sí, Eliminar Producto
                </button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>