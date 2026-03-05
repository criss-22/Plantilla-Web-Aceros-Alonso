<?php
session_start();
require_once 'api.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no proporcionado.");
}

$producto = consumirAPI(API_URL . '/' . $id, 'GET');
if (empty($producto)) {
    die("El producto no existe.");
}

// Lógica de imagen actual
$imgData = $producto['ImagenesProducto'] ?? '';
$rutaImagenActual = "https://dummyimage.com/100x100/e2e8f0/475569&text=Sin+Imagen"; 
if (!empty($imgData) && $imgData !== 'WWW') {
    $rutaImagenActual = (strpos($imgData, 'http') === 0) ? $imgData : "https://grupoctic.com/genesis/imagenes/" . $imgData;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin | Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-slate-100">

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

    <main class="container-xl py-5 flex-grow-1">
        <h1 class="h3 fw-bold text-slate-800 border-orange-bottom pb-2 d-inline-block mb-4">Editar Detalles del Producto #<?php echo htmlspecialchars($id); ?></h1>

        <div class="card shadow-sm border-0 p-4 bg-white rounded-lg">
            <form action="procesar.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($imgData); ?>">

                <h2 class="h5 fw-bold text-slate-700 mb-3 border-bottom pb-2">Información Principal</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del Producto *</label>
                        <input name="nombre_producto" type="text" class="form-control select-custom" required value="<?php echo htmlspecialchars($producto['nombre_producto'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Categoría *</label>
                        <select name="id_categoria" class="form-select select-custom" required>
                            <?php $cat = $producto['id_categoria'] ?? ''; ?>
                            <option value="16" <?php echo ($cat == '16') ? 'selected' : ''; ?>>Láminas y Polines</option>
                            <option value="18" <?php echo ($cat == '18') ? 'selected' : ''; ?>>Estructurales</option>
                            <option value="21" <?php echo ($cat == '21') ? 'selected' : ''; ?>>Ángulos</option>
                            <option value="23" <?php echo ($cat == '23') ? 'selected' : ''; ?>>Pijas y Tornillería</option>
                            <option value="29" <?php echo ($cat == '29') ? 'selected' : ''; ?>>Bisagras</option>
                            <option value="30" <?php echo ($cat == '30') ? 'selected' : ''; ?>>Perfiles</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Precio ($)</label>
                        <input name="precio" type="number" step="0.01" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['precio'] ?? '0'); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Actualizar Imagen</label>
                        <input name="ImagenesProducto" type="file" class="form-control select-custom">
                        <div class="mt-2"><img src="<?php echo $rutaImagenActual; ?>" style="height: 60px;" class="rounded border shadow-sm"></div>
                    </div>
                </div>

                <h2 class="h5 fw-bold text-slate-700 mb-3 border-bottom pb-2">Especificaciones Técnicas</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-3"><label class="form-label fw-bold">Unidad de Medida</label><input name="unidad_medida" type="text" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['unidad_medida'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Calibre</label><input name="calibre" type="text" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['calibre'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Color</label><input name="color" type="text" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['color'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Cédula (CED)</label><input name="ced" type="text" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['ced'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Metros</label><input name="metros" type="number" step="0.01" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['metros'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Cm</label><input name="cm" type="number" step="0.01" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['cm'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Kg</label><input name="kg" type="number" step="0.01" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['kg'] ?? ''); ?>"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Toneladas (Ton)</label><input name="ton" type="number" step="0.01" class="form-control select-custom" value="<?php echo htmlspecialchars($producto['ton'] ?? ''); ?>"></div>
                </div>

                <div class="d-flex gap-2 pt-3 border-top mt-2">
                    <button class="btn btn-primary px-5 fw-bold" type="submit">Actualizar Cambios</button>
                    <a href="listado.php" class="btn btn-cancel px-4 fw-bold">Cancelar</a>
                </div>
            </form>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div id="resumen" class="mt-5 p-4 bg-light border-start border-success border-4 rounded shadow-sm">
                    <h5 class="text-success fw-bold mb-3"><?php echo $_SESSION['mensaje']; ?></h5>
                    <div class="row g-3 small">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['nombre_producto']); ?></li>
                                <li><strong>Categoría ID:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['id_categoria']); ?></li>
                                <li><strong>Color:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['color']); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Precio:</strong> $<?php echo htmlspecialchars($_SESSION['datos_recientes']['precio']); ?></li>
                                <li><strong>Toneladas:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['ton']); ?> Ton</li>
                                <li><strong>Calibre:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['calibre']); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center gap-2">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <span class="text-muted italic small">Redirigiendo al catálogo en 4 segundos...</span>
                    </div>
                </div>
                <script>
                    document.getElementById('resumen').scrollIntoView({ behavior: 'smooth' });
                    setTimeout(() => { window.location.href = "listado.php"; }, 4000);
                </script>
                <?php unset($_SESSION['mensaje'], $_SESSION['datos_recientes']); ?>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>