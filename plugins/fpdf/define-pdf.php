<?php
require_once('fpdf.php');

$dinero = (isset($dinero) && !empty($dinero)) ? $dinero : '';
$compañia = (isset($compañia) && !empty($compañia)) ? $compañia : '';
$fecha = (isset($fecha) && !empty($fecha)) ? $fecha : '';
$salida = (isset($salida) && !empty($salida)) ? $salida : '';
$destino = (isset($destino) && !empty($destino)) ? $destino : '';


$docIdentidad = (empty($docIdentidad)) ? "XXXXXXXXXX" : $docIdentidad;
$tipo_docIdentidad = (empty($tipo_docIdentidad)) ? "DNI": $tipo_docIdentidad ;
$localidad = (empty($localidad)) ? "" : " con domicilio en ".strtoupper($localidad). " y ";
$direvol = (empty($direvol)) ? "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" : stripslashes($direvol);

$pdf = new PDF();

$html = '<b>'. strtoupper($pdfNombre) . ' ' . strtoupper($pdfApellido) . '</b>, actuando en nombre y representación propia, con '.$tipo_docIdentidad.' '.$docIdentidad.', adjuntado a la presente demanda como <b><u>Documento núm. 1</u></b> y con <b><u>DOMICILIO A EFECTO DE NOTIFICACIONES</u></b> en Rambla de Iberia 97, CP: 08205 de Sabadell telf.: 93 445 97 64, fax: 93 396 98 65 y email info@populetic.com ante el Juzgado comparezco y como mejor proceda en derecho, <b>DIGO</b>:';

$html2 = ' Que    por    medio    del    presente    escrito   formulo  <b>DEMANDA DE JUICIO VERBAL EN RECLAMACION DE CANTIDAD DE '.$dinero.' EUROS</b>, contra la mercantil <b>'.$compañia.'</b>  con  domicilio  a  efecto  de   notificaciones  en  '.$direvol.' con base en los siguientes';

/*$lenguage = 'es_ES.UTF-8';
putenv("LANG=$lenguage");
setlocale(LC_ALL, $lenguage);*/

$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(40, 30);
$pdf->MultiCell(130,5,utf8_decode('
AL JUZGADO MERCANTIL QUE POR TURNO CORRESPONDA'),0,'C',False);

$pdf->SetFontSize(10);
$pdf->SetXY(30,60);
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(15);
$pdf->WriteHTML(utf8_decode($html),'');

$pdf->SetXY(30,95);
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(15);
$pdf->WriteHTML(utf8_decode($html2));

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(90, 120);
$pdf->MultiCell(150,5,utf8_decode('H E C H O S'),0,'J',False);

$html3 = ' <b>Primero.- </b><u>EXISTENCIA DE RELACIÓN CONTRACTUAL. COMPRA DE VUELO.</u>';

$html4 = 'El demandante compró unos billetes de avión a la compañía aérea para viajar en fecha '.$fecha.', desde el aeropuerto de '.$salida.' hasta el aeropuerto de '.$destino.'';//, haciendo escala en _______.';

$html5 = 'Se adjunta como <b><u>Documento núm. 2</u></b> reserva e itinerario de los vuelos. ';

$html6 = 'Se adjunta como <b><u>Documento núm. 3</u></b> tarjetas de embarque. ';

$pdf->SetFont('Arial','',10);

$pdf->SetFont('Arial');
$pdf->SetXY(30,135);
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(30);
$pdf->WriteHTML(utf8_decode($html3));


$pdf->SetXY(30,145);
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(30);
$pdf->WriteHTML(utf8_decode($html4));


$pdf->SetXY(40,165);
$pdf->SetLeftMargin(40);
$pdf->SetRightMargin(30);
$pdf->WriteHTML(utf8_decode($html5));


$pdf->SetXY(30,175);
$pdf->SetLeftMargin(40);
$pdf->SetRightMargin(30);
$pdf->WriteHTML(utf8_decode($html6));
?>