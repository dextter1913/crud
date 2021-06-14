<?php
require_once 'conexion.php';
class insert
{
    private $nombre;
    private $apellido;
    private $telefono;

    public function __construct($nombre, $apellido, $telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
    }

    public function insertar()
    {
        $nombre = $this->nombre;
        $apellido = $this->apellido;
        $telefono = $this->telefono;
        $conexion = new conexion();
        $conexion->EstablecerConexion()->query("INSERT INTO cliente(nombre, apellido, telefono) VALUES('$nombre','$apellido','$telefono')");
        print 'Creado';
        http_response_code(201);
    }
}
