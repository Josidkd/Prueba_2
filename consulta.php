<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Consulta de videojuegos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
  </head>
  <body>
    <div class="col-md-12 text-center">
      <h1>Buscador de videojuegos</h1>
    	<form action="consulta.php" method="post">
         <input type="text" name="buscadorJuegos" value="">
         <input class="boton" type="submit" name="botonBusca" value="Buscar en mongo">
    	</form>
    </div>
    <div class="col-md-12 text-center">
  	 <?php
      //Recoge el termino de busqueda
  		$datoBuscado = $_POST['buscadorJuegos'];
      //Si hay dato que buscar lo busca
      if($datoBuscado != ""){
  			echo "Dato buscado = ".$datoBuscado."<br>";
        // conecta con mongo
        $mongo = new MongoClient("mongodb://127.0.0.1:27017");
        $db = $mongo->biblioteca;
        $coleccion = $db->juegos;
        // consulta la bbdd
        $documentos = $coleccion->findOne(array('nombre' => $datoBuscado));
        echo "<br><h2>Datos de la Consulta juegos:</h2><br>";
        echo "<b>Llave primaria de Mongo:</b> {$documentos['_id']}<br>";
        echo "<b>Id del Juego:</b> {$documentos['id']}<br>";
        echo "<b>Nombre del Juego:</b> {$documentos['nombre']}<br>";
        echo "<b>Plataforma del Juego:</b> {$documentos['plataforma']}<br>";
  		}
      ?>
      </div>
  </body>
</html>
