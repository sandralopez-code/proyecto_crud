<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Restaurantes y Menús</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sistema CRUD - Restaurantes</h1>

        <div class="row">
            <!-- SECCIÓN RESTAURANTES -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5>Registrar Restaurante</h5>
                    </div>
                    <div class="card-body">
                        <form action="procesar.php?accion=reg_restaurante" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Guardar</button>
                        </form>
                    </div>
                </div>

                <h5 class="mt-4">Lista de Restaurantes</h5>
                <ul class="list-group">
                    <?php
                    $res = $conn->query("SELECT * FROM restaurantes");
                    while ($r = $res->fetch_assoc()):
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $r['nombre'] . " (" . $r['direccion'] . ")"; ?>
                            <a href="procesar.php?accion=del_restaurante&id=<?php echo $r['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- SECCIÓN MENÚS -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5>Registrar Plato (Menú)</h5>
                    </div>
                    <div class="card-body">
                        <form action="procesar.php?accion=reg_menu" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Plato</label>
                                <input type="text" name="nombre_plato" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Precio (S/.)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Imagen del Plato</label>
                                <input type="file" name="imagen" class="form-control" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Restaurante</label>
                                <select name="restaurante_id" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $res_rest = $conn->query("SELECT * FROM restaurantes");
                                    while ($rest = $res_rest->fetch_assoc()) {
                                        echo "<option value='{$rest['id']}'>{$rest['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Guardar Plato</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA DE VISUALIZACIÓN COMPLETA -->
        <h3 class="mt-4">Platos Registrados</h3>
        <table class="table table-striped table-bordered align-middle mt-2 shadow-sm bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th>Restaurante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT m.*, r.nombre AS n_restaurante FROM menus m JOIN restaurantes r ON m.restaurante_id = r.id";
                $res_menus = $conn->query($sql);
                while ($m = $res_menus->fetch_assoc()):
                ?>
                    <tr>
                        <td style="width: 100px;">
                            <img src="uploads/<?php echo $m['imagen']; ?>" class="img-thumbnail" style="max-height: 70px; display: block; margin: auto;">
                        </td>
                        <td><?php echo $m['nombre_plato']; ?></td>
                        <td>S/. <?php echo number_format($m['precio'], 2); ?></td>
                        <td><?php echo $m['n_restaurante']; ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $m['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="procesar.php?accion=del_menu&id=<?php echo $m['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>