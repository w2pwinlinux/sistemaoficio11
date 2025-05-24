// JavaScript Document
$(document).ready(function() {
    cargar_menu_js_movil();
    if (parseInt($("#LEVEL").val())==3){
        console.log("perfil3");
        cargar_menu_js_movil_home();
    }

    

});

function cargar_menu_js_movil() {
    var purl = "";
    datos = {
        "opcion": eb64e(11)
    };
    $.post("jquery/login.php", datos, function(data) {
        if (data.fila_afectada > 0) {
            $(".menu").html("");
            $(".menu").append(data.resultado);
            
        } else {}
    }, "json");
}

function cargar_menu_js_movil_home() {
    var purl = "";
    datos = {
        "opcion": eb64e(12)
    };
    $.post("jquery/login.php", datos, function(data) {
        if (data.fila_afectada > 0) {
            console.log(data.resultado);
            $(".menu2").html("");
            $(".menu2").append(data.resultado);
            
        } else {}
    }, "json");
}

function validaciones() { // para validaciones
    //  $("").numeric({ decimal: false, negative: false }, function() { alert("Solo valores enteros positivos"); this.value = ""; this.focus(); });// solo numeros
    //  $("").numeric({ negative: false }, function() { alert("Solo valores positivos"); this.value = ""; this.focus(); });// numeros decimales
    $("#tabla_elementos").hide();
    var cadena = "";
    //  cadena = "MODULO : PLAN OPERATIVO ANUAL SE CERRARA EL VIERNES 13 DE JULIO DEL 2012 A LAS 23:59 HORAS<br>";
    //  cadena="<marquee>MODULO : PLAN ANUAL DE COMPRAS SE CERRARA EL DIA LUNES 23 DE JULIO DEL 2012 A LAS 23:59 HORAS</marquee>";
    //  cadena="<p class='centrorojo18'>POR FAVOR ENVIAR CON OFICIO DIRIGIDO A LA DIRECCION FINANCIERA:<BR> REPORTE DE PLANIFICACION<BR>PLAN ANUAL DE COMPRAS<BR>DETALLE DEL PLAN ANUAL DE COMPRAS </p>";
    //  cadena="<p class='centrorojo18'>SE ENCUENTRA APERTURADO PARA REALIZAR LAS RESPECTIVAS MODIFICACIONES AL PLAN OPERATIVO ANUAL Y PLAN ANUAL DE COMPRAS  ";
    //  cadena+=", PUEDE REALIZAR LAS MODIFICACIONES AL POA Y AL PAC TOMANDO EN CONSIDERACION LAS RESTRICCIONES DE NO BORRAR LOS SERVICIOS BASICOS ";
    //  cadena+=" Y NO BORRAR LINEAS DE ACCION DE POA QUE SE ESTEN UTILIZANDO EN EL PAC </p>";
    $("#divcentroblanco").html(cadena)
    //revisar_elementos();
}

function revisar_elementos() {
    cargando(1);
    datos = {
        "opcion": 12
    };
    $.getJSON("jquery/poa_d.php", datos, function(data) {
        if (data.fila_afectada < 1) {
            cargando(2);
            cargando_formulario(2, $("#tabla_elementos"));
        } else {
            cargando(2)
        }
    });
}

function novedad() {
    var importante = -1;
    var purl = "";
    datos = {
        "opcion": 5
    };
    $.post("jquery/novedad.php", datos, function(data) {
        if (data.fila_afectada > 0) {
            var cadena = "";
            cadena = "<ul>";
            for (i = 0; i < data.fila_afectada; i++) {
                //cadena+="<li> ID  :"+data[i]['ID'];
                //importante = data[i]['IMPORTANTE'];
                if (data[i]['IMPORTANTE'] == 0) {
                    cadena += "<li class='novedad_titulo'> EVENTO  :" + b64d(data[i]['NOMBRE']) + "</li>";
                } else {
                    cadena += "<li class='novedad_titulo_importante'> EVENTO  :" + b64d(data[i]['NOMBRE']) + "</li>";
                }
                cadena += "<li class='novedad_detalle'> DETALLE : " + b64d(data[i]['DESCRIPCION']) + "</div>";
                if ((data[i]['ARCHIVO']).length > 1) {
                    cadena += "<li class='novedad_link'> DOCUMENTACION :<a target='_blank' href='" + b64d(data[i]['ARCHIVO']) + "'>LINK</a> </li>";
                }
            }
            //ma("Novedad",b64d(data[i-1]["DESCRIPCION"]),"info");
            console.log(i);
            cadena += "</ul>";
            $("#novedades").html("");
            $("#novedades").append(cadena);
            $("#novedades").dwdinanews({
                retardo: 3000,
                tiempoAnimacion: 1000,
                funcionAnimacion: 'easeInOutElastic'
            });
            //$("#novedades").css({"float":"left","color":"#000","height":"350px","width":"1175px",'border-color':"#900"});
            //$("#novedades").removeAttr('border-color');
            //
        } else {}
    }, "json");
}

function procesar() {
    $("#procesar").click(function() {
        if (nocomponentes == 0) {
            $("#componente").prop("disabled", true);
            $("#detalle").show();
            cargar_detalle();
            setTimeout("accion()", 200);;
        } else {
            g_cancelar("home.php");
        }
        $("input:text").prop("disabled", true);
        $(this).hide();
    });
}

function accion() {
    cargando_campo(1, $("#detalle"), "");
    datos = {
        "opcion": 7
    };
    datos.componente = $("select#componente").val();
    $.getJSON("jquery/acciones_d.php", datos, function(data) {
        if (data.fila_afectada > 0) {
            $("#accion").append("<option value='-1'>SELECCIONE</option>");
            for (i = 0; i < data.fila_afectada; i++) {
                $("#accion").append("<option value=" + data[i]['ID'] + ">" + data[i]['NOMBRE'] + "</option>");
            }
            cargando_campo(2, $("#detalle"), "");
            $("#accion").prop("disabled", false);
        } else {
            if (data.fila_afectada == 0) {
                smoke.alert("NO EXISTE ACCIONES ");
                $("#procesando2").hide();
            } else {
                smoke.alert(data.mensaje);
                $("#procesando2").hide();
            }
            cargando_campo(2, $("#detalle"), "");
            $("#accion").prop("#disabled", true);
        }
        $("#accion").width("120px");
    });
}

function change_accion() {
    $("#accion").change(function() {
        //      $("#accion option[value='-1']").remove();
        $("#indicador").html('');
        $("#indicador").prop("disabled", true);
        if ($(this).val() != -1) {
            cargando_campo(1, $("#detalle"), "");
            $("#indicador").html();
            datos = {
                "opcion": 6
            };
            datos.accion = $("select#accion").val();
            datos.componente = $("#componente").val();
            $.getJSON("jquery/indicadores_d.php", datos, function(data) {
                if (data.fila_afectada > 0) {
                    $("#indicador").append("<option value='-1'>SELECCIONE</option>");
                    for (i = 0; i < data.fila_afectada; i++) {
                        $("#indicador").append("<option value=" + data[i]['ID'] + ">" + data[i]['NOMBRE'] + "</option>");
                    }
                    cargando_campo(2, $("#detalle"), "");
                    $("#indicador").prop("disabled", false);
                } else {
                    if (data.fila_afectada == 0) {
                        smoke.alert("NO EXISTE INDICADORES O YA ESTA INGRESADOS EN EL SISTEMA ");
                        $("#procesando2").hide();
                    } else {
                        smoke.alert(data.mensaje);
                        $("#procesando2").hide();
                    }
                    cargando_campo(2, $("#detalle"), "");
                    $("#indicador").prop("#disabled", true);
                }
                $("#indicador").width("120px");
            });
        }
    })
}

function change_indicador() {
    $("#indicador").change(function() {
        if ($(this).val() != -1) {
            $("input:text").prop("disabled", false);
            $("#linea_base").focus();
        }
    });
}

function text_focusout() { // veraqui wilson1
    $("#linea_base,#proyecta,#trimestre1,#trimestre2,#trimestre3,#trimestre4").focusout(function(e) {
        var valor = $(this).val();
        if (valor <= 100) {
            if (valor >= 0) {} else {
                $(this).val("0");
            }
        } else {
            $(this).val("0");
        }
    });
    $("#linea_base,#trimestre1,#trimestre2,#trimestre3,#trimestre4,#proyecta").focusout(function(e) {
        var valor = $(this).val();
        if (valor >= 0) {
            //          valor = redondea2(valor);
            valor = parseInt(valor);
            $(this).val(valor);
        } else {
            $(this).val("0");
        }
    });
    $("#humanos_h,#bienes_servicios,#capital").focusout(function(e) {
        var valor = $(this).val();
        if (valor >= 0) {
            valor = redondea2(valor);
            $(this).val(valor);
        } else {
            $(this).val("0");
        }
    });
}

function agregar_detalle() {
    $("#agregar_detalle").click(function() {
        if (ggrabando_detalle == 0) {
            grabar();
        }
    });
    //  $("#responsable").focusout(function(){
    //      if(ggrabando_detalle==0){
    //          grabar();
    //      }
    //  });
    $("#responsable").keypress(function(event) {
        //console.log(valor_digitado(event))
        if (valor_digitado(event) == 13 || valor_digitado(event) == "13") {
            grabar();
        }
    });
}

function grabar() {
    var dato = (confirm("grabar!!!!!")) ? "si" : "no";
    if (dato == "si") {
        $("#accion_nombre_nuevo").val("-");
        $("#indicador_nombre_indicador").val("-");
        $("#indicador_nuevo_indicador").val("-");
        if (g_vacios() == 0 && revision_select() == 0) {
            cargando_campo(1, $("#detalle"), "");
            datos = {
                "opcion": 0
            };
            datos.componente = $("#componente").val();
            datos.accion = $("#accion").val();
            datos.indicador = $("#indicador").val();
            datos.linea_base = $("#linea_base").val();
            datos.proyecta = $("#proyecta").val();
            datos.trimestre1 = $("#trimestre1").val();
            datos.trimestre2 = $("#trimestre2").val();
            datos.trimestre3 = $("#trimestre3").val();
            datos.trimestre4 = $("#trimestre4").val();
            datos.humanos = $("#humanos_h").val();
            datos.bienes_servicios = $("#bienes_servicios").val();
            datos.capital = $("#capital").val();
            datos.beneficiarios = $("#beneficiarios").val();
            datos.responsable = $("#responsable").val();
            // inicio dato beneficiarios
            datos.genero_masculino = $("#genero_masculino").val();
            datos.genero_femenino = $("#genero_femenino").val();
            datos.total_genero = $("#total_genero").val();
            datos.etario_menos_15 = $("#etario_menos_15").val();
            datos.etario_de_15_a_29 = $("#etario_de_15_a_29").val();
            datos.etario_de_30_a_64 = $("#etario_de_30_a_64").val();
            datos.etario_de_65 = $("#etario_de_65").val();
            datos.total_etario = $("#total_etario").val();
            datos.discapacidades_fisicas = $("#discapacidades_fisicas").val();
            datos.discapacidades_psicologicas = $("#discapacidades_psicologica").val();
            datos.discapacidades_mental = $("#discapacidades_mental").val();
            datos.discapacidades_auditiva = $("#discapacidades_auditiva").val();
            datos.discapacidades_visual = $("#discapacidades_visual").val();
            datos.total_discapacidades = $("#total_discapacidades").val();
            datos.pueblos_indigena = $("#pueblos_indigena").val()
            datos.pueblos_mestizos = $("#pueblos_mestizos").val();
            datos.pueblos_blancos = $("#pueblos_blancos").val();
            datos.pueblos_afroamericanos = $("#pueblos_afroamericanos").val();
            datos.pueblos_montubios = $("#pueblos_montubios").val();
            datos.pueblos_otros = $("#pueblos_otros").val();
            datos.total_pueblos = $("#total_pueblos").val();
            datos.movilidad_ecuatoriano_extranjero = $("#movilidad_ecuatoriano_extranjero").val();
            datos.movilidad_extranjero_ecuatoriano = $("#movilidad_extranjero_ecuatoriano").val();
            datos.total_movilidad = $("#total_movilidad").val();
            // fin datos beneficiairos
            grabando_detalle(1);
            $.getJSON("jquery/poa_d.php", datos, function(data) {
                if (data.fila_afectada > 0) {
                    var cadena = ""; // nueva fila
                    cadena = "<tr></tr><tr></tr>";
                    cadena = "<tr class='letrapequenialeft'><td><input type='hidden' id='idi' value =" + data[0]['IDI'] + ">";
                    cadena += "<input type='hidden' id='ida' value =" + data[0]['IDA'] + ">";
                    cadena += "<input type='hidden' id='id_poa' value =" + data[0]['ID'] + ">" + data[0]['ACCION'] + "</td>";
                    cadena += "<td>" + data[0]['INDICADOR'] + "</td><td>" + data[0]['LINEA_BASE'] + "</td><td>" + data[0]['PROYECCION'] + "</td>";
                    cadena += "<td>" + data[0]['TRIMESTRE1'] + "</td><td>" + data[0]['TRIMESTRE2'] + "</td>";
                    cadena += "<td>" + data[0]['TRIMESTRE3'] + "</td><td>" + data[0]['TRIMESTRE4'] + "</td><td>" + data[0]['RECURSOS_HUMANOS'] + "</td>";
                    cadena += "<td>" + data[0]['RECURSOS_BIENES_SEVICIOS'] + "</td>";
                    cadena += "<td>" + data[0]['RECURSOS_CAPITAL'] + "</td><td>" + data[0]['BENEFICIARIO'] + "</td><td>" + data[0]['RESPONSABLE'] + "</td>";
                    cadena += "<td></td><td><a href='' class='delete'><img src='images/remove.png' name='delete' width='16' height='16' id='image_delete'></a>";
                    //cadena+="<a href='' class='edit'><img src='images/edit.png' name='edit' width='16' height='16' id='image_edit'></a></td></tr>"
                    cadena += "</td></tr>"
                    g_grabar_componente++;
                    verificar_grabar_componente();
                    $("#tr_campos").before(cadena);
                    //$("#valor_arancel").prop("disabled",false);
                    $("a.delete").unbind("click");
                    $("a.edit").unbind("click");
                    $("#brecha,#descripcion_brecha").text("");
                    eliminar_detalle();
                    grabando_detalle(0);
                    accion();
                    cargando_campo(2, $("#principal"), "");
                    $("#total_genero,#genero_masculino,#genero_femenino,#etario_menos_15,#etario_de_15_a_29,#etario_de_30_a_64,#etario_de_65,#total_etario,#discapacidades_fisicas,#discapacidades_psicologica,#discapacidades_mental,#discapacidades_auditiva,#discapacidades_visual,#total_discapacidades,#pueblos_indigena,#pueblos_mestizos,#pueblos_blancos,#pueblos_afroamericanos,#pueblos_montubios,#pueblos_otros,#total_pueblos,#movilidad_ecuatoriano_extranjero,#movilidad_extranjero_ecuatoriano,#total_movilidad").val("0.00");
                    $("#beneficiarios").val("0.00");
                    $("input:text").prop("disabled", true);
                    $("#procesando2").hide();
                } else {
                    grabando_detalle(0);
                    accion();
                    if (data.fila_afectada == 0) {
                        smoke.alert("ERROR EN DATOS");
                    } else {
                        smoke.alert(data.mensaje);
                    }
                    cargando_campo(2, $("#detalle"), "");
                    $("#procesando2").hide();
                }
            });
            //
        } else {}
        cargando_campo(2, $("#detalle"), "");
    } else {}
}

function grabando_detalle(tipo) {
    if (tipo == 1) {
        $("input:text,select").prop("disabled", true);
        $("input:text").val('');
        $("#accion,#indicador").html("");
        ggrabando_detalle = 1;
    } else {
        $("input:text,#accion").prop("disabled", false);
        $("#accion").focus();
        ggrabando_detalle = 0;
    }
}

function revision_select() {
    var accion = $("#accion").val();
    var indicador = $("#indicador").val();
    if (accion == -1) {
        smoke.alert("POR FAVOR SELECCIONE LA ACCION ");
        $("#accion").focus();
        return 1;
    }
    if (indicador == -1) {
        smoke.alert("POR FAVOR SELECCIONE EL INDICADOR");
        $("#indicador").focus();
        return 1;
    }
    var trimestre1 = $("#trimestre1").val();
    var trimestre2 = $("#trimestre2").val();
    var trimestre3 = $("#trimestre3").val();
    var trimestre4 = $("#trimestre4").val();
    var total = parseInt(trimestre1) + parseInt(trimestre2) + parseInt(trimestre3) + parseInt(trimestre4);
    if (total != 100) {
        smoke.alert("EL TOTAL DE LOS TRIMESTRES DEBE SER 100%");
        $("#trimestre1").focus();
        return 1
    }
    return 0;
}

function cargar_detalle() {
    if (1 == 1) {
        cargando_campo(1, $("#detalle"), "");
        datos = {
            "opcion": 7
        };
        datos.componente = $("#componente").val();
        $.getJSON("jquery/poa_d.php", datos, function(data) {
            if (data.fila_afectada > 0) {
                for (i = 0; i < data.fila_afectada; i++) {
                    var cadena = ""; //INSERTAR NUEVA FILA
                    cadena = "<tr></tr><tr></tr>";
                    cadena += "<tr class='letrapequenialeft'><td><input type='hidden' id='id_poa' value =" + data[i]['ID'] + ">" + data[i]['ACCION'] + "</td>";
                    cadena += "<td>" + data[i]['INDICADOR'] + "</td><td>" + data[i]['LINEA_BASE'] + "</td><td>" + data[i]['PROYECCION'] + "</td>";
                    cadena += "<td>" + data[i]['TRIMESTRE1'] + "</td><td>" + data[i]['TRIMESTRE2'] + "</td>";
                    cadena += "<td>" + data[i]['TRIMESTRE3'] + "</td><td>" + data[i]['TRIMESTRE4'] + "</td><td>" + data[i]['RECURSOS_HUMANOS'] + "</td>";
                    cadena += "<td>" + data[i]['RECURSOS_BIENES_SEVICIOS'] + "</td>";
                    cadena += "<td>" + data[i]['RECURSOS_CAPITAL'] + "</td><td>" + data[i]['BENEFICIARIO'] + "</td><td>" + data[i]['RESPONSABLE'] + "</td>";
                    cadena += "<td></td><td><a href='' class='delete'><img src='images/remove.png' name='delete' width='16' height='16' id='image_delete'></a>";
                    //                  cadena+="<a href='' class='edit'><img src='images/edit.png' name='edit' width='16' height='16' id='image_edit'></a></td></tr>"
                    cadena += "</td></tr>"
                    $("#tr_campos").before(cadena);
                    g_grabar_componente++;
                    verificar_grabar_componente();
                }
                $("a.delete").unbind("click");
                $("a.edit").unbind("click");
                eliminar_detalle();
                //editar_detalle();
                cargando_campo(2, $("#principal"), "");
            } else {
                if (data.fila_afectada != 0) {
                    smoke.alert(data.mensaje);
                }
                cargando_campo(2, $("#detalle"), "");
            }
        });
        //
        cargando_campo(2, $("#detalle"), "");
    } else {}
}

function eliminar_detalle() { // ok
    $("a.delete").click(function(event) {
        event.preventDefault();
        var dato = (confirm("Esta seguro q desea eliminar !!!!!")) ? "si" : "no";
        if (dato == "si") {
            cargando_campo(1, $("#detalle"), "eliminando");
            var id_poa = $(this).parents("tr").find("input[id='id_poa']").val();
            datos = {
                "opcion": 5
            };
            datos.id_poa = id_poa;
            $.getJSON("jquery/poa_d.php", datos, function(data) {
                if (data.fila_afectada != -1) {
                    g_grabar_componente--;
                    $('#detalle tr').each(function(index) {
                        ids = $(this).find("input[id='id_poa']").val();
                        if (ids == id_poa) {
                            $(this).remove();
                            return false;
                        }
                    });
                    cargando_campo(2, $("#detalle"), "");
                } else {
                    smoke.alert(data.mensaje);
                    cargando_campo(2, $("#detalle"), "");
                }
            });
        }
    });
}

function verificar_grabar_componente() { // aqui para ctivar grabar
    if (g_grabar_componente > 3) {
        $("#grabar_componente").show();
    } else {
        $("#grabar_componente").hide();
    }
}

function grabar_componente() {
    $("#grabar_componente").click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        smoke.alert("SEGURO QUE DESEA AUTORIZAR QUE LA INFORMACION DE ESTE COMPONENTE SE GRABE Y PASAR A MODO SOLO LECTURA", {}, function(e) {
            smoke.confirm('AUTORIZAR GRABAR INFORMACION DE COMPONENTE??', function(e) {
                if (e) {
                    cargando(1);
                    datos = {
                        "opcion": 8
                    };
                    datos.componente = $("#componente").val();
                    $.ajax({
                        async: false,
                        type: "GET",
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded",
                        url: "jquery/poa_d.php",
                        data: datos,
                        success: resultadoscv
                    });
                }
            });
        });
    });
}

function resultadoscv(dator) {
    smoke.alert(dator.mensaje);
    cargando(2);
    if (dator.fila_afectada != -1) {
        g_cancelar("poa_d.php");
    }
}

function redondea2(rvalor) {
    var dec = 2;
    var n = parseFloat(rvalor);
    var s;
    //n = Math.round(n * Math.pow(10, dec)) / Math.pow(10,dec);
    s = String(n) + "." + String(Math.pow(10, dec)).substr(1);
    s = s.substr(0, s.indexOf(".") + dec + 1);
    return s;
}

function calculo_brecha() {
    $("#proyecta").focusout(function() {
        var linea_base = $("#linea_base").val();
        var proyecta = $("#proyecta").val();
        var brecha = parseFloat(proyecta) - parseFloat(linea_base);
        $("#brecha").text("Brecha = " + brecha);
        tips($("#brecha"));
        //      $("#descripcion_brecha").text("");
    });
}

function click_beneficiarios() {
    $("#beneficiarios").focus(function() {
        cargando_formulario(1, $("#tabla_beneficiario"));
        //      $("#total_genero,#genero_masculino,#genero_femenino,#etario_menos_15,#etario_de_15_a_29,#etario_de_30_a_64,#etario_de_65").val("0.00");
        //      $("#total_etario,#discapacidades_fisicas,#discapacidades_psicologica,#discapacidades_mental,#discapacidades_auditiva,#discapacidades_visual").val("0.00");
        //      $("#total_discapacidades,#pueblos_indigena,#pueblos_mestizos,#pueblos_blancos,#pueblos_afroamericanos,#pueblos_montubios,#pueblos_otros,#total_pueblos").val("0.00");
        //      $("#movilidad_ecuatoriano_extranjero,#movilidad_extranjero_ecuatoriano,#total_movilidad").val("0.00");x
        $("#total_genero,#genero_masculino,#genero_femenino,#etario_menos_15,#etario_de_15_a_29,#etario_de_30_a_64,#etario_de_65,#total_etario,#discapacidades_fisicas,#discapacidades_psicologica,#discapacidades_mental,#discapacidades_auditiva,#discapacidades_visual,#total_discapacidades,#pueblos_indigena,#pueblos_mestizos,#pueblos_blancos,#pueblos_afroamericanos,#pueblos_montubios,#pueblos_otros,#total_pueblos,#movilidad_ecuatoriano_extranjero,#movilidad_extranjero_ecuatoriano,#total_movilidad").numeric({
            decimal: false,
            negative: false
        }, function() {
            alert("Solo valores enteros positivos");
            this.value = "";
            this.focus();
        }); // solo numeros
        $("input:text").prop("disabled", false);
        $("#total_genero,#total_etario,#total_discapacidades,#total_pueblos,#total_movilidad").attr("readonly", true);
        foco_totales();
        textos_focusout();
    });
}

function textos_focusout() {
    $("#total_genero,#genero_masculino,#genero_femenino,#etario_menos_15,#etario_de_15_a_29,#etario_de_30_a_64,#etario_de_65,#total_etario,#discapacidades_fisicas,#discapacidades_psicologica,#discapacidades_mental,#discapacidades_auditiva,#discapacidades_visual,#total_discapacidades,#pueblos_indigena,#pueblos_mestizos,#pueblos_blancos,#pueblos_afroamericanos,#pueblos_montubios,#pueblos_otros,#total_pueblos,#movilidad_ecuatoriano_extranjero,#movilidad_extranjero_ecuatoriano,#total_movilidad").focusout(function() {
        var valor = $(this).val();
        if (valor >= 0) {
            //          valor = redondea2(valor);
            valor = parseInt(valor)
            $(this).val(valor);
        } else {
            $(this).val("0");
        }
    });
}

function foco_totales() {
    $("#total_genero").focus(function() {
        var uno = parseFloat($("#genero_masculino").val());
        var dos = parseFloat($("#genero_femenino").val());
        $(this).val(uno + dos);
    });
    $("#total_etario").focus(function() {
        var uno = parseFloat($("#etario_menos_15").val());
        var dos = parseFloat($("#etario_de_15_a_29").val());
        var tres = parseFloat($("#etario_de_30_a_64").val());
        var cuatro = parseFloat($("#etario_de_65").val());
        $(this).val(uno + dos + tres + cuatro);
    });
    $("#total_discapacidades").focus(function() {
        var uno = parseFloat($("#discapacidades_fisicas").val());
        var dos = parseFloat($("#discapacidades_psicologica").val());
        var tres = parseFloat($("#discapacidades_mental").val());
        var cuatro = parseFloat($("#discapacidades_auditiva").val());
        var cinco = parseFloat($("#discapacidades_visual").val());
        $(this).val(uno + dos + tres + cuatro + cinco);
    });
    $("#total_pueblos").focus(function() {
        var uno = parseFloat($("#pueblos_blancos").val());
        var dos = parseFloat($("#pueblos_afroamericanos").val());
        var tres = parseFloat($("#pueblos_indigena").val());
        var cuatro = parseFloat($("#pueblos_mestizos").val());
        var cinco = parseFloat($("#pueblos_montubios").val());
        var seis = parseFloat($("#pueblos_otros").val());
        $(this).val(uno + dos + tres + cuatro + cinco + seis);
    });
    $("#total_movilidad").focus(function() {
        var uno = parseFloat($("#movilidad_ecuatoriano_extranjero").val());
        var dos = parseFloat($("#movilidad_extranjero_ecuatoriano").val());
        $(this).val(uno + dos);
    });
}

function enviar_beneficiarios() {
    $("#enviar_beneficiario").click(function() {
        $("#total_genero,#total_etario,#total_discapacidades,#total_pueblos,#total_movilidad").attr("readonly", true);
        var uno = parseInt($("#total_genero").val()); //+parseFloat($("#total_etario").val())+parseFloat($("#total_discapacidades").val());
        //uno+=parseFloat($("#total_pueblos").val())+parseFloat($("#total_movilidad").val())
        $("#beneficiarios").val(uno);
        cargando_formulario(2, $("#tabla_beneficiario"));
    });
    $("#cancelar_beneficiario").click(function() {
        $("#total_genero,#genero_masculino,#genero_femenino,#etario_menos_15,#etario_de_15_a_29,#etario_de_30_a_64,#etario_de_65,#total_etario,#discapacidades_fisicas,#discapacidades_psicologica,#discapacidades_mental,#discapacidades_auditiva,#discapacidades_visual,#total_discapacidades,#pueblos_indigena,#pueblos_mestizos,#pueblos_blancos,#pueblos_afroamericanos,#pueblos_montubios,#pueblos_otros,#total_pueblos,#movilidad_ecuatoriano_extranjero,#movilidad_extranjero_ecuatoriano,#total_movilidad").val("0.00");
        $("#beneficiarios").val("0");
        cargando_formulario(2, $("#tabla_beneficiario"));
    });
}
/*INICIO PARA NUEVAS ACCION*/
function agregar_nueva_accion() {
    $("#agregar_accion").click(function() {
        $("#accion_descripcion_oo").hide();
        $("#accion_nueva_procesando").hide();
        $("#accion_nombre_nuevo").removeAttr("disabled");
        cargando_formulario(1, $("#tabla_nueva_accion"));
        $("#tabla_nueva_accion").css('cursor', 'auto');
        $("#enviar_accion,#cancelar_accion").show();
        $("#accion_nombre_nuevo").val("");
        // BORRAR EL EVENTO CARGADO A LOS CAMPOS
        $("#accion_listado_oo").unbind("change");
        $("#enviar_accion").unbind("click");
        acciones_cargar_objetivos();
        acciones_change_objetivos();
        acciones_cancelar_grabar_acciones();
    });
}

function acciones_cargar_objetivos() {
    datos = {
        "opcion": 2
    };
    $.getJSON("jquery/acciones_d.php", datos, function(data) {
        g_data_obj = data;
        if (data.fila_afectada != -1) {
            if (data.fila_afectada != 0) {
                $("#accion_listado_oo").html("");
                $("#accion_listado_oo").append("<option value=-1>Seleccione</option>");
                for (i = 0; i < data.fila_afectada; i++) {
                    $("#accion_listado_oo").append("<option value=" + data[i]['ID'] + ">" + data[i]['ID'] + "---" + data[i]['NOMBRE'] + "</option>");
                }
            } else {
                smoke.alert("NO HAY objetivos operativos");
            }
        } else {
            smoke.alert(data.mensaje);
        }
    });
}

function acciones_change_objetivos() {
    $("#accion_listado_oo").change(function() {
        var valor = $(this).val();
        var sw = 0;
        $("#accion_descripcion_oo").hide("slow");
        for (i = 0; i < g_data_obj.fila_afectada; i++) {
            if (valor == g_data_obj[i]['ID']) {
                $("#accion_descripcion_oo").val(g_data_obj[i]['DESCRIPCION']);
                sw = 1;
            }
        }
        if (sw == 1) {
            $("#accion_descripcion_oo").show("slow");
        } else {
            $("#accion_descripcion_oo").hide("slow");
        }
    });
}

function acciones_cancelar_grabar_acciones() {
    $("#enviar_accion").click(function() {
        $("#tabla_nueva_accion").hide();
        var nueva_accion = $("#accion_nombre_nuevo").val();
        var objetivo = $("#accion_listado_oo").val();
        if (longitud(nueva_accion) > 0 && (objetivo != -1)) {
            smoke.confirm('GRABAR NUEVA ACCION , EN ESPERA DE ACTIVACION (ADMIN. DIPLEG)??', function(e) {
                $("#enviar_accion,#cancelar_accion").hide();
                $("#tabla_nueva_accion").show();
                $("#accion_nueva_procesando").show();
                if (e) {
                    datos = {
                        "opcion": 9
                    };
                    datos.componente = $("#componente").val();
                    datos.objetivo_operativo = $("#accion_listado_oo").val();
                    datos.accion = nueva_accion;
                    $.ajax({
                        async: false,
                        type: "GET",
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded",
                        url: "jquery/poa_d.php",
                        data: datos,
                        success: resultadosna
                    });
                } else {
                    $("#enviar_accion,#cancelar_accion").show();
                }
            });
        } else {
            smoke.alert("POR FAVOR INGRESE LOS DATOS CORRECTOS");
            cargando_formulario(2, $("#tabla_nueva_accion"));
            $("#accion_nueva_accion").focus();
        }
    });
    $("#cancelar_accion").click(function() {
        cargando_formulario(2, $("#tabla_nueva_accion"));
    });
}

function resultadosna(dator) {
    smoke.alert(dator.mensaje);
    if (dator.fila_afectada != -1) {
        cargando_formulario(2, $("#tabla_nueva_accion"));
    } else {
        smoke.alert(dator.mensaje);
    }
}
/*FINAL PARA NUEVAS ACCION*/
/*INICIO PARA NUEVOS INDICADOR*/
function agregar_nuevo_indicador() {
    $("#agregar_indicador").click(function() {
        $("#indicador_descripcion_accion").hide(); // ocutlar la descrpcion /
        $("#indicador_nueva_procesando").hide();
        cargando_formulario_xy(1, $("#tabla_nuevo_indicador"), "5%", "5%"); // visualizar tabla
        $("#tabla_nueva_indicador").css('cursor', 'auto'); // cambiar el cursor
        $("#indicador_enviar,#indicador_cancelar").show(); // visualizar los botones
        $("#indicador_nuevo_indicador").val(""); // poner el blanco en nuenvo campo
        $("#indicador_nuevo_indicador").removeAttr("disabled"); // habilitar para el nuenvo campos /
        // BORRAR EL EVENTO CARGADO A LOS CAMPOS
        $("#indicador_listado").unbind("change");
        $("#indicador_enviar").unbind("click");
        indicador_cargar_acciones();
        indicador_change_acciones();
        acciones_cancelar_grabar_indicador();
    });
}

function indicador_cargar_acciones() {
    datos = {
        "opcion": 10
    };
    datos.componente = $("#componente").val();
    $.getJSON("jquery/poa_d.php", datos, function(data) {
        g_data_acciones = data;
        if (data.fila_afectada != -1) {
            if (data.fila_afectada != 0) {
                $("#indicador_listado").html("");
                $("#indicador_listado").append("<option value=-1>Seleccione</option>");
                for (i = 0; i < data.fila_afectada; i++) {
                    $("#indicador_listado").append("<option value=" + data[i]['ID'] + ">" + data[i]['NOMBRE'] + "</option>");
                }
                $("#indicador_listado").width("250px");
            } else {
                smoke.alert("NO HAY ACCIONES");
            }
        } else {
            smoke.alert(data.mensaje);
        }
    });
}

function indicador_change_acciones() {
    $("#indicador_listado").change(function() {
        var valor = $(this).val();
        var sw = 0;
        $("#indicador_descripcion_accion").hide("slow");
        for (i = 0; i < g_data_acciones.fila_afectada; i++) {
            if (valor == g_data_acciones[i]['ID']) {
                $("#indicador_descripcion_accion").val(g_data_acciones[i]['NOMBRE']);
                sw = 1;
            }
        }
        if (sw == 1) {
            $("#indicador_descripcion_accion").show("slow");
        } else {
            $("#indicador_descripcion_accion").hide("slow");
        }
    });
}

function acciones_cancelar_grabar_indicador() {
    $("#indicador_enviar").click(function() {
        $("#tabla_nueva_indicador").hide();
        var nueva_indicador = $("#indicador_nuevo_indicador").val();
        var accion = $("#indicador_listado").val();
        if (longitud(nueva_indicador) > 0 && (accion != -1)) {
            smoke.confirm('GRABAR NUEVO INDICADOR, EN ESPERA DE ACTIVACION (ADMIN. DIPLEG)??', function(e) {
                $("#indicador_enviar,#indicador_cancelar").hide();
                $("#tabla_nueva_indicador").show();
                $("#indicador_nueva_procesando").show();
                if (e) {
                    datos = {
                        "opcion": 11
                    };
                    datos.accion = $("#indicador_listado").val();
                    datos.indicador = $("#indicador_nuevo_indicador").val();
                    $.ajax({
                        async: false,
                        type: "GET",
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded",
                        url: "jquery/poa_d.php",
                        data: datos,
                        success: resultadosni
                    });
                } else {
                    $("#indicador_enviar,#indicador_cancelar").show();
                }
            });
        } else {
            smoke.alert("POR FAVOR INGRESE LOS DATOS CORRECTOS");
            cargando_formulario(2, $("#tabla_nueva_indicador"));
            $("#indicador_nueva_indicador").focus();
        }
    });
    $("#indicador_cancelar").click(function() {
        cargando_formulario(2, $("#tabla_nueva_indicador"));
    });
}

function resultadosni(dator) {
    smoke.alert(dator.mensaje);
    if (dator.fila_afectada != -1) {
        cargando_formulario(2, $("#tabla_nueva_indicador"));
    } else {
        smoke.alert(dator.mensaje);
        $("#indicador_enviar,#indicador_cancelar").show();
        $("#indicador_nueva_procesando").hide();
    }
}
/*FINAL PARA NUEVOS INDICADOR*/
//hasta aqui implementado
function ejecute_agregar_empleado() {
    var direccion = "a_empleado_t.php?acceso=factura";
    //          var ancho = screen.availWidth;
    var ancho = 700 + "px";
    //          var ancho = 500+"px";
    var alto = screen.availHeight;
    var alto = 250 + "px";
    //          var alto = 300+"px";
    //          cadena="left=0,top=0,border=0,status=no,scrollbars=yes,toolbar=no,menubar=no,location=yes,resizable=yes,directories=no,width=" + ancho + ",height=" + alto;
    cadena = "left=0,top=0,border=0,status=no,scrollbars=no,toolbar=no,menubar=no,location=no,resizable=no,directories=no,width=" + ancho + ",height=" + alto;
    var w = (window.open(direccion, "_blank", cadena));
}

function informativo_pedi() {
    var purl = "";
    datos = {
        "opcion": 7
    };
    $.post("jquery/eje.php", datos, function(data) {
        if (data.fila_afectada > 0) {
            var cadena = "";
            cadena = "<ul>";
            for (i = 0; i < data.fila_afectada; i++) {
                if (i == 0) {
                    cadena += "<li class='novedad_titulo_importante_mas'> PRESENTACION" + b64d(data[i]['NOMBRE']) + "</li>";
                    cadena += "<li class='novedad_detalle_mas'>" + b64d(data[i]['DESCRIPCION']) + "</div>";
                } else {
                    cadena += "<li class='novedad_titulo_importante_mas'> EJE  :" + b64d(data[i]['NOMBRE']) + "</li>";
                    cadena += "<li class='novedad_detalle_mas'>" + b64d(data[i]['DESCRIPCION']) + "</div>";
                }
            }
            cadena += "</ul>";
            $("#eje_pedi").html("");
            $("#eje_pedi").append(cadena);
            $("#eje_pedi").dwdinanews({
                retardo: 1000,
                tiempoAnimacion: 1000,
                funcionAnimacion: 'easeInOutElastic'
            });
        } else {}
    }, "json");
}

function cargar_lineamientos() {
    cadena = "<center><H2><a class='centrorojo18' href='docs/lineamientos.pdf'><H1>LINK DE LINEAMIENTOS PROFORMA</H1> </a></center>";
    // CARGA LINEAMIENTOS 2023 INICIAL
    //    ma("LIMEAMIENTOS PROFORMA ", cadena);
}

function notificaciones_generales() {
    //   ma("INFORMACION","PARA DIRECCIONES : FECHA DE CIERRA DE OPCIONDE NUEVOS BIENES / SERVICIOS VIERNES 22 DE JULIO DEL 2022 13:00");
    //DEL INICIO 2023
    // ma("INFORMACION","FECHA DE CIERRE DEL SISTEMA MODULO PAC 23 DE JULIO DEL 2022 23:59");
    // sobre la actualizacion del poa
    ma("Info", "FECHA DE CIERRE DEL SISTEMA MODULO POA ACTUALIZACION  11 DE ABRIL DEL 2023 23:59");
}
/** 2024 , 2025 */
function validar_actualizacion_datos() {
    var verifica_token = parseInt($("#verifica_token").val());
    console.log(verifica_token);
    if (verifica_token == 0) { // aun no se solicita token 
        console.log(0);
        setTimeout(function() {
            $('#datos-modal0').dialog('open'); // Abre el modal usando jQuery EasyUI
        }, 1000);
        $("#banderamenu").hide();
        $("#header").hide();
        //$('#datos-modal0').dialog('close'); // Abre el modal usando jQuery EasyUI
        $('#datos-modal1').dialog('close'); // Abre el modal usando jQuery EasyUI
    }
    if (verifica_token == 1) { // token solicitado 
        setTimeout(function() {
            $('#datos-modal1').dialog('open'); // Abre el modal usando jQuery EasyUI
        }, 10);
        $("#banderamenu").hide();
        $("#header").hide();
        $("#correouta_notificado").val($("#correouta").val());
        //$('#datos-modal0').dialog('close'); // Abre el modal usando jQuery EasyUI
        $('#datos-modal0').dialog('close'); // Abre el modal usando jQuery EasyUI
    }
    if (verifica_token == 2) {
        $('#datos-modal1').dialog('close'); // Abre el modal usando jQuery EasyUI
        $('#datos-modal0').dialog('close'); // Abre el modal usando jQuery EasyUI
        $("#banderamenu").show();
        $("#header").hide();
    }
}
/**
function enviar_token() {
    $("#validarCorreoForm0").form("submit", {
        url: 'jquery/usuarios.php?opcion=27',
        onSubmit: function() {
            return $(this).form("validate");
        },
        success: function(result) {
            var result = eval('(' + result + ')');
            ms("Info", result.mensaje)
            if (result.fila_afectada >= 0) {
                ms("Info", result.mensaje);
            } else {
                ms("Info", result.mensaje);
            }
        }
    });
}
*/
function enviar_token() {
    $('#validarCorreoForm0').form({
        url: 'jquery/usuarios.php?opcion=27',
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(response) {
            try {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.fila_afectada > 0) {
                    // Validación exitosa: proceder con el envío del token
                    $.messager.progress({
                        title: 'Por favor espere',
                        msg: 'Generado token y Enviando el correo de verificación...'
                    });
                    $.ajax({
                        url: 'jquery/usuarios.php?opcion=28', // Script para generar y enviar el token
                        method: 'POST',
                        data: {
                            correouta: $('#correouta').val()
                        },
                        success: function(tokenResponse) {
                            $.messager.progress('close');
                            try {
                                console.log(tokenResponse);
                                var tokenJson = JSON.parse(tokenResponse);
                                console.log(tokenJson);
                                if (tokenJson.fila_afectada > 0) {
                                    ms("OK", 'Token enviado correctamente: ' + tokenJson.mensaje);
                                    $('#datos-modal0').dialog('close');
                                    $('#datos-modal1').dialog('open');
                                    $("#verifica_token").val(tokenJson.VERIFICADO_TOKEN);
                                    $("#correouta_notificado").val($("#correouta").val());
                                    setTimeout(validar_actualizacion_datos(), 2000);
                                } else {
                                    ma("Infom", 'Error al enviar el token: ' + $('#correouta').val());
                                }
                            } catch (e) {
                                ma("Error", 'Ocurrió un error inesperado al enviar el token. vuelva a intentar');
                            }
                        },
                        error: function() {
                            $.messager.progress('close');
                            ma("Info", 'No se pudo enviar el token. Inténtelo más tarde.');
                        }
                    });
                } else {
                    ma("Error", 'Error al validar el correo: ' + jsonResponse.mensaje);
                }
            } catch (e) {
                ma("Error", 'Ocurrió un error inesperado. Intente de nuevo.');
            }
        }
    });
}

function validar_token() {
    $('#validarCorreoForm1').form({
        url: 'jquery/usuarios.php?opcion=29&verifica_token=1',
        onSubmit: function() {
            return $(this).form('validate');
        },
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.fila_afectada > 0) {
                // Validación exitosa: proceder con el envío del token
                $.messager.progress({
                    title: 'Por favor espere',
                    msg: 'Generado token y Enviando el correo de verificación...'
                });
                $.messager.progress('close');
                try {
                    //console.log(jsonResponse);
                    if (jsonResponse.fila_afectada > 0) {
                        ms("OK", jsonResponse.mensaje);
                        $('#datos-modal0').dialog('close');
                        $('#datos-modal1').dialog('open');
                        $("#verifica_token").val(2);
                        validar_actualizacion_datos();
                        g_cancelar("home.php");
                    } else {
                        ma("Info", jsonResponse.mensaje);
                    }
                } catch (e) {
                    ma("Error", 'Ocurrió un error inesperado al validar el token. vuelva a intentar');
                }
            } else {
                ma("Error", 'Error al validar el token : ' + jsonResponse.mensaje);
            }
        }
    });
}