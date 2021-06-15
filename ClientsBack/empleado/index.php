<?php
//require_once '../class/autoload.php';
require_once '../class/class/insert.php';
echo "informacion: ".file_get_contents('php://input');
header("Content-Type: JSON");
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $ContenidoHeader = file_get_contents(('php://input'), true);
        $_POST = json_decode($ContenidoHeader);
        $insertarEmpleado = new InsertEmpleado($_POST['nombre'],$_POST['apellido'],$_POST['telefono']);
        $insertarEmpleado->InsertarEmpleado();
        break;
    case 'PUT':
        # code...
        break;
    case 'DELETE':
        # code...
        break;
    case 'GET':
        # code...
        break;
    default:
        # code...
        break;
}
