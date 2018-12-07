<?
$datos = parse_url($_ENV["DATABASE_URL"]);
// conectarse
$conexion = pg_connect(
  "host=" . $datos["host"] . 
  " port=" . $datos["port"] . 
  " dbname=" . substr($datos["path"], 1) . 
  " user=" . $datos["user"] . 
  " password=" . $datos["pass"]);
function getxd($usuario) {
  $variable = json_decode($_GET[$usuario]);
  return $variable;
}
function get1xd($contrasena) {
  $variablita = json_decode($_GET[$contrasena]);
  return $variablita;
}
$asdfg = getxd("usuario");
$asddsa = get1xd("contrasena");
// preparar consultas
pg_prepare($conexion, "sql3", 'INSERT INTO WOTDatos1 (usuario, contrasena) VALUES ($1, $2)');
pg_prepare($conexion, "sql4", 'SELECT * FROM WOTDatos1');
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
  array_push($gente, $fila);
}
echo json_encode($gente);
