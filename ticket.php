<?php
   session_start();
       require 'database.php';
       require 'pdf/fpdf/fpdf.php';
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
      
       if (isset($_GET['idR'])) {
        $cadena = $_GET['idR'];

        list($dato1ID, $dato2Nombre, $dato3Llegada, $dato4Salida, $dato5ID_usr, $dato6monto) = explode('/', $cadena);

          
       }


    $pdf= new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(70,10,'Ticket de compra',1,0,'C');
    $pdf->Ln(20);
    $pdf->Cell(13,10,'idCTE',1,0,'C');
    $pdf->Cell(20,10,'nombre_cli',1,0,'C');
    $pdf->Cell(35,10,'llegada',1,0,'C');
    $pdf->Cell(35,10,'salida',1,0,'C');
    $pdf->Cell(13,10,'idUSR',1,0,'C');
    $pdf->Cell(10,10,'monto',1,0,'C');
    $pdf->Ln(12);

    $pdf->Cell(13,10,$dato1ID,1,0,'C');
    $pdf->Cell(20,10,$dato2Nombre,1,0,'C');
    $pdf->Cell(35,10,$dato3Llegada,1,0,'C');
    $pdf->Cell(35,10,$dato4Salida,1,0,'C');
    $pdf->Cell(13,10,$dato5ID_usr,1,0,'C');
    $pdf->Cell(10,10,$dato6monto,1,0,'C');

    
    $pdf->Output();


   
   ?>
