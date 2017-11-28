  <?php
 session_start();
 include('../conexao.php');

 $nome = $_POST['name'];
 $endereco = $_POST['address'];
 $latitude = $_POST['lat'];
 $longitude = $_POST['lng'];
 $tipo = $_POST['type'];



 $sql = "INSERT INTO sistema_geolocalizacao.markers (name, address, lat, lng, type) VALUES ('$nome', '$endereco', '$latitude', '$longitude', '$tipo')";

 if (! ($stmt = mysqli_prepare($conn, $sql))) {
   die('erro 1 ' . mysqli_error($conn));
   }
   mysqli_stmt_bind_param($stmt, "s", $usuario);
   if (! mysqli_stmt_execute($stmt)) {
   die('erro 2 ' . mysqli_error($conn));
   }

  $vetor = array();
   while($resultado = fetch_customizado($stmt)) {
   $vetor[] = $resultado;
   }

  header('Content-Type: applica45tion/json');
   echo json_encode($vetor);
 ?>