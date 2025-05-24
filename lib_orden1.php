<?php


function header_pac_auxiliar($estilo_titulo, $site, $subprograma, $row, $id_certificacion){

    //pf($row);

    $estilo_subtitulo1         = 'style="font-weight:bold;text-align:center;font-size:16px"';
    $estilo_subtitulo2         = 'style="font-weight:600;text-align:center;font-size:13px"';
    $estilo_subtitulo2_left    = 'style="font-weight:600;text-align:left;font-size:11px"';
    $estilo_subtitulo2_left_12 = 'style="font-weight:600;text-align:left;font-size:12px"';
    $estilo_subtitulo2_left_ = 'style="font-weight:500;text-align:justify;font-size:8px;text-transform: uppercase;"';
    $estilo_th_reporte1 = 'style="text-align:left;font-size:8px"';
	$tr_reporte_ = 'style="border-bottom:medium solid ;color:#FFF;text-transform: uppercase;background-color:#900;text-align:left;font-size:14px;"';
	$td_reporte_ ='style="border-width: 0 0 1px ;	border-bottom:medium solid #CCC;font-size:12px"';
	$tr_reporte__ = 'style="text-align:justify;font-size:12px;text-transform: uppercase;font-weight:bold"';
	$tr_reporte3 = 'style="text-align:justify;font-size:11px;text-transform: uppercase;font-weight:bold"';

    $texto2 = "<p ".$estilo_subtitulo2_left_.">
    Detalle : 
	</p>";

	$html = "";

    $html .= '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<BODY style="">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td colspan="13" ' . $estilo_subtitulo1 . ' ><img src="images/inicial2.png" width="200" height="100" /></td>
	</tr>
	<tr>
		<td colspan="13" ' . $estilo_subtitulo1 . ' >' . "ORDEN PARA ENTREGA  " . '</td>
	</tr>
	
</table>
<table width="100%" border="1" cellspacing="2" cellpadding="2" left>
	<tr>
        <td colspan="13" ' . $estilo_subtitulo2_left_12 . '  ><b>Fecha Orden : </b>' . $row['FECHA'] . ' </td>
       
    </tr>
	
     <tr>
        <td colspan="2"  ><b>Vendedor </b><br><br><br>' . $row["VENDEDOR"] . '</td>
        <td colspan="11"  ><b>Datos Cliente </b> <br>' . $row["CLIENTE"] . '</td>
        
    </tr>
    
</table>
<table width="100%" border="1" cellspacing="2" cellpadding="2" left>
	<tr>
        <td colspan="13" ' . $estilo_subtitulo1 . '  >DETALLE</td>
       
    </tr>
	
</table>';

    return $html;

}


function header_pac($estilo_titulo, $sitepac, $subprograma, $row, $id_certificacion){

    //pf($row);

    $estilo_subtitulo1         = 'style="font-weight:bold;text-align:center;font-size:16px"';
    $estilo_subtitulo2         = 'style="font-weight:600;text-align:center;font-size:13px"';
    $estilo_subtitulo2_left    = 'style="font-weight:600;text-align:left;font-size:11px"';
    $estilo_subtitulo2_left_12 = 'style="font-weight:600;text-align:left;font-size:12px"';
    $estilo_subtitulo2_left_ = 'style="font-weight:500;text-align:justify;font-size:8px;text-transform: uppercase;"';
    $estilo_th_reporte1 = 'style="text-align:left;font-size:8px"';
	$tr_reporte_ = 'style="border-bottom:medium solid ;color:#FFF;text-transform: uppercase;background-color:#900;text-align:left;font-size:14px;"';
	$td_reporte_ ='style="border-width: 0 0 1px ;	border-bottom:medium solid #CCC;font-size:12px"';
	$tr_reporte__ = 'style="text-align:justify;font-size:12px;text-transform: uppercase;font-weight:bold"';
	$tr_reporte3 = 'style="text-align:justify;font-size:11px;text-transform: uppercase;font-weight:bold"';

    $texto2 = "<p ".$estilo_subtitulo2_left_.">
    A CONTINUACIÓN SE DETALLAN LOS OBJETIVOS, ESTRATEGIAS, SUBPROGRAMA, COMPONENTE Y ACTIVIDAD QUE TIENEN RELACIÓN CON EL GASTO PROPUESTO:
	</p>";

	$justificacion0  = "<p ".$tr_reporte3."> Se solicita que las áreas pertinentes emitan las certificaciones previas que correspondan, para fines de :</p>";

	$justificacion  = "<p ".$estilo_subtitulo2_left_."> PARA DAR INICIO AL PROCESO DE : ".$row['MOTIVO']."</p>";
    $html = "";

    $html .= '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<BODY style="">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td colspan="13" ' . $estilo_subtitulo1 . ' ><img src="images/uta.png" width="100" height="100" /></td>
	</tr>
	<tr>
		<td colspan="13" ' . $estilo_subtitulo1 . ' >' . "SOLICITUD CERTIFICADO DE GASTO " . '</td>
	</tr>
	<tr>
        <td colspan="13" ' . $estilo_subtitulo2 . '  >' . $row['NOMENCLATURA_NUMERO_CERTIFICACION_DIPLEV'] . ' </td>
    </tr>
    <tr>
        <td colspan="13" ' . $estilo_subtitulo2 . '  >' . $row['FECHA'] . ' </td>
    </tr>
	<tr>
		<td colspan="13" ' . $estilo_subtitulo2 . ' >' . $subprograma . '<br><br><br></td>
	</tr>
	<tr>
        <td colspan="13">'.$justificacion0.'</td>
    </tr>
    <tr>
        <td colspan="13" >' . $justificacion . '</td>
    </tr>
	 <tr>
        <td colspan="13"  >' . $texto2 . '</td>
    </tr>

	';

    $html .= '</table>';
    return $html;

}


function detalle_total_pac_for($t_componente)
{
    $html = "";
    $html .= '
		  <tr>
			<td style="font-weight:500"><br />TOTAL</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td ></td>
			<td > </td>
			<td style="font-weight:bold">$' . formato_n2($t_componente) . '</td>
		  </tr>';
    return $html;
}

function detalle_cabezera_pac_for($estilo_th_reporte, $estilo_titulo, $row, $i)
{

	$tr_reporte_ = 'style="border-bottom:medium solid ;color:#FFF;text-transform: uppercase;background-color:#900;text-align:left;font-size:12px;"';

	$td_reporte_ ='style="border-width: 0 0 1px ;	border-bottom:medium solid #CCC;font-size:12px"';

    $estilo_th_reporte1 = 'style="text-align:left;font-size:8px"';
    $estilo_th_reporte3 = 'style="text-align:left;font-size:9px;"';
    $estilo_th_reporte2 = 'style="style="text-align:right;font-size:10px"';

    $estilo_th_reporte_min = 'style="text-align:left;font-size:6px"';
    $html                  = "";

    $html .= '

		<tr>
		    <td colspan="8" ' . $tr_reporte_ . '>1. PLAN ESTRATÉGICO  DE DESARROLLO INSTITUCIONAL :</td>
		</tr>

		<tr>
		    <td  colspan="8"  ' . $estilo_th_reporte1 . '>- OBJETIVO ESTRATÉGICO</td>
		</tr>
		<tr>
		   	<td colspan="8" ' . $estilo_th_reporte1 . '>' . $row['OE_NOMBRE'] . '</td>

		</tr>
		<tr>
		    <td colspan="8"  ' . $estilo_th_reporte1 . '> - OBJETIVO OPERATIVO</td>
		</tr>
		<tr>
		    <td colspan="8" ' . $estilo_th_reporte1 . '>' . $row['OO_NOMBRE'] . '</td>
		</tr>
		<tr>
		    <td colspan="8" ' . $estilo_th_reporte1 . '> - ESTRATEGIA</td>
		</tr>
		<tr>
		    <td colspan="8" ' . $estilo_th_reporte1 . '>' . $row['E_NOMBRE'] . '</td>
		</tr>
		<tr>
		    <td colspan="8" ' . $tr_reporte_ . '>2. PLAN OPERATIVO ANUAL :</td>
		</tr>

		<tr>
		    <td colspan="8" ' . $estilo_th_reporte1 . '> - COMPONENTE : ' . $row['NOMBRE_COMPONENTE'] . '</td>
		</tr>
		<tr>
		    <td colspan="8" ' . $estilo_th_reporte1 . '> - ACTIVIDAD : ' . $row['NOMBRE_ACTIVIDAD'] . '</td>
		</tr>

		';
    //<td class="th_reporte" ' . $estilo_th_reporte1 . '>Indicador</td>
    //    <td colspan="3" ' . $estilo_th_reporte1 . '>' . $row['NOMBRE_INDICADOR'] . '</td>
    //<td class="th_reporte" ' . $estilo_th_reporte1 . '>Item Presupuestario</td>
    //  <td colspan="1" class="th_reporte" ' . $estilo_th_reporte1 . '>Cantidad Solicitada</td>

    $html .= '
	 	<tr>
	 	    <td colspan="3" class="th_reporte" ' . $estilo_th_reporte1 . '>DEPENDENCIA</td>
	 	    <td colspan="3" class="th_reporte" ' . $estilo_th_reporte1 . '>DESCRIPCIÓN</td>
	 	    <td colspan="3" class="th_reporte" ' . $estilo_th_reporte1 . '>VALOR PLANIFICADO (USD)</td>
	 	</tr>';
    return $html;
}

function detalle_cabezera_pac_for2($estilo_th_reporte, $estilo_titulo, $row)
{
    $estilo_th_reporte1 = 'style="text-align:left;font-size:8px"';
    $estilo_th_reporte3 = 'style="text-align:left;font-size:9px;"';
    $estilo_th_reporte2 = 'style="style="text-align:right;font-size:10px"';

    $estilo_th_reporte_min = 'style="text-align:left;font-size:6px"';
    $html                  = "";

    $html .= '
		<tr>
			<td colspan="4" class="th_reporte" ' . $estilo_th_reporte1 . '>Colección</td>
		    <td colspan="4" class="th_reporte" ' . $estilo_th_reporte1 . '>Pedido</td>
		    

		</tr>';

    return $html;
}
function detalle_cuerpo_pac_for($estilo_td_reporte, $estilo_td_reporte_r, $row)
{

    $estilo_td_reporte1 = 'style="text-align:right;font-size:10px;border-bottom:medium solid ;"';

    //    <td colspan="1"  ' . $estilo_td_reporte1 . '> ' . round($row['SOLICITADO_CANTIDAD'], 2) . '</td>

    //<td ' . $estilo_td_reporte . '>' . $row['ITEM_PRESUPUESTARIO'] . '</td>
    $html = "";
    $html .= '
		<tr>
		    <td colspan="3" ' . $estilo_td_reporte . '>' . $row['DATO_DEPENDENCIA_REPORTE1'] . '</td>

		    <td colspan="2" ' . $estilo_td_reporte . '> ' . $row['DESCRIPCION'] . '</td>
		    <td colspan="3" ' . $estilo_td_reporte1 . '> $ ' . formato_n2($row['SOLICITADO']) . '</td>



		</tr>';

    return $html;
}

function detalle_cuerpo_pac_for2($estilo_td_reporte, $estilo_td_reporte_r, $row)
{

    $estilo_td_reporte1 = 'style="text-align:right;font-size:10px;border-bottom:medium solid ;"';
    $html               = "";
    $html .= '
		<tr>
			<td colspan="4" ' . $estilo_td_reporte . '>' . $row['COLECCION'] . '</td>
		    <td colspan="4" ' . $estilo_td_reporte . '>' . $row['PEDIDO'] . '</td>
		    
		</tr>';

    return $html;
}

function total_pac_for($t_componente, $t_total)
{
    $estilo_td_reporte1 = 'style="text-align:right;font-size:10px;border-bottom:medium solid ;"';

    $html  = "";
    $html2 = "";
    $html .= '
	<tr>
	<td class="th_reporte">TOTAL</td>
	<td  colspan="6" class="th_reporte">$ </td>
	<td class="th_reporte" ' . $estilo_td_reporte1 . '>' . formato_n2($t_componente) . ' </td>
	</tr>

	</table>';

    return $html;
}

function pie_for_pac($sw, $row,$row3){

	
	//pf($row3,1);

    //La presente certificación es emitida por la Unidad de Planificación en cumplimiento con las normativas establecidas, certificando que el gasto propuesto se encuentra alineado con la planificación institucional aprobada.

    $html = "";

    //pf($row);

    $estilo_subtitulo1      = 'style="font-weight:bold;text-align:center;font-size:16px"';
    $estilo_subtitulo1_      = 'style="font-weight:500;text-align:center;font-size:16px"';
    
    $estilo_subtitulo2      = 'style="font-weight:600;text-align:center;font-size:13px"';
    $estilo_subtitulo2_left = 'style="font-weight:600;text-align:left;font-size:11px"';
    $estilo_subtitulo2_left2 = 'style="font-weight:bold;text-align:left;font-size:11px"';

    $estilo_subtitulo2_left_ = 'style="font-weight:500;text-align:justify;font-size:11px"';


      // $estilo_subtitulo1         = 'style="font-weight:bold;text-align:center;font-size:16px"';
    // $estilo_subtitulo2         = 'style="font-weight:600;text-align:center;font-size:13px"';
    // $estilo_subtitulo2_left    = 'style="font-weight:600;text-align:left;font-size:11px"';
    // $estilo_subtitulo2_left_12 = 'style="font-weight:600;text-align:left;font-size:12px"';
    // $estilo_subtitulo2_left_ = 'style="font-weight:500;text-align:justify;font-size:8px;text-transform: uppercase;"';
     $estilo_th_reporte1 = 'style="text-align:left;font-size:8px;"';
	 $tr_reporte_ = 'style="border-bottom:medium solid ;color:#FFF;text-transform: uppercase;background-color:#900;text-align:left;font-size:14px;"';
	 $td_reporte_ ='style="border-width: 0 0 1px ;	border-bottom:medium solid #CCC;font-size:12px"';
	 $tr_reporte__ = 'style="text-align:justify;font-size:12px;text-transform: uppercase;font-weight:bold"';
	 $tr_reporte3 = 'style="text-align:center;font-size:11px;text-transform: uppercase;font-weight:bold"';

	 $tr_reporte4 = 'style="text-align:center;font-size:10px;text-transform: uppercase;font-weight:600"';

	$tr_reporte5 = 'style="text-align:justify;font-size:11px;text-transform: none;font-weight:600"';

	$titulo_planificacion = "
	<p ". $tr_reporte5 . ">
	En cumplimiento de la Normativa del Sistema Nacional de Finanzas Públicas, Norma Técnica de Presupuesto, relativa a los autorizadores de gasto y pago, que forman parte del control interno previo; y, en uso de las atribuciones conferidas en el Estatuto de la Universidad Técnica de Ambato, que nos permite evaluar el cumplimiento de la planificación institucional; se CERTIFICA QUE: 
		<br>
El gasto detallado que antecede a esta certificación, está relacionado con la misión de la entidad; y, las acciones contempladas en el presente requerimiento.
	</p>
	";

   
    if ($sw == 0) {
        $html .= '<br>
		<table width="100%" border="1" cellspacing="5" cellpadding="5" >

		<tr >
			<td  colspan="8" '.$estilo_subtitulo1.'>GENERADOR POR </td>
			
		</tr>
		
		<tr >
			<td  colspan="8" '.$estilo_subtitulo1.'>___________________</td>
			
		</tr>
	
		<tr >
			<td  colspan="8" '.$estilo_subtitulo1_.'>'.$row["VENDEDOR"].'</td>
			
		</tr>';

        $html .= '</table>';
    }
    $html .= '</BODY></HTML>';

    return $html;

}

function pie_revision($sw, $row,$row3){
	
	//pf($row3,1);
	//pf($row3["INOMBRE_OPERADOR"],0);

	 $estilo_subtitulo1      = 'style="font-weight:bold;text-align:center;font-size:16px"';
    $estilo_subtitulo2      = 'style="font-weight:600;text-align:center;font-size:13px"';
    $estilo_subtitulo2_left = 'style="font-weight:600;text-align:left;font-size:10px"';
    $estilo_subtitulo2_left2 = 'style="font-weight:bold;text-align:left;font-size:10px"';



    // $estilo_subtitulo1         = 'style="font-weight:bold;text-align:center;font-size:16px"';
    // $estilo_subtitulo2         = 'style="font-weight:600;text-align:center;font-size:13px"';
    // $estilo_subtitulo2_left    = 'style="font-weight:600;text-align:left;font-size:11px"';
    // $estilo_subtitulo2_left_12 = 'style="font-weight:600;text-align:left;font-size:12px"';
    // $estilo_subtitulo2_left_ = 'style="font-weight:500;text-align:justify;font-size:8px;text-transform: uppercase;"';
     $estilo_th_reporte1 = 'style="text-align:left;font-size:8px;"';
	 $tr_reporte_ = 'style="border-bottom:medium solid ;color:#FFF;text-transform: uppercase;background-color:#900;text-align:left;font-size:14px;"';
	 $td_reporte_ ='style="border-width: 0 0 1px ;	border-bottom:medium solid #CCC;font-size:12px"';
	 $tr_reporte__ = 'style="text-align:justify;font-size:12px;text-transform: uppercase;font-weight:bold"';
	 $tr_reporte3 = 'style="text-align:center;font-size:11px;text-transform: uppercase;font-weight:bold"';


    $html = "";

    if ($sw == 0) {
        $html .= '
	    <p '.$tr_reporte3.'></p>
		<table width="100%" border="1" cellspacing="10" cellpadding="10">


		<tr >
			<td  colspan="2" '.$estilo_subtitulo2_left2.'></td>
			<td  colspan="2" '.$estilo_subtitulo2_left2.'>NOMBRE</td>
			<td  colspan="2" '.$estilo_subtitulo2_left2.'>CARGO</td>
			<td  colspan="2" '.$estilo_subtitulo2_left2.'>FIRMA</td>
		</tr>
		<tr >
			<td  colspan="2" '.$estilo_subtitulo2_left.'>Elaborado por</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>'.$row3["INOMBRE_OPERADOR"].'</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>Funcionario responsable del POA o PAC de la Unidad Administrativa/Académica</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>_______________</td>
		</tr>
		<tr >
			<td  colspan="2" '.$estilo_subtitulo2_left.'>Validado por</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>'.$row3["INOMBRE_APROBADOR"].'</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>Director/a - Decano/a</td>
			<td  colspan="2" '.$estilo_subtitulo2_left.'>_______________</td>
		</tr>
		';

        $html .= '</table><br><br>';
    }
    //$html .= '</BODY></HTML>';

    return $html;

}
