<?php
require 'conexion.php';
$db = new Database();
$con = $db->conectar();

require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;


$nombre = "";
$apellido = "";
$id = "";
$email = "";
$mensaje = "";

if (isset($_POST["registro"]) && $_POST["registro"] == "formu") {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $email = $_POST["email"];

    
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM personas WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        $mensaje = "Error: El ID ya está registrado.";
        $nombre = "";
        $apellido = "";
        $id = "";
        $email = "";

    } else {
        
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";

        
        $codigo_barras_texto = $nombre . $id . $apellido; 
        $generator = new BarcodeGeneratorPNG();
        $codigo_barras_imagen = $generator->getBarcode($codigo_barras_texto, $generator::TYPE_CODE_128);

        
        $ruta_imagen = 'images/' . $codigo_barras_texto . '.png';
        file_put_contents(__DIR__ . '/images/' . $codigo_barras_texto . '.png', $codigo_barras_imagen);


        $insertsql = $con->prepare("INSERT INTO personas (id, nombre, apellido, email, barcode) VALUES (?, ?, ?, ?, ?)");
        $insertsql->execute([$id, $nombre, $apellido, $email, $codigo_barras_texto]);
        $mensaje = "Código de barras generado correctamente para el usuario.";

        
        $nombre = "";
        $apellido = "";
        $id = "";
        $email = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personas</title>
    <link rel="stylesheet" href="styles1.css">
</head>

<body>
    <main>
        <div class="container mt-5">
            <h2>REGISTRAR PERSONA</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">CEDULA</label>
                    <input type="number" class="form-control" id="id" name="id" value="<?php echo $id; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">APELLIDO</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">CORREO</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
            
                <input type="submit" class="btn btn-success" value="Registrar">
                <input type="hidden" name="registro" value="formu">
            </form>
            <div class="mensaje">
                <?php if (!empty($mensaje)) : ?>
                    <div class="mensaje"><?php echo $mensaje; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <div class="container mt-5">
        <h2>Datos de personas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Código de Barras</th>
            </tr>
            <?php
            
            $result = $con->query("SELECT * FROM personas");
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                
                $ruta_imagen = 'images/' . $row['barcode'] . '.png';
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellido'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";

                echo "<td><img src='" . $ruta_imagen . "' alt='Código de Barras'></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>


</body>

</html>