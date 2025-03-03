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

function filtrarPorValor($productos, $valor) {
    $result = '';
    foreach ($productos as $producto) {
        if ($producto['valor'] > $valor) {
            $result .= "Nombre: " . $producto['nombre'] . ", Valor: " . $producto['valor'] . "<br>";
        }
    }
    return $result ? $result : "Ningún producto encontrado con un valor superior a $valor.<br>";
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

function calcularValorTotal($productos) {
    $resultado = 0;
    foreach ($productos as $producto) {
        $resultado += $producto['valor'] * $producto['cantidad'];
    }
    return $resultado;
}

function listarModelos($productos) {
    $modelos = array();
    
    foreach ($productos as $producto) {
        $modelo = $producto['modelo'];
        if (!in_array($modelo, $modelos)) {
            $modelos[] = $modelo;
        }
    }
    
    return $modelos;
}

function calcularValorpromedio($productos) {
    $totalValor = 0;
    $i = 0;
    
    foreach ($productos as $producto) {
        $totalValor += $producto['valor'] * $producto['cantidad'];
        $i++;
    }
    
    if ($i > 0) {
        $promedio = $totalValor / $i;
        return $promedio;
    } else {
        return "No hay productos registrados.";
    }
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
    $cantidad = $_POST['cantidad'] ?? '';
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

            case 'filtrarPorValor': 
                $resultado = filtrarPorValor($productos, $valor);
            break;
            
            case 'valorPromedio': 
                $resultado = calcularValorpromedio($productos);
            break;

            case 'listarModelos': 
                $resultado = listarModelos($productos);
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