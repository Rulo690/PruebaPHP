<?php
session_start();

// Definir las funciones
function agregarProducto($productos, $nombre, $cantidad, $valor, $modelo) {
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

function actualizarProducto($productos, $nombre, $cantidad, $valor, $modelo) {
    foreach ($productos as &$producto) {
        if ($producto['nombre'] == $nombre) {
            $producto['cantidad'] = $cantidad;
            $producto['modelo'] = $modelo;
            $producto['valor'] = $valor;
            break;
        }
    }
    return $productos;
}
function calcularValorTotal($productos, $cantidad, $valor) {
    $resultado2=0;
    foreach ($productos as $producto) {
        for($i=0;$i<$productos.length;$i++){
            $resultado1 = $producto['valor'] * $producto['cantidad'];
            $resultado2 = $resultado2 + $resultado1;
        }
    }
    return $resultado;
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
    $cantiad = $_POST['cantidad'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $valor = $_POST['valor'] ?? '';

    switch ($accion) {
        case 'agregar':
            $productos = agregarProducto($productos, $nombre, $cantidad, $valor, $modelo);
            $resultado = "Producto agregado correctamente.<br>";
            break;
        
        case 'buscar':
            $resultado = buscarProductoPorModelo($productos, $modelo);
            break;
        
        case 'mostrar':
            $resultado = mostrarProductos($productos);
            break;
        
        case 'actualizar':
            $productos = actualizarProducto($productos, $nombre, $cantidad, $valor, $modelo);
            $resultado = "Producto actualizado correctamente.<br>";
            break;

            case 'valorTotal': 
                $resultado = calcularValorTotal($productos, $cantidad, $valor);
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

echo buscarProductoPorModelo($productos, $modelo);

// Redirigir de vuelta a index.php
header("Location: vista.php");
exit();
?>