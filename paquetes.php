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
        <meta charset="UFT-8">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> <!--Link para la fuente 'Roboto'-->
        <link rel="stylesheet" type="text/css" href="css/styles.css"> <!--Link para incluir a la hoja de estilos 'styles.css'-->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Promociones y Descuentos</title>
        
    </head>
    
    <body>
    
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
        <a class="nav-link" href="promociones.php">Paquetes</a>
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
</nav><!--Fin NavBar-->
</header>
<h1 style="text-align: Center">Descuentos y Promociones</h1>


<main>
    
    <div class="container">
    <div class="row">
    <h2 style="text-align: Center">Descuentos</h2>
    <!--Grid row-->
    <div class="row">
    <div class="row">
    
    <!--Grid column-->
    <div class="col-md-3 mb-4">

      <div class="view overlay z-depth-1-half">
        <img src="img/3edad.jpg"  alt="">
        <div class="mask rgba-white-light"></div>
      </div>

    </div>
    <!--Grid column-->

    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Descuentos para personas de la tercera edad</h4>
      <hr>
      <p>En Hotel el Descanso Medieval sabemos que las personas mayores merecen tener el mejor de los descansos y la mejor
        atención, es por eso que para ellas otorganos un 50% de descuentos en cualquier reservación de cualquiera de los tipos de habitaciónes que les ofrecemos. 
      </p>
    </div>
    <!--Grid column-->
    <!--Grid column-->
    <div class="col-md-3 mb-4">

      <div class="view overlay z-depth-1-half">
        <img src="img/univer.jpg"  alt="">
        <div class="mask rgba-white-light"></div>
      </div>

    </div>
    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Descuentos para estudiantes</h4>
      <hr>
      <p>En Hotel el Descanso Medieval sabemos que después de un largo ciclo escolar mereces dejar de preocuparte por tu futuro incierto y deseas un descanso sin ajetreo ni preocupaciones.
      Es por esto que te ofrecemos un 10% de descuento en cualquier reservación que realices en cualquiera de los tipos de habitaciones que te ofrecemos. 
      </p>
    </div>
    <!--Grid column-->
    <!--Grid column-->
    <div class="col-md-3 mb-4">

      <div class="view overlay z-depth-1-half">
        <img src="img/unam2.jpg"  alt="">
        <div class="mask rgba-white-light"></div>
      </div>

    </div>
    <!--Grid column-->
    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Descuentos para estudiantes de la UNAM</h4>
      <hr>
      <p>Así estudies la secundaria, preparatoria o a nivel superior, la UNAM es nuestra máxima casa de estudios en México, por ello en Hotel el Descanso Medieval queremos compartir el orgullo de que representes a ésta enorme institución al otorgarte un 20% de descuento en cualquier reservación de cualquier tipo. ¡Orgullosamente UNAM!
      </p>
    </div>
    <!--Grid column-->

  </div> 
    <h2 style="text-align: Center">Promociones</h2>
    <!--Grid row-->
    <div class="row">
    <div class="row">
    
    <!--Grid column-->
    <div class="col-md-3 mb-4">

      <div class="view overlay z-depth-1-half">
        <img src="img/promos.png"  alt="">
        <div class="mask rgba-white-light"></div>
      </div>

    </div>
    <!--Grid column-->
    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Vacaciones de verano o navidad</h4>
      <hr>
      <p>Sabemos que necesitas un merecido descaso del ajetreo de la vida cotidiana, y aquí en Hotel el descanso medieval, lo entendemos, es por eso que al reservar con nosotros para fechas navideñas o de verano, te ofrecemos un enorme 40% de descuento en tu reservación. (No aplica en temporada baja u otros días festivos).  
      </p>
    </div>
    <!--Grid column-->
    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Diez o más noches </h4>
      <hr>
      <p>Si tenemos la fortuna de poder ofrecerte una estancia de 10 o más noches en nuestras instalaciones, de brindamos un descuento sin igual, 
        ¡UN 50% DE DESCUENTO!
        (solo aplica en temporada baja y en días festivos).  
      </p>
    </div>
    <!--Grid column--> 
    <!--Grid column-->
    <div class="col-md-3 mb-3">

      <h4>Tres o más noches</h4>
      <hr>
      <p>El descuento que te brindamos si reservas con nosotros tres noches o más es de un 20% en temporada baja y días festivos.  
      </p>
    </div>
    <!--Grid column--> 

    <button type="button" class="btn btn-outline-primary btn-sm m-0 waves-effect">
      <a href="nuevaReservacion.php">Realice su reservación ahora mismo</a>
    </button>
     
    
</main>

    <!-- Footer -->
<footer class="page-footer font-small blue pt-4" style="background-color: #e3f2fd;">

    <!--Footer Links-->
<div class="container mt-5 mb-4 text-center text-md-left" >
    <div class="row mt-3">

        <!--First column-->
        <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
            <h6 class="text-uppercase font-weight-bold">
                <strong>Hotel el descanso medieval</strong>
            </h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>En el hotel el descanso medieval tenemos como objetivo que tengas el mejor hospedaje con las mejores amenidades de la ciudad.</p>
        </div>
        <!--/.First column-->

        

        <!--Third column-->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase font-weight-bold">
                <strong>Menú</strong>
            </h6>
            <hr class="de ep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <a href="inicio.php">Inicio</a>
            </p>
            <p>
                <a href="habitaciones.php">Administración de habitaciones</a>
            </p>
            <p>
                <a href="amenidades.php">Amenidades</a>
            </p>
            <p>
                <a href="paquetes.php">Paquetes</a>
            </p>
            <p>
                <a href="#!">Contacto</a>
            </p>

        </div>
        <!--/.Third column-->

        <!--Fourth column-->
        <div class="col-md-4 col-lg-3 col-xl-3">
            <h6 class="text-uppercase font-weight-bold">
                <strong>Contacto</strong>
            </h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <i class="fas fa-home  mr-3"></i> Colima, MX 10012, México</p>
            <p>
                <i class="fas fa-envelope mr-3"></i> info_descanso_medieval@gmail.com</p>
            <p>
                <i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
            <p>
                <i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
        </div>
        <!--/.Fourth column-->

    </div>
</div>
<!--/.Footer Links-->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
    
   



    <script src="js/jquery.js" type="text/javascript">  </script>
    <script src="js/bootstrap.min.js" type="text/javascript">  </script>
    </body>

</html>