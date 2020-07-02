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
   
   
   
   if (isset($_POST['guardar'])) {
       // Se envió el formulario
       $numero = $_POST['numero'];
       $valores = $_POST;
       $amenidades = filter_input(INPUT_POST, 'amenidades', FILTER_SANITIZE_SPECIAL_CHARS);
       if (isset($_GET['id'])) {
           $consulta = $conn->prepare("UPDATE habitacion SET numero = ?, piso = ?, amenidades = ?, id_tipo_habitacion = ?, activo = ? WHERE id_habitacion = ?");
           $exito = $consulta->execute([$numero, $_POST['piso'], $amenidades, $_POST['id_tipo_habitacion'], $_POST['activo'], $_GET['id']]);
       } else {
           $consulta = $conn->prepare("INSERT INTO habitacion (numero, piso, amenidades, id_tipo_habitacion, activo) VALUES (?, ?, ?, ?, ?)");
           $exito = $consulta->execute([$numero, $_POST['piso'], $amenidades, $_POST['id_tipo_habitacion'], $_POST['activo']]);
       }
       header("Location: habitaciones.php?guardado=" . ($exito ? 'SI' : 'NO' ));
       exit;
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
      <title>Mantenimiento de Habitación</title>
      <style>
         #FuenteRoboto
         {
         margin: 0;
         padding: 0;
         font-family: 'Roboto', sans-serif;
         text-align: center;
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
      <h2>Mantenimiento de Habitación</h2>
      <form action="mantenimiento_habitacion.php.php" method="post">
      <input type="text" name="numero" placeholder="Ingresa el número de habitación">
      <input type="text" name="piso" placeholder="Ingresa el piso de la habitacion">
      <input type="text" name="amenidades" placeholder="Ingresa las amenidades">
        <h6>Selecciona el tipo de habitacion</h6>
      <select name="id_tipo_habitacion">
        
        <option value="1">Sencilla</option>
        <option value="2">Doble</option>
        <option value="3">Suite</option>
      </select>
      <br>
      <br>
        <h6>Selecciona el activo de habitacion</h6>
      <select name="activo">
        
        <option value="S">S</option>
        <option value="N">N</option>
      </select>

      <br>
      <br>
      <input type="submit" value="Enviar">
    </form> 
      <form method="POST">
         <p>
            <label for="numero">Número de habitación:</label>
            <input type="text" id="numero" name="numero" value="<?php echo isset($registro) ? $registro['numero'] : '' ?>" />
         </p>
         <p>
            <label for="piso">Número de piso:</label>
            <input type="number" id="piso" name="piso" value="<?php echo isset($registro) ? $registro['piso'] : '' ?>" />
         </p>
         <p>
            <label for="amenidades">Amenidades:</label>
            <textarea id="amenidades" name="amenidades"><?php echo isset($registro) ? $registro['amenidades'] : '' ?></textarea>
         </p>
         <p>
            <label for="id_tipo_habitacion">Tipo de Habitación:</label>
            <select id="id_tipo_habitacion" name="id_tipo_habitacion">
               <?php
                  foreach ($db->query("SELECT * FROM tipo_habitacion WHERE activo = 'S'") as $opcion) { ?>
               <option value="<?php echo $opcion['id_tipo_habitacion']; ?>" <?php echo isset($registro) && $opcion['id_tipo_habitacion'] == $registro['id_tipo_habitacion'] ? 'selected' : ''; ?>><?php echo $opcion['nombre']; ?></option>
               <?php }
                  ?>
            </select>
         </p>
         <p>
            <input type="hidden" id="activo_N" name="activo" value="N">
            <label>Activo 
            <input type="checkbox" id="activo_S" name="activo" value="S" <?php echo isset($registro) && $registro['activo'] == 'S' ? 'checked' : ''; ?>>
            </label>
         </p>
         <p>
            <button type="submit" name="guardar">Guardar</button>
            <a href="habitaciones.php">Cancelar</a>
         </p>
      </form>

      <script src="js/jquery.js" type="text/javascript">  </script>
    <script src="js/bootstrap.min.js" type="text/javascript">  </script>
+
   </body>
</html>