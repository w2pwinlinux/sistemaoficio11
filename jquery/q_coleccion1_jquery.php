<?php
require_once 'autoload.php';

if (isset($_REQUEST["opcion"])) {
    $opcion = $_REQUEST["opcion"];

    switch ($opcion) {
        case 99: //SELECCION DE DATOS

            //pf($_REQUEST,1);

            $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
            $ROWS = isset($_REQUEST["rows"]) ? intval($_REQUEST["rows"]) : 25;

            $report = isset($_REQUEST["report"]) ? intval($_REQUEST["report"]) : 0;
            $DESDE  = ($page - 1) * $ROWS;

            $dinamico = isset($_REQUEST["dinamico"]) ? intval($_REQUEST["dinamico"]) : 0;

            //$estado_pac_revision = isset($_REQUEST["estado_global_estado"]) ? vd($_REQUEST["estado_global_estado"], "text") : vd("APROBADO", "text");
            //$tipo_solicitud      = isset($_REQUEST["tipo_solicitud"]) ? vd($_REQUEST["tipo_solicitud"], "text") : vd("BIEN", "text");

            $filtros = isset($_REQUEST["FILTRO"]) ? $_REQUEST["FILTRO"] : '';

            //$PARAM_ID_SUBPROGRAMA = vd($_SESSION["codigosp"], "int");

            if ($report == 1) {
                $filtros = b64d($filtros);
            }
            $SQLFiltro = filtroDinamico($filtros);
            $SQL_TOTAL = "
            SELECT COUNT[[*]] as TOTAL_ROW
             FROM Q_COLECCION
            WHERE 1= 1  ";

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT
            ID,
            REFERENCIA,
            ID_TIPO,
            ID_TIPO_COLECCION,
            ID_MARCA,
            F_COLECCION_DATOS(ID) AS DATOS,
            F_COLECCION_STOCK(ID) AS STOCK,
            
            DESCRIPCION,
            COLOR,
            
            TALLA26,
            TALLA28,
            TALLA30,
            TALLA32,
            TALLA34,
            TALLA36,
            TALLA38,
            TALLA40,
            TALLA42,
            TALLA44,
            TALLA46,
            TOTAL,
            ANEXO1,
            ESTADO,
            REGISTRA,
            CREATED,
            MODIFIED

            FROM Q_COLECCION
            WHERE 1= 1
            ";

            $SQL .= $SQLFiltro;
            $SQL .= " ORDER BY CREATED ASC ";
            if ($dinamico == 0) {
                $SQL .= " limit $DESDE,$ROWS";
            }

            $cn->execute($SQL, 2);
            if ($cn->filas_afectada() > 0) {
                if ($dinamico == 0) {
                    if ($report == 1) {
                        $matriz_columnas = array();
//                 MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "ID", 0, "TIPO", 1, "COLECCION", 2, "MARCA", 3, "REFERENCIA", 4,
                            "DESCRIPCION", 5, "COLOR", 6, "DATOS", 7, "STOCK", 8,
                        );

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                } else {
                    if ($report == 1) {
                        $matriz_columnas = array();
                        //                    MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "ID", 0, "TIPO", 1, "COLECCION", 2, "MARCA", 3, "REFERENCIA", 4,
                            "DESCRIPCION", 5, "COLOR", 6, "DATOS", 7, "STOCK", 8,
                        );
                        

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                        //$matriz = remove_columnas_array($matriz_columnas, $dd);

                        //tablas($matriz);exit();

                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                }
            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;

        case 991: //SELECCION DE DATOS

            //pf($_REQUEST,1);

            $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
            $ROWS = isset($_REQUEST["rows"]) ? intval($_REQUEST["rows"]) : 25;

            $report = isset($_REQUEST["report"]) ? intval($_REQUEST["report"]) : 0;
            $DESDE  = ($page - 1) * $ROWS;

            $dinamico = isset($_REQUEST["dinamico"]) ? intval($_REQUEST["dinamico"]) : 0;

            $edit = isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : 0;

            //$estado_pac_revision = isset($_REQUEST["estado_global_estado"]) ? vd($_REQUEST["estado_global_estado"], "text") : vd("APROBADO", "text");
            //$tipo_solicitud      = isset($_REQUEST["tipo_solicitud"]) ? vd($_REQUEST["tipo_solicitud"], "text") : vd("BIEN", "text");

            $filtros = isset($_REQUEST["FILTRO"]) ? $_REQUEST["FILTRO"] : '';

            //$PARAM_ID_SUBPROGRAMA = vd($_SESSION["codigosp"], "int");

            if ($report == 1) {
                $filtros = b64d($filtros);
            }
            $SQLFiltro = filtroDinamico($filtros);
            $SQL_TOTAL = "
            SELECT COUNT[[*]] as TOTAL_ROW
             FROM Q_COLECCION
            WHERE 1= 1  AND ESTADO = 1";

            if ($edit>0){
                $id_coleccion_edit = vd($_REQUEST['id_coleccion_edit'],"int");

                $SQL_TOTAL .=" AND ID = $id_coleccion_edit";
            }

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT *,
            F_COLECCION_DATOS   (ID) AS DATOS,
            F_COLECCION_STOCK(ID) AS STOCK
            FROM Q_COLECCION
            WHERE 1= 1 AND ESTADO = 1 ";

            if ($edit>0){
                $id_coleccion_edit = vd($_REQUEST['id_coleccion_edit'],"int");

                $SQL .=" AND ID = $id_coleccion_edit";
            }


            $SQL .= $SQLFiltro;
            $SQL .= " ORDER BY CREATED ASC ";
            if ($dinamico == 0) {
                $SQL .= " limit $DESDE,$ROWS";
            }

            $cn->execute($SQL, 2);
            if ($cn->filas_afectada() > 0) {
                if ($dinamico == 0) {
                    if ($report == 1) {
                        $matriz_columnas = array();
//                 MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "ID", 0, "TIPO", 1, "COLECCION", 2, "MARCA", 3, "REFERENCIA", 4,
                            "DESCRIPCION", 5, "COLOR", 6,
                        );

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                } else {
                    if ($report == 1) {
                        $matriz_columnas = array();
                        //                    MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "ID", 0, "TIPO", 1, "COLECCION", 2, "MARCA", 3, "REFERENCIA", 4,
                            "DESCRIPCION", 5, "COLOR", 6,
                        );

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                }
            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;

        case 1:

            //pf($_REQUEST);
            //pf($_FILES,1);

            $sw_file = 0;
            /** validar q tenga tamaño el anexo*/
            if ($_FILES['ANEXO1']["size"] > 0) {

                switch ($_FILES['ANEXO1']['type']) {
                    case 'image/jpeg':
                        $extension = '.JPEG';
                        $sw_file   = 1;

                        break;
                    case 'image/png':
                        $extension = '.PNG';
                        $sw_file   = 1;
                        break;

                    default:
                        $extension = '..';
                        $sw_file   = 0;
                }

                if ($sw_file == 1) {
                    $temporary_location = $_FILES['ANEXO1']['tmp_name'];

                    $file_path  = '../COLECCION/';
                    $file_path2 = 'COLECCION/';

                    $file_name = "IMAGEN_" . time() . $extension;

                    $PARAM_EVIDENCIA = $file_path . $file_name;

                    $PARAM_ANEXO1_VD = vd($file_path2 . $file_name, "text");

                    if (move_uploaded_file($temporary_location, $PARAM_EVIDENCIA)) {

                    }

                    $PARAM_COLECCION = vd($_REQUEST["COLECCION"], "text");
                    $PARAM_TIPO      = vd($_REQUEST["TIPO"], "text");

                    $PARAM_MARCA = vd($_REQUEST["MARCA"], "text");

                    $PARAM_REFERENCIA  = vd($_REQUEST["REFERENCIA"], "text");
                    $PARAM_DESCRIPCION = vd($_REQUEST["DESCRIPCION"], "text");
                    $PARAM_COLOR       = vd($_REQUEST["COLOR"], "text");
                    $PARAM_TALLA26     = vd($_REQUEST["TALLA26"], "double");
                    $PARAM_TALLA28     = vd($_REQUEST["TALLA28"], "double");
                    $PARAM_TALLA30     = vd($_REQUEST["TALLA30"], "double");
                    $PARAM_TALLA32     = vd($_REQUEST["TALLA32"], "double");
                    $PARAM_TALLA34     = vd($_REQUEST["TALLA34"], "double");
                    $PARAM_TALLA36     = vd($_REQUEST["TALLA36"], "double");
                    $PARAM_TALLA38     = vd($_REQUEST["TALLA38"], "double");
                    $PARAM_TALLA40     = vd($_REQUEST["TALLA40"], "double");
                    $PARAM_TALLA42     = vd($_REQUEST["TALLA42"], "double");
                    $PARAM_TALLA44     = vd($_REQUEST["TALLA44"], "double");

                    $PARAM_LOGIN = $user_vd;

                    $sql = "SP_SELECT_Q_COLECCION_INSERT(
                        $PARAM_COLECCION,
                        $PARAM_TIPO,
                        $PARAM_MARCA,
                        $PARAM_REFERENCIA,
                        $PARAM_DESCRIPCION,
                        $PARAM_COLOR,
                        $PARAM_TALLA26,
                        $PARAM_TALLA28,
                        $PARAM_TALLA30,
                        $PARAM_TALLA32,
                        $PARAM_TALLA34,
                        $PARAM_TALLA36,
                        $PARAM_TALLA38,
                        $PARAM_TALLA40,
                        $PARAM_TALLA42,
                        $PARAM_TALLA44,
                        $PARAM_LOGIN,
                        $PARAM_ANEXO1_VD
                    )";
                    $cn->execute($sql, 0);

                    if ($cn->filas_afectada() > 0) {
                        $cc                      = $cn->datos();
                        $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                        $matriz["mensaje"]       = $cc[0]["MENSAJE"];
                    } else {
                        $matriz["fila_afectada"] = -1;

                        $matriz["mensaje"] = $cn->mensaje();
                    }

                } else {

                    $matriz["fila_afectada"] = -1;

                    $matriz["mensaje"] = "EXTENSION NO VALIDA DE IMAGEN";

                }

            } else {
                $matriz["fila_afectada"] = -1;
                $matriz["mensaje"]       = "DEBE ENVIAR UN ANEXO VALIDO";
            }

            echo json_encode($matriz);
            break;

        case 3:

            //pf($_REQUEST);
            //pf($_FILES, 0);

            $sw_file = 0;
            /** validar q tenga tamaño el anexo*/
            if ($_FILES['ANEXO1']["size"] > 0) {

                switch ($_FILES['ANEXO1']['type']) {
                    case 'image/jpeg':
                        $extension = '.JPEG';
                        $sw_file   = 1;

                        break;
                    case 'image/png':
                        $extension = '.PNG';
                        $sw_file   = 1;
                        break;

                    default:
                        $extension = '..';
                        $sw_file   = 0;
                }

                if ($sw_file == 1) {
                    $temporary_location = $_FILES['ANEXO1']['tmp_name'];

                    $file_path  = '../COLECCION/';
                    $file_path2 = 'COLECCION/';

                    $file_name = "IMAGEN_" . time() . $extension;

                    $PARAM_EVIDENCIA = $file_path . $file_name;

                    $PARAM_ANEXO1_VD = vd($file_path2 . $file_name, "text");

                    if (move_uploaded_file($temporary_location, $PARAM_EVIDENCIA)) {

                    }
                    //$update_anexo1 = 1;
                }
            }

            if ($sw_file == 0) {
                $PARAM_ANEXO1_VD = vd("_", "text");

            }
            $PARAM_ID = vd($_REQUEST["id"], "int");

            $PARAM_COLECCION = vd($_REQUEST["COLECCION"], "text");
            $PARAM_TIPO      = vd($_REQUEST["TIPO"], "text");

            $PARAM_MARCA = vd($_REQUEST["MARCA"], "text");

            $PARAM_REFERENCIA  = vd($_REQUEST["REFERENCIA"], "text");
            $PARAM_DESCRIPCION = vd($_REQUEST["DESCRIPCION"], "text");
            $PARAM_COLOR       = vd($_REQUEST["COLOR"], "text");
            $PARAM_TALLA26     = vd($_REQUEST["TALLA26"], "double");
            $PARAM_TALLA28     = vd($_REQUEST["TALLA28"], "double");
            $PARAM_TALLA30     = vd($_REQUEST["TALLA30"], "double");
            $PARAM_TALLA32     = vd($_REQUEST["TALLA32"], "double");
            $PARAM_TALLA34     = vd($_REQUEST["TALLA34"], "double");
            $PARAM_TALLA36     = vd($_REQUEST["TALLA36"], "double");
            $PARAM_TALLA38     = vd($_REQUEST["TALLA38"], "double");
            $PARAM_TALLA40     = vd($_REQUEST["TALLA40"], "double");
            $PARAM_TALLA42     = vd($_REQUEST["TALLA42"], "double");
            $PARAM_TALLA44     = vd($_REQUEST["TALLA44"], "double");

            $PARAM_LOGIN = $user_vd;

            $sql = "SP_SELECT_Q_COLECCION_UPDATE(
                        $PARAM_COLECCION,
                        $PARAM_TIPO,
                        $PARAM_MARCA,
                        $PARAM_REFERENCIA,
                        $PARAM_DESCRIPCION,
                        $PARAM_COLOR,
                        $PARAM_TALLA26,
                        $PARAM_TALLA28,
                        $PARAM_TALLA30,
                        $PARAM_TALLA32,
                        $PARAM_TALLA34,
                        $PARAM_TALLA36,
                        $PARAM_TALLA38,
                        $PARAM_TALLA40,
                        $PARAM_TALLA42,
                        $PARAM_TALLA44,
                        $PARAM_ANEXO1_VD,
                        $PARAM_ID
                    )";
            $cn->execute($sql, 0);

            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];
            } else {
                $matriz["fila_afectada"] = -1;

                $matriz["mensaje"] = $cn->mensaje();
            }

            echo json_encode($matriz);
            break;

        case 11:

            //pf($_REQUEST,1);
            //pf($_FILES, 0);

            $PARAM_ID     = vd($_REQUEST["ID"], "int");
            $PARAM_ESTADO = vd($_REQUEST["ESTADO"], "int");

            $SQL = "SP_SELECT_Q_COLECCION_UPDATE_ESTADO(
            $PARAM_ID,
            $PARAM_ESTADO
            )";
            $cn->execute($SQL, 0);
            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];

            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;
    }
}
