<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Carga datos</title>
  </head>
  <body>
    <?php
        //Mostrar errores php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        //titulo
        echo "<h1>Crawleo lista de juegos - Crea mongoDB</h1>";
        //Crawleo
        $alfabeto = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
        $numero = 0;
        $i = 0;
        $juegos = array();
        $plataforma = array();
        function buscaJuegos($letra){
          global $numero,$juegos,$plataforma;
          $urlBusqueda = "http://thegamesdb.net/api/GetGamesList.php?name=".$letra;
          $resultado = Parse($urlBusqueda);
          //Descodificamos para tratar el JSON con PHP
          $array = json_decode($resultado);
          //Recorremos los resultados
          foreach($array as $obj){
            $GameTitle = $obj->GameTitle;
            $Platform = $obj->Platform;
            $juegos[$numero] = $GameTitle;
            $plataforma[$numero] = $Platform;
            $numero++;
          }
        }
        //Creamos una funcion que nos parsea los datos de XML a JSON
        function Parse ($url) {
          $fileContents= file_get_contents($url);
          $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
          $fileContents = trim(str_replace('"', "'", $fileContents));
          $simpleXml = simplexml_load_string($fileContents);
          $json = json_encode($simpleXml);
          //Preparamos la salida
          $json = substr($json, 8);
          $num = 1;
          $json = substr($json, 0, -$num);
          return $json;
        }
        //Ejecutamos la query con diferente parametro de busqueda hasta llegar a un limite
        while($numero<=1000){
          buscaJuegos($alfabeto[$i]);
          $i++;
        }
        // crea una bbdd
        $mongo = new MongoClient("mongodb://127.0.0.1:27017");
        $db = $mongo->biblioteca;
        $coleccion = $db->juegos;
        for($x = 0 ; $x <= 1000; $x++){
          $juego = array('id' => $x, 'nombre' => $juegos[$x], 'plataforma' => $plataforma[$x]);
          $coleccion->insert($juego);
          //Una vez carga los primeros 1000 resultados salta a la página de consulta
          if($x == 1000){
            $url="consulta.php";
            echo "<SCRIPT>window.location='$url';</SCRIPT>";
          }
        }
     ?>
  </body>
</html>
