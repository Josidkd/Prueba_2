Para poder hacer funcionar la aplicación realizar los siguientes pasos
----------------------------------------------------------------------
1- Instalar docker
2- Crear una carpera en local y meter los archivos:
	-index.php
	-consulta.php
	-estilo.php
2- Abrir terminal y realizar los siguientes pasos (desde la carpeta donde estén los archivos introducidos siendo root)
	-docker pull ishiidaichi/apache-php-mongo-phalcon (bajamos la imagen del repositorio oficial)
	-docker run -d -p 8080:80 -v "$PWD":/var/www/html ishiidaichi/apache-php-mongo-phalcon (creamos un contenedor con los archivos necesarios)
	-docker ps (con este comando miramos el id de nuestro contenedor creado)
	-docker exec -i -t idContenedorCreado /bin/bash (nos metemos en la terminal de nuestro contenedor)
	-mongod --dbpath /data/db --smallfiles (esto lo ejecutamos en la terminal de nuestro contenedor para levantar mongodb)
3- Nos metemos con un navegador a 127.0.0.1:8080
	