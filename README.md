# Academy - Symfony

Implementacion endpoint de una api REST empleando Symfony 5.4


## Comenzando 🚀

Ejecutaremos el proyecto de FORMA LOCAL

### Revisando el entorno de trabajo 📋

Se debe tener instalado ...

```
-  Terminal
-  Php 7.4
-  Composer
-  Symfony CLI

```

### Instalación 🔧

Pasos a ejecutar desde terminal ...

Clonamos el proyecto en nuestro entorno local, en el siguiente directorio

```
...var/www$ git clone git@github.com:zuherna/academy.git

```

Accedemos al directorio del proyecto

```
...var/www$ cd academy
```

Y ejecutamos

```
...var/www/academy$ symfony composer install

```

Para levantar la aplicación

```
...var/www/academy$ symfony serve

Y mediante el navegador accedemos al endpoint :
https://127.0.0.1:8000/api/cursos/{id}

Si se hace por Postman mirar en consola donde está levantado el Development Server y usar el http://127.0.0.1:xxxxx indicado

Para los datos hemos utilizado los siguientes ficheros :
cursos.json y opiniones.json (ubicados en directorio "data" en la raíz del proyecto)
{id} válidos : 1, 2, 3, 4 y 5
```

## Ejecutando las pruebas ⚙️

El proyecto incluye una prueba funcional. Para ejecutarla ...

```
...var/www/academy$ symfony run bin/phpunit

```

## Analizador de código 🛠️

El proyecto incluye PHPStan. Tiene hasta 9 niveles, por ahora nos quedaremos en el nivel 1, configurado en el fichero phpstan.neon
Para ejecutarlo ...

```
...var/www/academy$ symfony php vendor/bin/phpstan analyze
...var/www/academy$ symfony php -d memory_limit=-1 vendor/bin/phpstan analyze -l 1  (si queremos especificar el nivel)

```


