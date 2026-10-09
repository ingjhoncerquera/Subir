<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h3>Editar Producto</h3>

<form action="index.php?controller=producto&action=editar" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

    <div class="mb-3">
        <label>Nombre *</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    </div>
	
	<textarea name="descripcion" class="form-control"><?= $producto['descripcion'] ?? '' ?></textarea>

    <div class="mb-3">
        <label>Categoría *</label>
        <select name="id_categoria" class="form-control select2" required>
            <?php foreach($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $producto['id_categoria'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Precio *</label>
        <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Stock *</label>
        <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
    </div>

    <div class="mb-3">
    <label>Imagen del producto</label>
    <input type="file" name="imagen" class="form-control">
    <?php if(!empty($producto['imagen'])): ?>
        <img src="uploads/<?= $producto['imagen'] ?>" width="100" class="mt-2">
    <?php endif; ?>
</div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="index.php?controller=producto&action=index" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>