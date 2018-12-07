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

function get1xd($numeritos) {
  $variablita = json_decode($_GET[$numeritos]);
  return $variablita;
}

$asdfg = getxd("insertar");
$asddsa = get1xd("numeritos");
// preparar consultas
pg_prepare($conexion, "sql3", 'INSERT INTO XerathDatos (asesino, muertes) VALUES ($1, $2)');
pg_prepare($conexion, "sql4", 'SELECT * FROM XerathDatos');
// ejecutar consultas
pg_execute($conexion, "sql3", array("$asdfg", "$asddsa"));
$resultado = pg_execute($conexion, "sql4", array());
// indicar que el resultado es JSON
header("Content-type: application/json; charset=utf-8");
// permitir acceso de otros lugares fuera del servidor
header('Access-Control-Allow-Origin: *');
// imprimir resultado
$gente = array();
while ($fila = pg_fetch_assoc($resultado)) {
  $fila["muertes"] = intval($fila["muertes"]);
  array_push($gente, $fila);
}
echo json_encode($gente);
