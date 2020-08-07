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

   //vamos a verificar si la fecha actual coincide con la de la reservacion, si sí, vamos a cambiar el estatus de esa habitacion1
   $fechaActual = new DateTime();
   $fechaActual->getTimestamp();
   $fechaActual=date_format($fechaActual, 'Y-m-d H:i:s');
   //vamos a verificar todas las fechas de las reservaciones
   $sql="SELECT check_in, check_out, id_habitacion FROM reservacion";
   $resFecha=$conn->query($sql);
   foreach ($resFecha as $fechaIteracion) {
     //si la fecha actual se encuentra entre check_in y check_out de cualquier reservacion
    if ( $fechaActual>=$fechaIteracion['check_in'] && $fechaActual<=$fechaIteracion['check_out'] ) {
      $sqlUpdateFecha="UPDATE habitacion SET activo='N' WHERE id_habitacion=:id_hab";
      $records=$conn->prepare($sqlUpdateFecha);
      $records->bindParam(':id_hab',$fechaIteracion['id_habitacion']);
      $records->execute();
    }
    else
    {
      $sqlUpdateFecha="UPDATE habitacion SET activo='S' WHERE id_habitacion=:id_hab";
      $records=$conn->prepare($sqlUpdateFecha);
      $records->bindParam(':id_hab',$fechaIteracion['id_habitacion']);
      $records->execute();
    }
   }

   ?>
   <br>
   <p>
     <?= ($fechaActual) ?>
   </p>
   <br>
<table border="1" class="table table-striped table-responsive-md">
   <tr>Habitaciones registradas</tr>
   <tr>
      <!--Columnas-->
      <th>Id habitación</th>
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
      <!--Estatus de la habitacion va a cambiar con AJAX-->
      <td><?php echo $habitacion['tipo']; ?></td>
      <td><?php echo $habitacion['amenidades']; ?></td>
   </tr>
   <?php }
      } catch (Exception $ex) {
          echo 'Ocurrió un error en la conexión: ' . $ex->getMessage();
      }
      ?>
</table>