<?php
require_once 'autoload.php';

$opcion = db64d($_REQUEST['opcion']);
//$cn     = new consumomedoo($cnq);

if (isset($_REQUEST['opcion'])) {
    switch ($opcion) {
        case 0: //validacion de usuario
            if ((isset($_REQUEST['usuario'])) and (isset($_REQUEST['clave']))) {
                $aux1    = strtoupper(decry($_REQUEST['usuario']));
                $aux2    = strtoupper(decry($_REQUEST['clave']));
                $usuario = vd($aux1, "text");
                $clave   = vd(hash('sha256', $aux2), "text");

                /** se cambi a a hash sha256 */
                $SQL = "
                 SELECT  u.login,  u.nombrecompleto, u.nivel
                 FROM Q_usuario u
                 where u.login= $usuario
                 and u.clave = $clave
                 and u.eliminado =0
                 and u.estado ='ACTIVO'";

                $SQL = "SP_SELECT_Q_USUARIO_LOGIN($usuario,$clave)";

                $cn->execute($SQL, 0);

                if ($cn->filas_afectada() > 0) {
                    if ($cn->filas_afectada() == 1) {
                        $_matriz        = $cn->datos();
                        $usuario        = $_matriz[0]['LOGIN'];
                        $nombrecompleto = $_matriz[0]['NOMBRECOMPLETO'];
                        $nivel          = $_matriz[0]['NIVEL'];

                        if (true) {

                            $_matriz['fila_afectada'] = $cn->filas_afectada();
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            // CARGAR EL IVA COMO SESION
                            // FIN
                            $_SESSION['user']           = $usuario;
                            $_SESSION['level']          = $nivel;
                            $_SESSION['nombrecompleto'] = $nombrecompleto;
                            //$_SESSION['proyecto'] = $proyecto;

                            $_SESSION["app"] = "oficio11";

                            //$_SESSION["verifica_token"] = $VERIFICADO_TOKEN;

                            //$_SESSION["correo"]    = $CORREO;

                            //$mensaje = "ACCESO AL SISTEMA DE USUARIO " . $_SESSION['user'] . " con nivel de permisos  : " . $_SESSION['level'];
                            //$cnm = new consumomedoo($hostname,$database,$username,$password,$port);
                            //grabar_auditoria($mensaje,$cnm);

                            //pf($_SESSION,1);

                        } else {
                            $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                            $_matriz['fila_afectada'] = -1;

                        }

                    } else {
                        $_matriz['fila_afectada'] = -1;
                        $_matriz['mensaje']       = "DATOS ERRONEOS f";
                    }
                } else {
                    $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                    $_matriz['fila_afectada'] = $cn->filas_afectada();
                }
            }
            print json_encode($_matriz);
            break;

        case 11: //validacion de usuario

            //pf($_REQUEST,0);
            //pf($_SESSION,0);

            $SQL = "
                 SELECT  NOMBRE
                 ,CONCAT(URL,'?dd=',MD5(now())) AS URL
                 ,TIPO,CON_VENTANA,ID_MODULO,0 AS USADO,ICONO
                 FROM Q_PERMISOS
                 where 1= 1
                 and id <>1
                 and nivel like concat('%', $level_vd,'%')
                 ORDER BY TIPO DESC
                 ";

            $cn->execute($SQL, 2);

            if ($cn->filas_afectada() > 0) {
                if ($cn->filas_afectada() > 0) {
                    $data = $cn->datos();

                    for ($i = 0; $i < count($data); $i++) {
                        if ($data[$i]["TIPO"] == "MODULO") {
                            $data[$i]["USADO"] = 1;
                        }

                    }

                    $finalData = [];

                    // Un array temporal para almacenar los módulos
                    $modulos = [];
                    $menus   = [];

                    foreach ($data as $row) {
                        if ($row['TIPO'] == 'MODULO') {
                            // Agregar el módulo al array de módulos
                            $modulos[] = $row;
                        } elseif ($row['TIPO'] == 'MENU') {
                            // Agregar el menú al array de menús
                            $menus[] = $row;
                        }
                    }

                    //tablas($modulos);
                    //tablas($menus);
                    // Dividir los módulos y los menús
                    $resultado = "";
                    // Ahora intercalamos los módulos y los menús
                    foreach ($modulos as $modulo) {
                        $finalData[] = $modulo; // Agregar el módulo
                        // Buscar los menús que tienen el mismo ID_MODULO
                        foreach ($menus as $menu) {
                            if ($menu['ID_MODULO'] == $modulo['ID_MODULO']) {
                                $finalData[] = $menu; // Agregar el menú relacionado
                            }
                        }
                    }

                    foreach ($finalData as $row) {
                        if ($row['TIPO'] == 'MODULO') {
                            // $resultado .= '<li><a href="'.$row["URL"].'">'.$row["NOMBRE"].'</a></li>';

                            $resultado .= '<li class="modulo fas fa-sm ' . $row["ICONO"] . '"><center>' . $row["NOMBRE"] . '</center></li>';
                        } elseif ($row['TIPO'] == 'MENU') {
                            $resultado .= '<li><a class="fas  ' . $row["ICONO"] . ' fa-sm" href="' . $row["URL"] . '">&#9;' . $row["NOMBRE"] . '</a></li>';

                        }
                    }

                    $resultado .= '<li><a class="modulo2 fas fa-cog" href="jquery/logout.php">Salir</a></li>';

                    $_matriz["resultado"]     = $resultado;
                    $_matriz['fila_afectada'] = 1;
                    $_matriz['mensaje']       = "DATOS OK";
                    //pf($resultado);
                    //tablas($finalData);exit();

                } else {
                    $_matriz['fila_afectada'] = -1;
                    $_matriz['mensaje']       = "DATOS ERRONEOS f";
                }
            } else {
                $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                $_matriz['fila_afectada'] = $cn->filas_afectada();
            }

            print json_encode($_matriz);
            break;

        case 12: //validacion de usuario

            //pf($_REQUEST,0);
            //pf($_SESSION,0);

            $SQL = "
                 SELECT  NOMBRE
                 ,CONCAT(URL,'?dd=',MD5(now())) AS URL
                 ,TIPO,CON_VENTANA,ID_MODULO,0 AS USADO,ICONO
                 FROM Q_PERMISOS
                 where 1= 1
                 and id <>1
                 and nivel like concat('%', $level_vd,'%')
                 ORDER BY TIPO DESC
                 ";

            $cn->execute($SQL, 2);

            if ($cn->filas_afectada() > 0) {
                if ($cn->filas_afectada() > 0) {
                    $data = $cn->datos();

                    for ($i = 0; $i < count($data); $i++) {
                        if ($data[$i]["TIPO"] == "MODULO") {
                            $data[$i]["USADO"] = 1;
                        }

                    }

                    $finalData = [];

                    // Un array temporal para almacenar los módulos
                    $modulos = [];
                    $menus   = [];

                    foreach ($data as $row) {
                        if ($row['TIPO'] == 'MODULO') {
                            // Agregar el módulo al array de módulos
                            $modulos[] = $row;
                        } elseif ($row['TIPO'] == 'MENU') {
                            // Agregar el menú al array de menús
                            $menus[] = $row;
                        }
                    }

                    //tablas($modulos);
                    //tablas($menus);
                    // Dividir los módulos y los menús
                    $resultado = "";
                    // Ahora intercalamos los módulos y los menús
                    foreach ($modulos as $modulo) {
                        $finalData[] = $modulo; // Agregar el módulo
                        // Buscar los menús que tienen el mismo ID_MODULO
                        foreach ($menus as $menu) {
                            if ($menu['ID_MODULO'] == $modulo['ID_MODULO']) {
                                $finalData[] = $menu; // Agregar el menú relacionado
                            }
                        }
                    }

                    foreach ($finalData as $row) {
                        if ($row['TIPO'] == 'MODULO') {
                            // $resultado .= '<li><a href="'.$row["URL"].'">'.$row["NOMBRE"].'</a></li>';

                            //$resultado .= '<li class="modulo fas fa-sm ' . $row["ICONO"] . '"><center>' . $row["NOMBRE"] . '</center></li>';
                        } elseif ($row['TIPO'] == 'MENU') {
                            $resultado .= '<li><a class="fas  ' . $row["ICONO"] . ' fa-sm" href="' . $row["URL"] . '">&#9;' . $row["NOMBRE"] . '</a></li>';

                        }
                    }

                    $resultado .= '<li><a class="modulo2 fas fa-cog" href="jquery/logout.php">Salir</a></li>';

                    $_matriz["resultado"]     = $resultado;
                    $_matriz['fila_afectada'] = 1;
                    $_matriz['mensaje']       = "DATOS OK";
                    //pf($resultado);
                    //tablas($finalData);exit();

                } else {
                    $_matriz['fila_afectada'] = -1;
                    $_matriz['mensaje']       = "DATOS ERRONEOS f";
                }
            } else {
                $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                $_matriz['fila_afectada'] = $cn->filas_afectada();
            }

            print json_encode($_matriz);
            break;
    }
}
