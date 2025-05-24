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
             FROM Q_ORDEN
            WHERE 1= 1  ";

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";
            if ($level == "9" or $level == "Z") {

            } else {
                $SQL_TOTAL .= " AND Q_USUARIO_LOGIN = $user_vd";
            }

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT ID,Q_USUARIO_LOGIN,
            CONCAT('Nombre: ',Q_CLIENTE_NOMBRE,'<br>Ciudad: ',Q_CLIENTE_CIUDAD,'<br>Dirección: ',Q_CLIENTE_DIRECCION) AS DATOS,
            FECHA,ESTADO,CREATED

            -- F_COLECCION_DATOS(ID) AS DATOS,
            -- F_COLECCION_STOCK(ID) AS STOCK,

            FROM Q_ORDEN
            WHERE 1= 1
            ";

            if ($level == "9" or $level == "Z") {

            } else {
                $SQL .= " AND Q_USUARIO_LOGIN = $user_vd";
            }
            $SQL .= $SQLFiltro;
            $SQL .= " ORDER BY CREATED DESC ";
            if ($dinamico == 0) {
                $SQL .= " limit $DESDE,$ROWS";
            }

            //echo $level."<br>";
            $cn->execute($SQL, 2);
            if ($cn->filas_afectada() > 0) {
                if ($dinamico == 0) {
                    if ($report == 1) {
                        $matriz_columnas = array();
//                 MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "ID", 0, "VENDEDOR", 1, "CLIENTE", 2, "FECHA", 3, "ESTADO", 4, "CREADO", 5,
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
                            "ID", 0, "VENDEDOR", 1, "CLIENTE", 2, "FECHA", 3, "ESTADO", 4, "CREADO", 5,
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

            //pf($_REQUEST,1);

            /** validar q tenga tamaño el anexo*/
            if (true) {

                $PARAM_FECHA        = vd($_REQUEST["FECHA"], "text");
                $PARAM_ID_Q_CLIENTE = vd($_REQUEST["Q_CLIENTE_NOMBRE"], "int");

                $PARAM_Q_USUARIO_LOGIN = $user_vd;

                $sql = "SP_SELECT_Q_ORDEN_INSERT(
                        $PARAM_Q_USUARIO_LOGIN,
                        $PARAM_ID_Q_CLIENTE,
                        $PARAM_FECHA
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

            }

            echo json_encode($matriz);
            break;

        case 3:

            //pf($_REQUEST,1);
            if (true) {

                $PARAM_FECHA        = vd($_REQUEST["FECHA"], "text");
                $PARAM_ID_Q_CLIENTE = vd($_REQUEST["Q_CLIENTE_NOMBRE"], "int");

                $PARAM_ID = vd($_REQUEST["id"], "int");

                $sql = "SP_SELECT_Q_ORDEN_UPDATE(
                        $PARAM_ID_Q_CLIENTE,
                        $PARAM_FECHA,
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

            }
            echo json_encode($matriz);
            break;

        case 11:

            //pf($_REQUEST,1);
            //pf($_FILES, 0);

            $PARAM_ID     = vd($_REQUEST["ID"], "int");
            $PARAM_ESTADO = vd($_REQUEST["ESTADO"], "int");

            $PARAM_ESTADO = vd("BORRADOR", "text");

            $SQL = "SP_SELECT_Q_ORDEN_ANULAR(
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

        case 12:

            //pf($_REQUEST,1);
            //pf($_FILES, 0);

            $PARAM_ID     = vd($_REQUEST["ID"], "int");
            //$PARAM_ESTADO = vd($_REQUEST["ESTADO"], "int");

            $PARAM_ESTADO = vd("BORRADOR", "text");

            $SQL = "SP_SELECT_Q_ORDEN_FINALIZAR_ESTADO($PARAM_ID)";
            $cn->execute($SQL, 0);
            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];

            } else {
                $matriz["fila_afectada"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;
    }
}
