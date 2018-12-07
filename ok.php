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
pg_prepare($conexion, "sql4", 'SELECT * FROM XerathDatos');
pg_prepare($conexion, "sql3", 'SELECT * FROM XerathDatosxd');
// ejecutar consultas
$resultado = pg_execute($conexion, "sql3", array());
$resultado1 = pg_execute($conexion, "sql4", array());
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

$usuarios = array();
while ($fila1 = pg_fetch_assoc($resultado1)) {
  $fila1["usuario"] = intval($fila1["usuario"]);
  array_push($usuarios, $fila1);
}
echo json_encode($usuarios);
