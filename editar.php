<?php
include 'conexion.php';
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM menus WHERE id = $id");
$m = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Plato</title>
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5>Editar Plato</h5>
            </div>
            <div class="card-body">
                <form action="editar.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Plato</label>
                        <input type="text" name="nombre_plato" class="form-control" value="<?php echo $m['nombre_plato']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $m['precio']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cambiar Imagen (Opcional)</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" name="actualizar" class="btn btn-success w-100">Actualizar</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['actualizar'])) {
        $nombre_plato = $_POST['nombre_plato'];
        $precio = $_POST['precio'];

        if (!empty($_FILES['imagen']['name'])) {
            $nom_imagen = time() . "_" . $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $nom_imagen);
            $conn->query("UPDATE menus SET nombre_plato='$nombre_plato', precio='$precio', imagen='$nom_imagen' WHERE id=$id");
        } else {
            $conn->query("UPDATE menus SET nombre_plato='$nombre_plato', precio='$precio' WHERE id=$id");
        }
        echo "<script>window.location='index.php';</script>";
    }
    ?>
</body>

</html>