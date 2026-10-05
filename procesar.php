<?php
include 'conexion.php';
$accion = $_GET['accion'] ?? '';

if ($accion == 'reg_restaurante') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $conn->query("INSERT INTO restaurantes (nombre, direccion) VALUES ('$nombre', '$direccion')");
}

if ($accion == 'reg_menu') {
    $nombre_plato = $_POST['nombre_plato'];
    $precio = $_POST['precio'];
    $restaurante_id = $_POST['restaurante_id'];

    // Procesar Imagen
    $nom_imagen = time() . "_" . $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $nom_imagen);

    $conn->query("INSERT INTO menus (nombre_plato, precio, imagen, restaurante_id) VALUES ('$nombre_plato', '$precio', '$nom_imagen', '$restaurante_id')");
}

if ($accion == 'del_restaurante') {
    $id = $_GET['id'];
    $conn->query("DELETE FROM restaurantes WHERE id = $id");
}

if ($accion == 'del_menu') {
    $id = $_GET['id'];
    // Borrar archivo del servidor
    $res = $conn->query("SELECT imagen FROM menus WHERE id = $id");
    $m = $res->fetch_assoc();
    if (file_exists("uploads/" . $m['imagen'])) unlink("uploads/" . $m['imagen']);

    $conn->query("DELETE FROM menus WHERE id = $id");
}

header("Location: index.php");
