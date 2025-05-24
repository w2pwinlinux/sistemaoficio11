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
            $id_orden = isset($_REQUEST["id_orden"]) ? vd($_REQUEST["id_orden"], "int") : vd(-1, "int");

            $filtros = isset($_REQUEST["FILTRO"]) ? $_REQUEST["FILTRO"] : '';

            //$PARAM_ID_SUBPROGRAMA = vd($_SESSION["codigosp"], "int");

            if ($report == 1) {
                $filtros = b64d($filtros);
            }
            $SQLFiltro = filtroDinamico($filtros);
            $SQL_TOTAL = "
            SELECT COUNT[[*]] as TOTAL_ROW
             FROM Q_ORDEN_DETALLE
            WHERE 1= 1  AND Q_ORDEN_ID = $id_orden";

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT *,
             F_COLECCION_DATOS_PEDIDO(ID) AS DATOS,
            F_COLECCION_STOCK_PEDIDO(ID) AS PEDIDO
            FROM Q_ORDEN_DETALLE
            WHERE 1= 1  AND Q_ORDEN_ID = $id_orden";

            $SQL .= $SQLFiltro;
            $SQL .= " ORDER BY CREATED DESC ";
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
                            "ID", 0, "NOMBRE", 1, "CIUDAD", 2, "DIRECCION", 3, "TELEFONO", 4,
                            "CORREO", 5, "TIPO", 6, "CREADO", 7,
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
                            "ID", 0, "NOMBRE", 1, "CIUDAD", 2, "DIRECCION", 3, "TELEFONO", 4,
                            "CORREO", 5, "TIPO", 6, "CREADO", 7,
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
            //pf($_FILES, 0);

            $sw_file = 0;
            /** validar q tenga tamaño el anexo*/
            if (true) {

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

                $PARAM_ID_ORDEN     = vd($_REQUEST["id_orden"], "int");
                $PARAM_ID_COLECCION = vd($_REQUEST["ID"], "int");

                $SQL = "SP_SELECT_Q_ORDEN_DETALLE_INSERT(
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
                        $PARAM_ID_ORDEN,
                        $PARAM_ID_COLECCION,
                        $PARAM_LOGIN
                    )";
                $cn->execute($SQL, 0);

                //echo ($cn->mensaje());

                //exit();

                if ($cn->filas_afectada() > 0) {
                    $cc                      = $cn->datos();
                    $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                    $matriz["mensaje"]       = $cc[0]["MENSAJE"];
                } else {
                    $matriz["fila_afectada"] = -1;

                    $matriz["mensaje"] = $cn->mensaje();
                }

            }

            echo json_encode($matriz);
            break;

        case 3:
            
            //pf($_REQUEST, 0);

            $PARAM_TALLA26 = vd($_REQUEST["TALLA26"], "double");
            $PARAM_TALLA28 = vd($_REQUEST["TALLA28"], "double");
            $PARAM_TALLA30 = vd($_REQUEST["TALLA30"], "double");
            $PARAM_TALLA32 = vd($_REQUEST["TALLA32"], "double");
            $PARAM_TALLA34 = vd($_REQUEST["TALLA34"], "double");
            $PARAM_TALLA36 = vd($_REQUEST["TALLA36"], "double");
            $PARAM_TALLA38 = vd($_REQUEST["TALLA38"], "double");
            $PARAM_TALLA40 = vd($_REQUEST["TALLA40"], "double");
            $PARAM_TALLA42 = vd($_REQUEST["TALLA42"], "double");
            $PARAM_TALLA44 = vd($_REQUEST["TALLA44"], "double");


            $PARAM_LOGIN = $user_vd;

            $PARAM_ID_ORDEN = vd($_REQUEST["id_orden"], "int");

            $sql = "SP_SELECT_Q_ORDEN_DETALLE_UPDATE(

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
                        $PARAM_ID_ORDEN
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

            $SQL = "SP_SELECT_ORDEN_DETALLE_ELIMINAR(
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
