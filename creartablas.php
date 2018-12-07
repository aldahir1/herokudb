<?
$datos = parse_url($_ENV["DATABASE_URL"]);
// conectarse
$conexion = pg_connect(
  "host=" . $datos["host"] . 
  " port=" . $datos["port"] . 
  " dbname=" . substr($datos["path"], 1) . 
  " user=" . $datos["user"] . 
  " password=" . $datos["pass"]);

// preparar consultas
pg_prepare($conexion, "sql2", 'CREATE TABLE XerathDatos (asesino VARCHAR(30), muertes INT)');
pg_prepare($conexion, "sql3", 'CREATE TABLE XerathDatosxd (usuario VARCHAR(20), contrasena VARCHAR(20))');
// ejecutar consultas
pg_execute($conexion, "sql2", array());
pg_execute($conexion, "sql3", array());
// indicar que el resultado es JSON
header("Content-type: application/json; charset=utf-8");
// permitir acceso de otros lugares fuera del servidor
header('Access-Control-Allow-Origin: *');
