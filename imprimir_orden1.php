<?php
// ver lo de las firmas
require_once 'lib_autoload.php';
require_once 'lib_orden1.php';

//exit("FORMATO EN PROCESO DE REVISION EN LA DIRECCION DE PLANIFICACION");
$sw = 0;

//pf($_REQUEST,0);

$id_orden = isset($_REQUEST['dd']) ? $_REQUEST['dd'] : -1;

$id_orden = base64_decode($id_orden);

//pf($id_orden,0);

/** VERICICAR PARA GENERAR O MOSTRAR EL PDF*/


$ruta =  __DIR__ . '/ORDEN/'.$id_orden.'_GENERADO.PDF';
$ruta_bdd =  vd('/ORDEN/'.$id_orden.'_GENERADO.PDF',"text");

/**
if (file_exists($ruta)) {
    if (is_readable($ruta)) {
        
        //exit($ruta);


        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . basename($ruta) . "\"");
        header("Content-Length: " . filesize($ruta));

        // Leer y enviar el archivo al navegador
        readfile($ruta);
        exit;   
    }
}
*/


$PARAM_ID_USUARIO = vd($_SESSION["user"], "text");

$PARAM_ID_USUARIO = vd($_SESSION["user"], "text");
$PARAM_NIVEL      = vd($_SESSION["level"], "text");



if ($id_orden > 0) {

        $SQL  = "SP_SELECT_REPORTE_ORDEN1($id_orden)";
 
  
    //$cn->execute($SQL0, 0);
} else {
    exit("DATOS INCORRECTOS");
}

$cn->execute($SQL, 0);
if ($cn->filas_afectada() > 0) {
    $_matriz = $cn->datos();

    for ($i=0; $i <count($_matriz) ; $i++) { 
        // code...
    }
   
} else {
    exit("NO EXISTE DATOS PARA EL REPORTE, VERIFIQUE LOS ESTADOS DEL PROCESO");
}
//pf($_matriz,1);
//tablas($_matriz);exit();

$total_global = 0;

$estilo_th_reporte = 'style="font-weight:bold;text-align:left;font-size:10px"';

$estilo_th_reporte1 = 'style="text-align:left;font-size:8px"';

$estilo_th_reporte2 = 'style="text-align:right;font-size:8px"';

$estilo_td_reporte   = 'style="text-align:left;font-size:10px;border-bottom:medium solid ;"';
$estilo_td_reporte_r = 'style="text-align:right;font-size:10px;border-bottom:medium solid ;"';
$estilo_titulo       = 'style="font-weight:bold;text-align:center;font-size:25px;"';
$estilo_subtitulo1   = 'style="font-weight:bold;text-align:center;font-size:20px"';

$html    = "";
$header  = "";
$detalle = "";
$pie     = "";
/** ENVIO PARA CABEZETA */

$line_limit         = 25; // Número máximo de líneas por página
$line_limit2        = 18; // Número máximo de líneas por página
$current_line_count = 0; // Contador de líneas actual
$page               = 0;


$SITE = "OFICIO11 DENIM";
$subprograma = $_matriz[0]["NOMBRE_SUBPROGRAMA"];
$header .= header_pac_auxiliar($estilo_titulo, $SITE,$SITE, $_matriz[0], $id_orden);
/**
$current_line_count += 6;

$idc          = $_matriz[0]['ID_COMPONENTE'];
$nuevo        = 1;
$t_componente = 0;
$t_total      = 0;


$detalle .= '<table width="100%" border="0" cellspacing="5" cellpadding="0">';

for ($i = 0; $i < count($_matriz); $i++) {
    if (($_matriz[$i]['ID_COMPONENTE']) == $idc) {
        $nuevo = 0;
    } else {
        //echo "nuevo<br>";
        $nuevo = 1;
        $idc   = $_matriz[$i]['ID_COMPONENTE'];
    }
    if ($i == 0) {$nuevo = 1;}
    //if ($i == 0) {$nuevo = 1;} else { $nuevo = 0;}

    if ($nuevo == 1) {
        if ($i != 0) {
            //echo "nueva cabecera";
            
            $detalle .= detalle_total_pac_for($t_componente);
            
            $t_total += $t_componente;
            $t_componente = 0;
            $current_line_count++;

        }
   
        $detalle .= detalle_cabezera_pac_for($estilo_th_reporte, $estilo_titulo, $_matriz[$i],$i );
        $current_line_count += 4;
    }
    $t_componente += floatval($_matriz[$i]['SOLICITADO']);

    $detalle .= detalle_cuerpo_pac_for($estilo_td_reporte, $estilo_td_reporte_r, $_matriz[$i]);
    $current_line_count++;

    //$detalle .= detalle_cuerpo_pac_for($estilo_td_reporte, $estilo_td_reporte_r, $_matriz[$i]);
    //$current_line_count++;

    //$detalle .= detalle_cuerpo_pac_for($estilo_td_reporte, $estilo_td_reporte_r, $_matriz[$i]);
    //$current_line_count++;

    if ($current_line_count >= $line_limit) {
        $detalle .= '<div style="page-break-after: always;"></div>'; // Salto de página
        $current_line_count = 0; //Reinicia el contador

    }

    //echo "lazo : " . $current_line_count . "<br>";

}

$t_total += $t_componente;
$detalle .= total_pac_for($t_componente, $t_total);


$current_line_count++;

/** */
//$idc          = $_matriz[0]['ID_COMPONENTE'];
// $nuevo        = 1;
// $t_componente = 0;
// $t_total      = 0;


 $detalle .= '<table width="100%" border="1" cellspacing="5" cellpadding="0">';

 for ($i = 0; $i < count($_matriz); $i++) {
    
     if ($i == 0) {$nuevo = 1;}
     if ($nuevo == 1) {
         if ($i != 0) {
            


             //$detalle .= detalle_total_pac_for($t_componente);
             //$t_total += $t_componente;
             //$t_componente = 0;
             $current_line_count++;

         }
         /** LLAMADA encabezado del  DETALLE */
         $detalle .= detalle_cabezera_pac_for2($estilo_th_reporte, $estilo_titulo, $_matriz[$i]);
         $current_line_count += 4;
     }
     //$t_componente += floatval($_matriz2[$i]['SOLICITADO']);

     $detalle .= detalle_cuerpo_pac_for2($estilo_td_reporte, $estilo_td_reporte_r, $_matriz[$i]);
     $current_line_count++;

    
     if ($current_line_count >= $line_limit) {
         $detalle .= '<div style="page-break-after: always;"></div>'; // Salto de página
         $current_line_count = 0; //Reinicia el contador

     }

 //    echo "lazo : " . $current_line_count . "<br>";

 }


 $detalle .= '</table>';

 //$t_total += $t_componente;
 //$detalle .= total_pac_for($t_componente, $t_total);
 $current_line_count++;


$pie = "";
$current_line_count += 4;

//echo "final +4: " . $current_line_count;
if ($current_line_count >= $line_limit) {
    $pie .= '<div style="page-break-after: always;"></div>'; // Salto de página
}


//$pie .= pie_revision($sw, $_matriz[0],$_matriz3[0]);// current_line_count,line_limit
$pie .= pie_for_pac($sw, $_matriz[0],$_matriz[0]);
//$pie = "";
$html = $header . $detalle . $pie;
$tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : "pdf";

//var_dump($header);exit();



$tipo = "pdf"; 
tipo_reportes($tipo, $html);exit();

