<?php
session_start();
$resultado = '';

// Verificar si hay un resultado almacenado en la sesión
if (isset($_SESSION['resultado'])) {
    $resultado = $_SESSION['resultado'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
</head>
<body>
    <form action="funciones.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br>
        
        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor"><br>
        
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad"><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo"><br>
        
        <input type="radio" id="agregar" name="accion" value="agregar">
        <label for="agregar">Agregar</label><br>
        
        <input type="radio" id="buscar" name="accion" value="buscar">
        <label for="buscar">Buscar</label><br>
        
        <input type="radio" id="mostrar" name="accion" value="mostrar">
        <label for="mostrar">Mostrar</label><br>
        
        <input type="radio" id="actualizar" name="accion" value="actualizar">
        <label for="actualizar">Actualizar</label><br>

        <input type="radio" id="valorTotal" name="accion" value="valorTotal">
        <label for="valorTotal">Valor total</label><br>
        
        <input type="radio" id="filtrarPorValor" name="accion" value="filtrarPorValor">
        <label for="filtrarPorValor">Filtrar por valor</label><br>

        <input type="radio" id="valorPromedio" name="accion" value="valorPromedio">
        <label for="valorPromedio">Valor promedio</label><br>

        <input type="radio" id="listarModelos" name="accion" value="listarModelos">
        <label for="listarModelos">Listar Modelos</label><br>
        

        <input type="submit" value="Aceptar">
    </form>

    <form action="funciones.php" method="POST">
        <input type="hidden" name="accion" value="limpiar">
        <input type="submit" value="Limpiar Resultados">
    </form>

    <!-- <div id="resultados">
    
       
    </div> -->

    <div id="resultados">
    <?php echo $resultado; 
   
    ?>
    
    </div>

    
</body>
</html>