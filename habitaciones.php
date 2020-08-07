<?php   
   session_start();
   require 'database.php';
   $message='';
   if (isset($_SESSION['id'])) {
      $sql="SELECT id_usr, email, password,nombreU FROM usuario WHERE id_usr=:id";
      $records=$conn->prepare($sql);
      $records->bindParam(':id',$_SESSION['id']);
      $records->execute();
      $results=$records->fetch(PDO::FETCH_ASSOC);
      $user=null;
      $message=$results['nombreU'];
   }
   else{//si no hay ningun usuario registrado no se accede al sistema, sino que se redirecciona a la parte de iniciar sesión o registrarse
      header("Location: /ProyectoIngSW");
   }

   
   
   ?>
<!DOCTYPE html>
<html >
   <head>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
      <!--Link para la fuente 'Roboto'-->
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script type="text/javascript">
         //se ejecuta asíncronamente

           function ajax()
           {

            /*
            XMLHttpRequest:
            Proporciona una forma fácil de obtener información de una URL sin tener que recargar la página completa. Una página web puede actualizar sólo una parte de la página sin interrumpir lo que el usuario está haciendo. XMLHttpRequest es ampliamente usado en la programación AJAX.*/
            var req = new XMLHttpRequest();
           
            /*
            onreadystatechange:
            Una función del objeto JavaScript que se llama cuando el atributo readyState cambia.
            */
            req.onreadystatechange = function(){
               /*
             readyState:
             0 UNINITIALIZED  todavía no se llamó a open().
            1  LOADING  todavía no se llamó a send().
            2  LOADED   send() ya fue invocado, y los encabezados y el estado están disponibles.
            3  INTERACTIVE Descargando; responseText contiene información parcial.
            4  COMPLETED   La operación está terminada.
         
            status:  
            El estado de la respuesta al pedido. Éste es el código HTTPresult (por ejemplo, status es 200 por un pedido exitoso). Sólo lectura.
               */
               if (req.readyState==4 && req.status==200) {
                  /*
                  responseText:
                  La respuesta al pedido como texto, o null si el pedido no fue exitoso o todavía no se envió. Sólo lectura.
                  */
                  document.getElementById('tablaHabs').innerHTML = req.responseText;
               }
            }
            req.open('GET','tablaHabs.php',true);//Inicializa el pedido
            req.send();//envia el pedido
           }
           //Repite la funcion cada segundo
           setInterval(function(){ajax();},1000);
           
           
      </script>
      <title>Listado de Habitaciones</title>
      <style>
         #FuenteRoboto
         {
         margin: 0;
         padding: 0;
         font-family: 'Roboto', sans-serif;
         text-align: center;
         }
         table {
         background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
         border: 3px solid purple;
         }
      </style>
   </head>
   <body class="fondoPlaya1" id="FuenteRoboto">
      <header>
         <!--Inicia navBar-->
         <nav class="navbar navbar-expand-lg navbar-light  " style="background-color: #e3f2fd;" >
            <img src="img/icons8-corona-medieval-30.png" alt="">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav mr-auto">
                  <!--Link 1 del NavBar-->
                  <li class="nav-item active">
                     <a class="nav-link" href="inicio.php">Inicio <span class="sr-only">(current)</span></a>
                  </li>
                  <!--Link 2 del NavBar-->
                  <li class="nav-item">
                     <a class="nav-link" href="habitaciones.php">Administración </a>
                  </li>
                  <!--Link 3 del NavBar-->
                  <li class="nav-item">
                     <a class="nav-link" href="amenidades.php">Amenidades</a>
                  </li>
                  <!--Link 4 del NavBar-->
                  <li class="nav-item">
                     <a class="nav-link" href="paquetes.php">Paquetes</a>
                  </li>
               </ul>
               <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <?php if(!empty($message)): ?><!--No es necesaria-->
                     <?= $message ?>    
                     <?php endif; ?><!--No es necesaria-->
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <a class="dropdown-item" href="perfil.php
                     ">Ver perfil</a>
                     <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                  </div>
               </div>
            </div>
         </nav>
         <!--Fin NavBar-->
      </header>
      

      
      <button type="button" class="btn btn-outline-primary btn-sm m-0 waves-effect">
      <a href="nuevaReservacion.php"> Nueva reservación</a>
      </button>
      <div id="tablaHabs" class="tabla" style="text-align:center;width:100%; background-color: white;">
         
      </div>
      
      <script src="js/jquery.js" type="text/javascript">  </script>
      <script src="js/bootstrap.min.js" type="text/javascript">  </script>
   </body>
</html>