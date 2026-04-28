<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Formulario de Producto" />
    <title>Croram Admin · Producto</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
    :root {
        --pf-primary: #2563eb;
        --pf-primary-soft: rgba(37,99,235,.07);
        --pf-success: #059669;
        --pf-danger: #dc2626;
        --pf-text: #1e293b;
        --pf-text-secondary: #64748b;
        --pf-text-muted: #94a3b8;
        --pf-surface: #ffffff;
        --pf-surface-alt: #f8fafc;
        --pf-border: #e2e8f0;
        --pf-radius: 14px;
        --pf-radius-sm: 10px;
        --pf-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --pf-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--pf-font); }

    .pf-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--pf-text-secondary);
    }
    .pf-breadcrumb a { color: var(--pf-primary); text-decoration: none; }
    .pf-breadcrumb .sep { opacity: .4; }

    .pf-card {
        background: var(--pf-surface);
        border: 1px solid var(--pf-border);
        border-radius: var(--pf-radius);
        box-shadow: var(--pf-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .pf-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--pf-border);
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--pf-text);
        background: var(--pf-surface-alt);
    }
    .pf-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--pf-primary); }
    .pf-card-body { padding: 1.5rem; }

    /* Form fields */
    .pf-field { margin-bottom: 1.15rem; }
    .pf-field label {
        display: flex; align-items: center; gap: .3rem;
        font-size: .78rem; font-weight: 600; color: var(--pf-text-secondary);
        text-transform: uppercase; letter-spacing: .03em;
        margin-bottom: .4rem;
    }
    .pf-field label .material-icons-outlined { font-size: .9rem; }
    .pf-field input,
    .pf-field select,
    .pf-field textarea {
        width: 100%;
        border-radius: var(--pf-radius-sm);
        border: 1px solid var(--pf-border);
        font-family: var(--pf-font);
        font-size: .875rem;
        padding: .6rem .9rem;
        transition: border-color .2s, box-shadow .2s;
    }
    .pf-field input:focus,
    .pf-field select:focus,
    .pf-field textarea:focus {
        border-color: var(--pf-primary); outline: none;
        box-shadow: 0 0 0 3px var(--pf-primary-soft);
    }
    .pf-field textarea { resize: vertical; min-height: 80px; }
    .pf-field .pf-hint {
        font-size: .73rem; color: var(--pf-text-muted); margin-top: .3rem;
    }

    /* File input */
    .pf-file-zone {
        border: 2px dashed var(--pf-border);
        border-radius: var(--pf-radius-sm);
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
    }
    .pf-file-zone:hover { border-color: var(--pf-primary); background: var(--pf-primary-soft); }
    .pf-file-zone input[type="file"] {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .pf-file-zone .material-icons-outlined { font-size: 2rem; color: var(--pf-text-muted); display: block; margin-bottom: .35rem; }
    .pf-file-zone p { margin: 0; font-size: .82rem; color: var(--pf-text-secondary); }
    .pf-file-zone .pf-filename {
        margin-top: .4rem; font-size: .78rem; font-weight: 600; color: var(--pf-primary);
        display: none;
    }

    /* Image preview */
    .pf-img-preview {
        width: 100%; max-height: 200px; object-fit: contain;
        border-radius: var(--pf-radius-sm); border: 1px solid var(--pf-border);
        margin-top: .75rem;
    }

    /* Buttons */
    .pf-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.35rem; border-radius: var(--pf-radius-sm);
        font-size: .85rem; font-weight: 600; font-family: var(--pf-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none;
    }
    .pf-btn .material-icons-outlined { font-size: 1.1rem; }
    .pf-btn-primary { background: var(--pf-primary); color: #fff; }
    .pf-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .pf-btn-outline {
        background: transparent; color: var(--pf-text-secondary);
        border: 1px solid var(--pf-border);
    }
    .pf-btn-outline:hover { border-color: var(--pf-primary); color: var(--pf-primary); }

    /* Grid layout */
    .pf-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 1.5rem;
    }
    .pf-form-grid .pf-full { grid-column: 1 / -1; }
    @media (max-width: 768px) {
        .pf-form-grid { grid-template-columns: 1fr; }
    }

    /* Select2 overrides */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: var(--pf-radius-sm) !important;
        min-height: 42px !important;
        border-color: var(--pf-border) !important;
        font-family: var(--pf-font) !important;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminProductos.php";
    $adminProductos = new AdministradorProductos();
    $productosApi = $adminProductos->dameProductosApi();
    if (!is_array($productosApi)) $productosApi = [];

    $editar = 0;
    $producto = null;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $producto = $adminProductos->obtenerProducto($_GET['id']);
        if (is_object($producto) && !empty($producto->id)) {
            $editar = 1;
        }
    }

    // Safe values for form
    $valName  = ($editar && isset($producto->name))        ? htmlspecialchars($producto->name, ENT_QUOTES, 'UTF-8')        : '';
    $valCode  = ($editar && isset($producto->code))        ? htmlspecialchars($producto->code, ENT_QUOTES, 'UTF-8')        : '';
    $valDesc  = ($editar && isset($producto->description)) ? htmlspecialchars($producto->description, ENT_QUOTES, 'UTF-8') : '';
    $valUom   = ($editar && isset($producto->uom))         ? htmlspecialchars($producto->uom, ENT_QUOTES, 'UTF-8')         : '';
    $valWeight = ($editar && isset($producto->weight))     ? htmlspecialchars($producto->weight, ENT_QUOTES, 'UTF-8')      : '';
    $valNapers = ($editar && isset($producto->id_napers))  ? intval($producto->id_napers) : 0;
    $valImage  = '';
    if ($editar && !empty($producto->image)) {
        $valImage = str_replace("/home3/grupo465/public_html/admin", "https://admin.grupocroram.com/", $producto->image);
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <!-- Breadcrumb -->
                <div class="pf-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <a href="productos.php">Productos</a>
                    <span class="sep">/</span>
                    <span style="color:var(--pf-text);font-weight:600;">
                        <?php echo $editar ? 'Editar producto' : 'Nuevo producto'; ?>
                    </span>
                </div>

                <div style="max-width:860px;">
                    <!-- Form Card -->
                    <div class="pf-card">
                        <div class="pf-card-header">
                            <span class="material-icons-outlined"><?php echo $editar ? 'edit' : 'add_circle'; ?></span>
                            <?php echo $editar ? 'Editar producto' : 'Nuevo producto'; ?>
                        </div>
                        <div class="pf-card-body">
                            <form id="formProducto" enctype="multipart/form-data">
                                <div class="pf-form-grid">

                                    <!-- Nombre -->
                                    <div class="pf-field">
                                        <label>
                                            <span class="material-icons-outlined">label</span>
                                            Nombre del producto
                                        </label>
                                        <input type="text" name="nombre" id="nombre"
                                               placeholder="Ej: Alimento para ganado 40kg"
                                               value="<?php echo $valName; ?>" required />
                                    </div>

                                    <!-- Código -->
                                    <div class="pf-field">
                                        <label>
                                            <span class="material-icons-outlined">qr_code</span>
                                            Código
                                        </label>
                                        <input type="text" name="codigo" id="codigo"
                                               placeholder="Ej: ALG-040"
                                               value="<?php echo $valCode; ?>" />
                                    </div>

                                    <!-- Producto Napers -->
                                    <div class="pf-field">
                                        <label>
                                            <span class="material-icons-outlined">link</span>
                                            Producto Napers asociado
                                        </label>
                                        <select name="napers" id="napers">
                                            <option value="">Seleccionar producto...</option>
                                            <?php foreach ($productosApi as $pa):
                                                if (!is_object($pa)) continue;
                                                $paId   = intval($pa->id ?? 0);
                                                $paName = htmlspecialchars($pa->name ?? '', ENT_QUOTES, 'UTF-8');
                                                $sel    = ($paId == $valNapers) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $paId; ?>" <?php echo $sel; ?>>
                                                <?php echo $paName; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- UOM -->
                                    <div class="pf-field">
                                        <label>
                                            <span class="material-icons-outlined">straighten</span>
                                            Unidad de medida
                                        </label>
                                        <input type="text" name="uom" id="uom"
                                               placeholder="Ej: kg, pza, lt"
                                               value="<?php echo $valUom; ?>" />
                                    </div>

                                    <!-- Peso -->
                                    <div class="pf-field">
                                        <label>
                                            <span class="material-icons-outlined">fitness_center</span>
                                            Peso (kg)
                                        </label>
                                        <input type="number" name="peso" id="peso" step="0.01" min="0"
                                               placeholder="Ej: 40"
                                               value="<?php echo $valWeight; ?>" />
                                    </div>

                                    <!-- Descripción (full width) -->
                                    <div class="pf-field pf-full">
                                        <label>
                                            <span class="material-icons-outlined">description</span>
                                            Descripción
                                        </label>
                                        <textarea name="descripcion" id="descripcion"
                                                  placeholder="Descripción breve del producto..."><?php echo $valDesc; ?></textarea>
                                    </div>

                                    <!-- Imagen (full width) -->
                                    <div class="pf-field pf-full">
                                        <label>
                                            <span class="material-icons-outlined">image</span>
                                            Imagen del producto
                                        </label>
                                        <div class="pf-file-zone" id="fileZone">
                                            <input type="file" name="imagen" id="imagen" accept="image/*" />
                                            <span class="material-icons-outlined">cloud_upload</span>
                                            <p>Arrastra una imagen o haz clic para seleccionar</p>
                                            <span class="pf-filename" id="fileName"></span>
                                        </div>
                                        <?php if (!empty($valImage)): ?>
                                        <img src="<?php echo htmlspecialchars($valImage, ENT_QUOTES, 'UTF-8'); ?>"
                                             alt="Imagen actual" class="pf-img-preview" id="imgPreview" />
                                        <p class="pf-hint" style="margin-top:.35rem;">Imagen actual cargada. Sube una nueva para reemplazarla.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Hidden fields (mantener compatibilidad con API) -->
                                    <input type="hidden" name="cantidad" id="cantidad" value="0" />
                                    <input type="hidden" name="precio" id="precio" value="0" />
                                </div>

                                <!-- Actions -->
                                <div style="display:flex;gap:.75rem;margin-top:1.25rem;justify-content:flex-end;">
                                    <a href="productos.php" class="pf-btn pf-btn-outline">
                                        <span class="material-icons-outlined">arrow_back</span>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="pf-btn pf-btn-primary" id="btnGuardar">
                                        <span class="material-icons-outlined">save</span>
                                        <?php echo $editar ? 'Actualizar producto' : 'Guardar producto'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <!-- Scripts -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    var ES_EDITAR = <?php echo json_encode($editar); ?>;
    var PRODUCTO_ID = <?php echo json_encode($editar ? intval($producto->id) : 0); ?>;

    /* ══ Select2 para Napers ══ */
    $(document).ready(function() {
        $('#napers').select2({
            theme: 'bootstrap-5',
            placeholder: 'Seleccionar producto...',
            allowClear: true,
            language: {
                noResults: function() { return 'No encontrado'; },
                searching: function() { return 'Buscando...'; }
            }
        });
    });

    /* ══ File zone: show filename ══ */
    document.getElementById('imagen').addEventListener('change', function() {
        var nameEl = document.getElementById('fileName');
        if (this.files && this.files[0]) {
            nameEl.textContent = this.files[0].name;
            nameEl.style.display = 'block';

            // Preview
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imgPreview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'imgPreview';
                    preview.className = 'pf-img-preview';
                    document.getElementById('fileZone').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            nameEl.style.display = 'none';
        }
    });

    /* ══ Form submit ══ */
    document.getElementById('formProducto').addEventListener('submit', async function(e) {
        e.preventDefault();

        var btn = document.getElementById('btnGuardar');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Guardando...';

        var formData = new FormData(this);

        if (ES_EDITAR) {
            formData.append('id', PRODUCTO_ID);
            formData.append('accion', 'modificacion');
        } else {
            formData.append('accion', 'alta');
        }

        try {
            var response = await fetch('api/apiProductos.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Error HTTP ' + response.status);

            var data = await response.json();

            Swal.fire({
                title: ES_EDITAR ? 'Producto actualizado' : 'Producto guardado',
                text: 'El producto se guardó correctamente.',
                icon: 'success',
                confirmButtonColor: '#059669',
                confirmButtonText: 'Ir a productos'
            }).then(function() {
                window.location.href = 'productos.php';
            });

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'No se pudo guardar el producto.',
                confirmButtonColor: '#dc2626'
            });
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-icons-outlined">save</span> ' + (ES_EDITAR ? 'Actualizar producto' : 'Guardar producto');
        }
    });

    /* Spin keyframe */
    var s = document.createElement('style');
    s.textContent = '@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}';
    document.head.appendChild(s);
    </script>

</body>
</html>