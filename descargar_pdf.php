
<?php 


   session_start();

require 'pdf/fpdf/fpdf.php';
require 'database.php';
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

$busqueda=$conn->prepare("SELECT r.id_cliente,c.nombre,c.ApPC,r.check_in,r.check_out, r.monto FROM RESERVACION r JOIN cliente c ON r.id_cliente=c.id_cliente  WHERE id_usr=:id ORDER BY r.id_cliente");
            $busqueda->bindParam(':id',$_SESSION['id']);
            $busqueda->execute();


$pdf= new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

$pdf->Cell(70,10,'Reporte de ventas',1,0,'C');
$pdf->Ln(20);

$pdf->Cell(10,10,'ID',1,0,'C');
$pdf->Cell(20,10,'nombre_cli',1,0,'C');
$pdf->Cell(20,10,'apellido_cli',1,0,'C');
$pdf->Cell(35,10,'llegada',1,0,'C');
$pdf->Cell(35,10,'salida',1,0,'C');
$pdf->Cell(10,10,'monto',1,0,'C');

$pdf->Ln(12);

while ($row=$busqueda->fetch(PDO::FETCH_ASSOC)) {
   $pdf->Cell(10,10,$row["id_cliente"],1,0,'C',0);
   $pdf->Cell(20,10,$row["nombre"],1,0,'C',0);
   $pdf->Cell(20,10,$row["ApPC"],1,0,'C',0);
   $pdf->Cell(35,10,$row["check_in"],1,0,'C',0);
   $pdf->Cell(35,10,$row["check_out"],1,0,'C',0);
   $pdf->Cell(10,10,$row["monto"],1,1,'C',0);
}

$pdf->Output();

 ?>      
      