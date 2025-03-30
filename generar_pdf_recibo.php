<?php
require('fpdf/fpdf.php');
require_once ("config/db.php");
require_once ("config/conexion.php");

// Si es una solicitud para descargar, configurar cabeceras apropiadas
$download_mode = isset($_GET['download']) && $_GET['download'] == 1;

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No se especificó un ID válido");
}

$id = intval($_GET['id']);

// Consultar datos del establecimiento
$sql = "SELECT p.*, 
        g.descripcion_giro AS giro_desc, 
        m.descripcion_modalidad_graduacion_alcoholica AS modalidad_desc,
        mu.municipio AS municipio_desc,
        d.delegacion AS delegacion_desc,
        c.colonia AS colonia_desc
        FROM principal p
        LEFT JOIN giro g ON p.giro = g.id
        LEFT JOIN modalidad_graduacion_alcoholica m ON p.modalidad_graduacion_alcoholica = m.id
        LEFT JOIN municipio mu ON p.id_municipio = mu.id
        LEFT JOIN delegacion d ON p.id_delegacion = d.id
        LEFT JOIN colonias c ON p.id_colonia = c.id
        WHERE p.id = " . $id;

$resultado = mysqli_query($con, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Error: No se encontró el registro solicitado");
}

$datos = mysqli_fetch_assoc($resultado);

// Crear PDF
class PDF extends FPDF {
    // Cabecera
    function Header() {
        // Logo
        if (file_exists('img/logo_tijuana.png')) {
            $this->Image('img/logo_tijuana.png', 15, 10, 30);
        }
        
        // Título
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(50, 15);
        $this->Cell(0, 10, utf8_decode('GOBIERNO MUNICIPAL DE TIJUANA'), 0, 1, 'C');
        $this->SetXY(50, 20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, utf8_decode('SECRETARÍA DE GOBIERNO MUNICIPAL'), 0, 1, 'C');
        $this->SetXY(50, 25);
        $this->Cell(0, 10, utf8_decode('DIRECCIÓN DE BEBIDAS ALCOHÓLICAS'), 0, 1, 'C');
        
        // Fecha actual
        $this->SetFont('Arial', 'I', 8);
        $this->SetXY(160, 10);
        $this->Cell(40, 5, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        
        // Línea horizontal
        $this->SetDrawColor(169, 144, 91); // Color #AC905B
        $this->Line(10, 40, 200, 40);
    }
    
    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
        $this->SetX(10);
        $this->Cell(0, 10, utf8_decode('Este documento es un recibo oficial - Gobierno Municipal de Tijuana'), 0, 0, 'L');
    }
    
    // Título de sección
    function TituloSeccion($titulo) {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(169, 144, 91); // Color #AC905B
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, utf8_decode($titulo), 0, 1, 'C', true);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(2);
    }
    
    // Fila de datos
    function FilaDatos($etiqueta, $valor, $ancho1 = 50, $ancho2 = 140) {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell($ancho1, 7, utf8_decode($etiqueta), 1, 0, 'L', false);
        $this->SetFont('Arial', '', 9);
        $this->Cell($ancho2, 7, utf8_decode($valor), 1, 1, 'L', false);
    }
    
    // Celda con borde redondeado
    function CeldaRedondeada($w, $h, $txt, $border = 0, $ln = 0, $align = 'C', $fill = false) {
        $this->SetFillColor(240, 240, 240);
        $this->RoundedRect($this->GetX(), $this->GetY(), $w, $h, 2, 'F');
        $this->Cell($w, $h, $txt, $border, $ln, $align, false);
    }
    
    // Rectángulo redondeado
    function RoundedRect($x, $y, $w, $h, $r, $style = '') {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $this->_out(sprintf('%.2F %.2F l',($x+$w-$r)*$k,($hp-$y)*$k ));
        $this->_curve(($x+$w-$r+$r*$MyArc)*$k,($hp-$y)*$k,($x+$w)*$k,($hp-$y+$r-$r*$MyArc)*$k,($x+$w)*$k,($hp-$y+$r)*$k);
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h-$r))*$k ));
        $this->_curve(($x+$w)*$k,($hp-($y+$h-$r+$r*$MyArc))*$k,($x+$w-$r+$r*$MyArc)*$k,($hp-($y+$h))*$k,($x+$w-$r)*$k,($hp-($y+$h))*$k);
        $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-($y+$h))*$k ));
        $this->_curve(($x+$r-$r*$MyArc)*$k,($hp-($y+$h))*$k,($x)*$k,($hp-($y+$h-$r+$r*$MyArc))*$k,($x)*$k,($hp-($y+$h-$r))*$k);
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$r))*$k ));
        $this->_curve(($x)*$k,($hp-($y+$r-$r*$MyArc))*$k,($x+$r-$r*$MyArc)*$k,($hp-$y)*$k,($x+$r)*$k,($hp-$y)*$k);
        $this->_out($op);
    }
    
    function _curve($x1, $y1, $x2, $y2, $x3, $y3) {
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', $x1, $y1, $x2, $y2, $x3, $y3));
    }
}

// Iniciar documento PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Título principal
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('RECIBO DE INSPECCIÓN'), 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 5, utf8_decode('PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN'), 0, 1, 'C');
$pdf->Cell(0, 5, utf8_decode('DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO'), 0, 1, 'C');
$pdf->Ln(5);

// Número de Folio
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(169, 144, 91); // Color #AC905B
$pdf->Cell(0, 10, utf8_decode('Folio: ' . $datos['folio']), 0, 1, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(5);

// Datos del Establecimiento
$pdf->TituloSeccion('DATOS DEL ESTABLECIMIENTO');
$pdf->FilaDatos('Nombre Comercial:', $datos['nombre_comercial_establecimiento']);
$pdf->FilaDatos('Giro:', $datos['giro_desc']);
$pdf->FilaDatos('Modalidad:', $datos['modalidad_desc']);
$pdf->FilaDatos('Domicilio:', $datos['calle_establecimiento'] . ' #' . $datos['numero_establecimiento'] . 
                (!empty($datos['numerointerno_local_establecimiento']) ? ' Int. ' . $datos['numerointerno_local_establecimiento'] : ''));
$pdf->FilaDatos('Colonia:', $datos['colonia_desc']);
$pdf->FilaDatos('Delegación:', $datos['delegacion_desc']);
$pdf->FilaDatos('Ciudad:', $datos['municipio_desc']);
$pdf->FilaDatos('Código Postal:', $datos['cp_establecimiento']);
$pdf->Ln(5);

// Datos del Solicitante
$pdf->TituloSeccion('DATOS DEL SOLICITANTE');
$pdf->FilaDatos('Persona Física/Moral:', $datos['nombre_persona_fisicamoral_solicitante']);
$pdf->FilaDatos('Representante Legal:', $datos['nombre_representante_legal_solicitante']);
$pdf->FilaDatos('Domicilio:', $datos['domicilio_solicitante']);
$pdf->FilaDatos('Email:', $datos['email_solicitante']);
$pdf->FilaDatos('Teléfono:', $datos['telefono_solicitante']);
$pdf->Ln(5);

// Datos de la inspección
$pdf->TituloSeccion('DATOS DE LA INSPECCIÓN');
$pdf->FilaDatos('Estatus:', $datos['estatus']);
$pdf->FilaDatos('Operación:', $datos['operacion']);
$pdf->FilaDatos('Fecha de Alta:', $datos['fecha_alta']);
$pdf->Ln(5);

// Monto a pagar
$pdf->TituloSeccion('MONTO A PAGAR');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Total a pagar:', 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(140, 10, '$1,500.00 MXN', 1, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, 'MIL QUINIENTOS PESOS 00/100 M.N.', 0, 1, 'C');
$pdf->Ln(5);

// Información de pago
$pdf->TituloSeccion('INFORMACIÓN DE PAGO');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, utf8_decode("El pago debe realizarse en la caja de recaudación municipal presentando este recibo. Una vez realizado el pago, conserve su comprobante y preséntelo para continuar con el trámite de inspección."), 0, 'L');
$pdf->Ln(5);

// Aviso legal
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 4, utf8_decode("Mediante Acuerdo del Cabildo de fecha once de diciembre del dos mil veinticuatro en el punto de acuerdo número VI.3, se autoriza a la Secretaría de Gobierno Municipal para que instrumente el programa de identificación, empadronamiento y regularización de la situación jurídica y administrativa de las personas físicas o morales que se dediquen a la expedición y venta, en envase cerrado y abierto, de bebidas con contenido alcohólico, a fin de que se actualice su situación jurídica. Este documento no implica que se vaya a expedir un permiso nuevo y/o autorizar la regularización de uno previo."), 0, 'J');
$pdf->Ln(10);

// Firmas
$pdf->SetDrawColor(0, 0, 0);
$pdf->Line(40, $pdf->GetY()+20, 80, $pdf->GetY()+20);
$pdf->Line(120, $pdf->GetY()+20, 160, $pdf->GetY()+20);
$pdf->SetXY(40, $pdf->GetY()+22);
$pdf->Cell(40, 5, 'Firma del Solicitante', 0, 0, 'C');
$pdf->SetXY(120, $pdf->GetY());
$pdf->Cell(40, 5, 'Sello', 0, 0, 'C');

// Generar PDF
if ($download_mode) {
    $pdf->Output('D', 'Recibo_Inspeccion_'.$datos['folio'].'.pdf');
} else {
    $pdf->Output('I', 'Recibo_Inspeccion_'.$datos['folio'].'.pdf');
}

// Salir para evitar cualquier salida adicional
exit;
?> 