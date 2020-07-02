<?php
       session_start();
       require 'database.php';
       $message='';
       $datosR='';
       $avisoFecha='';
       $avisoPromo;
       $avisoIDHab='';
       $avisoPersonas='';
       $avisoFechaMayor='';
       $montoNuevo;
       //si existe una sesion 
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
   
   
   //corroboramos que tengamos esos datos o que no estén vacíos esos campos
   if( !empty($_POST['nombreC']) && !empty($_POST['apellidoC']) && !empty($_POST['tarjetaC']) && !empty($_POST['id_hab']) && !empty($_POST['numPersonas']) &&!empty($_POST['fechaLlegada']) && !empty($_POST['fechaSalida'])  ) 
   {
        
      // vamos a buscar el cliente para que no haya la necesidad de crear uno(si hay ckiente)

      $sql0="SELECT id_cliente FROM cliente WHERE (numTarjeta=:tarjetaC) AND (nombre=:nombreC) AND (ApPC=:apellidoC)";
      $stmt0=$conn->prepare($sql0);
      $stmt0->bindParam(':nombreC',$_POST['nombreC']);
      $stmt0->bindParam(':apellidoC',$_POST['apellidoC']);
      $stmt0->bindParam(':tarjetaC',$_POST['tarjetaC']);
      $stmt0->execute();
      $numeroColumns=$stmt0->fetchColumn();
      if ($numeroColumns==0) {//si no existe el cliente se crea
          //creamos al cliente
          //Modelo base para la insercion en una BD a partir de formulario php
          $sql0="INSERT INTO cliente (nombre, ApPC, numTarjeta ) VALUES (:nombreC,:apellidoC,:tarjetaC)";
          $stmt0=$conn->prepare($sql0);//le pasamos la sentencia sql a la conexion
          //relacionamos las variables que se le pasan a la sentencia sql con las variables de tipo POST que se reciben por el formulario
          $stmt0->bindParam(':nombreC',$_POST['nombreC']);
          $stmt0->bindParam(':apellidoC',$_POST['apellidoC']);
          $stmt0->bindParam(':tarjetaC',$_POST['tarjetaC']);
          $stmt0->execute(); 
      }
      
      //buscamos al cliente por su tarjeta
      $sql0="SELECT id_cliente FROM cliente WHERE numTarjeta=:tarjetaC";
      $stmt0=$conn->prepare($sql0);
      $stmt0->bindParam(':tarjetaC',$_POST['tarjetaC']);
      $stmt0->execute();
      $resultadoIDCte=$stmt0->fetch(PDO::FETCH_ASSOC);
      $idCte=$resultadoIDCte["id_cliente"];

      $fecha1=new DateTime($_POST['fechaLlegada']);
      $fecha2=new DateTime($_POST['fechaSalida']);

      if ($fecha1>$fecha2) {
        $avisoFechaMayor='La fecha de llegada no puede ser mayor a la de salida';
      }
      else
      {
          //antes de insertar esa reservacion tenemos que corroborar que no existan reservaciones de esa habitacion en ese rango de fecha y hora solicitado

      //selecciona los registros que tengan una reservacion dentro del rango solicitado en una habitacion en específico (si hay lugar)
      $sql="SELECT * FROM reservacion WHERE check_in>=:fechaLlegada AND check_out<=:fechaSalida AND id_habitacion=:id_hab";
      $stmt=$conn->prepare($sql);
      $stmt->bindParam(':fechaLlegada',$_POST['fechaLlegada']);
      $stmt->bindParam(':fechaSalida',$_POST['fechaSalida']);
      $stmt->bindParam(':id_hab',$_POST['id_hab']);
      $stmt->execute();
      $numColFecha=$stmt->fetchColumn();
      if ($numColFecha>0) {//significa que ya hay reservaciones hechas para esa fecha. No hay espacio
          $avisoFecha='No es posible registrar la reservacion para esa fecha porque ya está ocupada. Eliga un rango de fecha distinto';
      }
      else //sí hay lugar
      {//si es igual a 0 significa que ese rango de fecha y hora solicitado, está disponible
          //tenemos que hacer las validaciones de las personas
          $maxPers;
          /* 1->Estándar-->(1 a 2 personas)--->$1000 o $1500
             2->JunioSuite-->(1 a 5 personas)--->$3000

             Seleccionar el ID de hab, buscar la hab por ID y si la hab tiene id_tipo_hab=1 es estandar
                                                                              id_tipo_hab=2 es JunioSuite
          */
          $sql="SELECT MAX(id_habitacion) as maxIDHab, MIN(id_habitacion) as minIDHab FROM habitacion";
          $stmt=$conn->prepare($sql);          
          $stmt->execute();
          $resID=$stmt->fetch(PDO::FETCH_ASSOC);
          //corroboramos que el usuario eliga un id correcto
          if ($_POST['id_hab']<$resID['minIDHab'] || $_POST['id_hab']>$resID['maxIDHab']) {
            $avisoIDHab='Selecciona un id de habitacion válido';
          }
          else
          {

            //ahora vamos a verificar que se eliga la capacidad correcta de la habitacion
            $sql="SELECT id_tipo_habitacion,amenidades FROM habitacion WHERE id_habitacion=:id_hab";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id_hab',$_POST['id_hab']);
            $stmt->execute();
            $resID_tipo=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($resID_tipo['id_tipo_habitacion']==1) {//significa que es estandar
              $montoNuevo=1000;//es el precio de la hab sin frigobar
              $maxPers=2;

              if (strpos($resID_tipo['amenidades'], 'Frigobar') !== false) {//si en sus amenidades contiene frigobar
                $montoNuevo=1500;
              }


              if ($_POST['numPersonas']>$maxPers) {
                $avisoPersonas='Límite de personas por tipo de habitacion excedido';
              }else{//si ya todo esta correcto, ingresamos la reservacion
                  //antes de insertar la reservacion tenemos que modificar el precio en caso de que se cumpla con alguna promocion
                  //tenemos que ver cuántos días son de reservacion (restamos la fecha de salida con la fecha de llegada) 
                  $date1=new DateTime($_POST["fechaLlegada"]);
                  $date2=new DateTime($_POST["fechaSalida"]);
                  $dias=$date1->diff($date2);
                  //$avisoPromo tiene la cantidad de días entre la fecha de llegada y fecha de salida
                  $avisoPromo=$dias->format('%d');
                  $montoNuevo=$montoNuevo*$avisoPromo;//multiplicacion de días por precio de la habitación
                  if ($avisoPromo>=3 && $avisoPromo<10) {//descuiento 1
                    $montoNuevo=$montoNuevo-($montoNuevo*0.2);
                  }elseif ($avisoPromo>=10) {//descuento 2
                    $montoNuevo=$montoNuevo-($montoNuevo*0.5);
                  }

                  //hay que ver si se ingreso una tarjeta de descuento
                  if (isset($_POST["descuento"])) {
                    if ($_POST["descuento"]==1) {//unam
                      $montoNuevo=$montoNuevo-($montoNuevo*0.2);
                    }elseif ($_POST["descuento"]==2) {//estudiantes
                      $montoNuevo=$montoNuevo-($montoNuevo*0.1);
                    }elseif ($_POST["descuento"]==3) {//tercera edad
                      $montoNuevo=$montoNuevo-($montoNuevo*0.5);
                    }
                  }

                  //creamos la reservacion
                  $sql="INSERT INTO reservacion (numero_personas,check_in,check_out,id_habitacion,estatus, id_usr,id_cliente, monto) VALUES (:numPersonas,:fechaLlegada,:fechaSalida,:id_hab,'s',:id_user,:id_cliente,:monto)";
                  $stmt=$conn->prepare($sql);
                  $stmt->bindParam(':numPersonas',$_POST['numPersonas']);
                  $stmt->bindParam(':fechaLlegada',$_POST['fechaLlegada']);
                  $stmt->bindParam(':fechaSalida',$_POST['fechaSalida']);
                  $stmt->bindParam(':id_hab',$_POST['id_hab']);
                  $stmt->bindParam(':id_user',$_SESSION['id']);
                  $stmt->bindParam(':id_cliente',$idCte);
                  $stmt->bindParam(':monto',$montoNuevo);
                  if($stmt->execute())
                  {
                      $datosR='Reservacion creada con éxito';
                  }
                  else{
                      $datosR='Error en la creación de reservacion';
                  }
              }
            }
            elseif ($resID_tipo['id_tipo_habitacion']==2) {//significa que es junior suite
              $montoNuevo=3000;
              $maxPers=5;
              if ($_POST['numPersonas']>$maxPers) {
                $avisoPersonas='Límite de personas por habitacion, excedido';
              }else{
                  //antes de insertar la reservacion tenemos que modificar el precio en caso de que se cumpla con alguna promocion

                  //tenemos que ver cuántos días son de reservacion (restamos la fecha de salida con la fecha de llegada) 
                  $date1=new DateTime($_POST["fechaLlegada"]);
                  $date2=new DateTime($_POST["fechaSalida"]);
                  $dias=$date1->diff($date2);
                  $avisoPromo=$dias->format('%d');
                  $montoNuevo=$montoNuevo*$avisoPromo;//multiplicacion de días por precio de la habitación
                  if ($avisoPromo>=3 && $avisoPromo<10) {//descuiento 1
                    $montoNuevo=$montoNuevo-($montoNuevo*0.2);
                  }elseif ($avisoPromo>=10) {//descuento 2
                    $montoNuevo=$montoNuevo-($montoNuevo*0.5);
                  }

                  //hay que ver si se ingreso una tarjeta de descuento
                  if (isset($_POST["descuento"])) {
                    if ($_POST["descuento"]==1) {//unam
                      $montoNuevo=$montoNuevo-($montoNuevo*0.2);
                    }elseif ($_POST["descuento"]==2) {//estudiantes
                      $montoNuevo=$montoNuevo-($montoNuevo*0.1);
                    }elseif ($_POST["descuento"]==3) {//tercera edad
                      $montoNuevo=$montoNuevo-($montoNuevo*0.5);
                    }
                  }

                  //creamos la reservacion

                  $sql="INSERT INTO reservacion (numero_personas,check_in,check_out,id_habitacion,estatus, id_usr,id_cliente, monto) VALUES (:numPersonas,:fechaLlegada,:fechaSalida,:id_hab,'s',:id_user,:id_cliente,:monto)";
                  $stmt=$conn->prepare($sql);
                  $stmt->bindParam(':numPersonas',$_POST['numPersonas']);
                  $stmt->bindParam(':fechaLlegada',$_POST['fechaLlegada']);
                  $stmt->bindParam(':fechaSalida',$_POST['fechaSalida']);
                  $stmt->bindParam(':id_hab',$_POST['id_hab']);
                  $stmt->bindParam(':id_user',$_SESSION['id']);
                  $stmt->bindParam(':id_cliente',$idCte);
                  $stmt->bindParam(':monto',$montoNuevo);
                  if($stmt->execute())
                  {
                      $datosR='Reservacion creada con éxito';
                  }
                  else{
                      $datosR='Error en la creación de reservacion';
                  }
              }

            }
            
          }
      }  
      }

      
    }
?>
      
    
<!DOCTYPE html>
<html>
   <head>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
      <!--Link para la fuente 'Roboto'-->
      <link rel="stylesheet" type="text/css" href="css/styles.css">
      <!--Link para incluir a la hoja de estilos 'styles.css'-->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <title>Nueva reservación de Habitación</title>
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
   <body class="fondoPlaya1" style="text-align: center;">
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
                     <a class="dropdown-item" href="perfil.php">Ver perfil</a>
                     <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                  </div>
               </div>
            </div>
         </nav>
         <!--Fin NavBar-->
      </header>
      <h2>Nueva reservación de Habitación</h2>
      <?= $datosR ?> 
      <?= $avisoFecha ?>
      <?= $avisoFechaMayor ?>
      <?= $avisoIDHab ?>
      <?= $avisoPersonas ?>
      <form action="nuevaReservacion.php" method="post">
      <table border="1" class="table table-striped table-responsive-md">
         <th>
            <h4>datos del cliente</h4>
               <input type="text" name="nombreC" placeholder="Ingresa el nombre del titular de la reservacion">
               <input type="text" name="apellidoC" placeholder="Ingresa el apellido paterno del titular">
               <input type="number" name="tarjetaC" placeholder="Ingresa el numero de tarjeta bancaria del cliente" maxlength="16">
               <br>
               Tarjeta:
               <input type="number" name="descuento" maxlength="1" max="3" min="1">
            <p>1)UNAM   <br>2)Estudiantes   <br>3)3ra edad </p>
            
         </th>
         <th>
            <h4>Datos de la habitación</h4>
               <input type="number" name="id_hab" placeholder="Ingresa el ID de habitación" maxlength="2">
               <br>
               <input type="number" name="numPersonas" placeholder="Ingresa el número de personas" maxlength="1">
               <br>

         </th>
         <th>
            <h4>Datos de la reservación</h4>
            Fecha y hora de llegada: <input type="datetime" name="fechaLlegada" placeholder="aaaa-mm-dd hh:mm:ss">
            <br> 
            <br>
            <br>
            Fecha y hora de salida: <input type="datetime" name="fechaSalida" placeholder="aaaa-mm-dd hh:mm:ss">
         </th>
      </form>
      </table>
      <input type="submit" value="Enviar">
      <!--tabla de habitaciones registradas-->
      <div class="tabla" style="text-align:center;width:100%; background-color: white;">
         <table border="1" class="table table-striped table-responsive-md">
            <tr>Habitaciones registradas</tr>
            <tr>
               <!--Columnas-->
               <th>Identificador</th>
               <th>Número</th>
               <th>Piso</th>
               <th>Dsiponibilidad</th>
               <th>Tipo</th>
               <th>Amenidades</th>
            </tr>
            <?php
               try {
               
                   $db = new PDO('mysql:host=127.0.0.1;dbname=hotel;charset=utf8', 'root', '');
                   //$db = new PDO('sqlsrv:host=127.0.0.1;schema=hotel', 'root', 'adrgcmsht578t53$'); // Si en el futuro la pasan a SQL Server
               
                   $resultado = $db->query("SELECT id_habitacion, numero,amenidades,h.activo, piso, nombre tipo
                                           FROM habitacion h INNER JOIN tipo_habitacion th ON h.id_tipo_habitacion = th.id_tipo_habitacion
                                           ");
               
                   foreach ($resultado as $habitacion) { ?>
            <tr>
               <td><?php echo $habitacion['id_habitacion']; ?></td>
               <td><?php echo $habitacion['numero']; ?></td>
               <td><?php echo $habitacion['piso']; ?></td>
               <td><?php echo $habitacion['activo']; ?></td>
               <td><?php echo $habitacion['tipo']; ?></td>
               <td><?php echo $habitacion['amenidades']; ?></td>
            </tr>
            <?php }
               } catch (Exception $ex) {
                   echo 'Ocurrió un error en la conexión: ' . $ex->getMessage();
               }
               
               ?>
         </table>
      </div>
      <script src="js/jquery.js" type="text/javascript">  </script>
      <script src="js/bootstrap.min.js" type="text/javascript">  </script>
   </body>
</html>