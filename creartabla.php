<?
$datos = parse_url($_ENV["DATABASE_URL"]);
// conectarse
$conexion = pg_connect(
  "host=" . $datos["host"] . 
  " port=" . $datos["port"] . 
  " dbname=" . substr($datos["path"], 1) . 
  " user=" . $datos["user"] . 
  " password=" . $datos["pass"]);

function getxd($insertar) {
  $variable = json_decode($_GET[$insertar]);
  return $variable;
}

$asdfg = getxd("insertar");
// preparar consultas
pg_prepare($conexion, "sql1", 'DROP TABLE IF EXISTS datosunity');
pg_prepare($conexion, "sql2", 'CREATE TABLE datosunity (nombre VARCHAR(30), numero INT)');
pg_prepare($conexion, "sql3", 'INSERT INTO datosunity (nombre, numero) VALUES ($1, $2)');
pg_prepare($conexion, "sql4", 'SELECT * FROM datosunity');
// ejecutar consultas
pg_execute($conexion, "sql1", array());
pg_execute($conexion, "sql2", array());
pg_execute($conexion, "sql3", array("$asdfg", 23));
$resultado = pg_execute($conexion, "sql4", array());
// indicar que el resultado es JSON
header("Content-type: application/json; charset=utf-8");
// permitir acceso de otros lugares fuera del servidor
header('Access-Control-Allow-Origin: *');
// imprimir resultado
$gente = array();
while ($fila = pg_fetch_assoc($resultado)) {
  $fila["numero"] = intval($fila["numero"]);
  array_push($gente, $fila);
}
echo json_encode($gente);
