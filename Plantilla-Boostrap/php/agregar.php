<?php
@session_start();
if (isset($_SESSION['datos_recientes']) && is_object(end($_SESSION['datos_recientes']))) {
    session_unset(); session_destroy(); session_start();
}
require_once 'api.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin | Agregar Producto</title>
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
        <h1 class="h3 fw-bold text-slate-800 border-orange-bottom pb-2 d-inline-block mb-4">Agregar Nuevo Producto</h1>

        <div class="card shadow-sm border-0 p-4 bg-white rounded-lg">
            <form action="procesar.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="crear">

                <h2 class="h5 fw-bold text-slate-700 mb-3 border-bottom pb-2">Información Principal</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del Producto *</label>
                        <input name="nombre_producto" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Categoría *</label>
                        <select name="id_categoria" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="16">Láminas y Polines</option>
                            <option value="18">Estructurales</option>
                            <option value="23">Pijas y Tornillería</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Precio ($)</label>
                        <input name="precio" type="number" step="0.01" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Imagen del Producto</label>
                        <input name="ImagenesProducto" type="file" class="form-control" accept="image/*">
                    </div>
                </div>

                <h2 class="h5 fw-bold text-slate-700 mb-3 border-bottom pb-2">Especificaciones Técnicas</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-3"><label class="form-label fw-bold">Unidad</label><input name="unidad_medida" type="text" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Calibre</label><input name="calibre" type="text" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Color</label><input name="color" type="text" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">CED</label><input name="ced" type="text" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Metros</label><input name="metros" type="number" step="0.01" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Cm</label><input name="cm" type="number" step="0.01" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Kg</label><input name="kg" type="number" step="0.01" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Ton</label><input name="ton" type="number" step="0.01" class="form-control"></div>
                </div>

                <div class="d-flex gap-2 pt-3 border-top">
                    <button class="btn btn-primary px-5 fw-bold" type="submit">Guardar Producto</button>
                    <a href="listado.php" class="btn btn-cancel px-4 fw-bold" >Cancelar</a>
                </div>
            </form>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div id="resumen" class="mt-5 p-4 bg-light border-start border-success border-4 rounded shadow-sm">
                    <h5 class="text-success fw-bold mb-3"><?php echo $_SESSION['mensaje']; ?></h5>
                    <div class="row g-3 small">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['nombre_producto']); ?></li>
                                <li><strong>Precio:</strong> $<?php echo htmlspecialchars($_SESSION['datos_recientes']['precio']); ?></li>
                                <li><strong>Color:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['color']); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Toneladas:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['ton']); ?></li>
                                <li><strong>Calibre:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['calibre']); ?></li>
                                <li><strong>Imagen:</strong> <?php echo htmlspecialchars($_SESSION['datos_recientes']['ImagenesProducto']); ?></li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-2">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
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
</body>
</html>