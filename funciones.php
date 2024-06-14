<?php
session_start();

// Definir las funciones
function agregarUsuario($productos, $nombre, $cantidad, $valor, $modelo) {
    $productos[] = [
        'nombre' => $nombre,
        'cantidad' => $cantidad,
        'valor' => $valor,
        'modelo' => $modelo
    ];
    return $productos;
}

function buscarProductoPorModelo($productos, $modelo) {
    foreach ($productos as $producto) {
        if ($producto['modelo'] == $modelo) {
            return "Nombre: " . $producto['nombre'] . "<br>";
        }
    }
    return "Modelo no encontrado.<br>";
}

function mostrarProductos($productos) {
    $result = '';
    foreach ($productos as $producto) {
        $result .= "Nombre: " . $producto['nombre'] . ", Cantidad: " . $producto['cantidad'] . ", Modelo: " . $producto['modelo'] . ", Valor: " . $producto['valor'] . "<br>";
        
   
    }
    return $result;
}

function actualizarUsuario($productos, $email, $nombre, $edad) {
    foreach ($productos as &$producto) {
        if ($producto['email'] == $email) {
            $producto['nombre'] = $nombre;
            $producto['edad'] = $edad;
            break;
        }
    }
    return $productos;
}

// Inicializar el array de usuarios en la sesión
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

$productos = $_SESSION['productos'];
$resultado = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $nombre = $_POST['nombre'] ?? '';
    $edad = $_POST['edad'] ?? '';
    $email = $_POST['email'] ?? '';

    switch ($accion) {
        case 'agregar':
            $productos = agregarProducto($productos, $nombre, $edad, $email);
            $resultado = "Usuario agregado correctamente.<br>";
            break;
        
        case 'buscar':
            $resultado = buscarProductoPorModelo($productos, $modelo);
            break;
        
        case 'mostrar':
            $resultado = mostrarProductos($productos);
            break;
        
        case 'actualizar':
            $productos = actualizarProducto($productos, $email, $nombre, $edad);
            $resultado = "Usuario actualizado correctamente.<br>";
            break;

        case 'limpiar':
            $_SESSION['productos'] = [];
            $resultado = "Resultados limpiados correctamente.<br>";
            session_destroy();
            break;

        default:
            $resultado = "Acción no válida.";
    }

    $_SESSION['productos'] = $productos;
    $_SESSION['resultado'] = $resultado;
}

// Redirigir de vuelta a index.php
header("Location: formulario.php");
exit();
?>