
<?php
require_once 'class/autoload.php';
//echo "informacion: ".file_get_contents('php://input');
header("Content-Type: JSON");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);
        error_reporting(0);
        if (!empty($_POST['nombre']) && !empty($_POST['apellido'])) {
            $insert = new insert($_POST['nombre'], $_POST['apellido'], $_POST['telefono']);
            $insert->insertar();
        }else {
            echo "Datos requeridos faltantes";
            http_response_code(406);
        }
        break;
    case 'PUT':
        $convertido = json_decode(file_get_contents('php://input'), true);
        var_dump($convertido);
        if (isset($_GET['id'])) {
            $N = 0;
            $A = 0;
            $T = 0;
            while (isset($convertido['nombre']) && $N == 0) {
                $update = new update($_GET['id'], $convertido['nombre']);
                $update->updateNombre();
                $N++;
            }
            while (isset($convertido['apellido']) && $A == 0) {
                $update = new update($_GET['id'], $convertido['apellido']);
                $update->updateApellido();
                $A++;
            }
            while (isset($convertido['telefono']) && $T == 0) {
                $update = new update($_GET['id'], $convertido['telefono']);
                $update->updateTelefono();
                $T++;
            }
        }
        break;
    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        $delete = new delete($_GET['id']);
        $delete->Eliminar();
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            $respuesta = new select($_GET['id']);
            $conexion = new conexion();
            $resultado = mysqli_query($conexion->EstablecerConexion(), $respuesta->query());
            while ($rows = mysqli_fetch_assoc($resultado)) {
                $userData = $rows;
            }
            if (empty($userData)) {
                echo 'no existe';
                http_response_code(404);
            } else {
                echo json_encode($userData);
            }
        } else {
            $respuesta = new select($_GET['id'] = null);
            $conexion = new conexion();
            $resultado = mysqli_query($conexion->EstablecerConexion(), $respuesta->sinid());
            $i = 0;
            while ($rows = mysqli_fetch_assoc($resultado)) {
                $userData[$i]['id'] = $rows['id'];
                $userData[$i]['nombre'] = $rows['nombre'];
                $userData[$i]['apellido'] = $rows['apellido'];
                $userData[$i]['telefono'] = $rows['telefono'];
                $i++;
            }
            if (empty($userData)) {
                echo "No Existen datos";
                http_response_code(404);
            }else {
                
                echo json_encode($userData, JSON_PRETTY_PRINT);
            }
        }
        break;
    default:
        echo "Metodo no permitido";
        http_response_code(405);
}
