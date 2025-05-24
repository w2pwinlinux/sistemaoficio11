<?php
/**
* @author Desarrollado por Wcunalata@2024
* PARA CONSULTA GLOBAL O DETALLADO
*/
require_once "autoload_q.php";
vsmedoogn($cn);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE><?php echo $site ?></TITLE>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/ico" href="favicon.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style_tooltip.css?dd=2" type="text/css">
    <link rel="stylesheet" href="css/style_modal.css?dd=2" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style_extra.css?dd=2">
    <style type="text/css">
    #motivo {
    width: 100%;           /* Ancho 100% para que ocupe todo el espacio disponible */
    height: 20vh;          /* Altura responsiva, 60% de la altura de la ventana */
    padding: 10px;         /* Espaciado interno para que el texto no esté pegado al borde */
    border: 1px solid #ccc; /* Borde del textarea */
    border-radius: 4px;    /* Esquinas redondeadas */
    resize: vertical;      /* Permitir cambiar el tamaño verticalmente */
    box-sizing: border-box; /* Incluir el padding en el cálculo del ancho */
    }
    </style>
    <style type="text/css">
    
    /* Contenedor principal del formulario para distribuir en filas */
    .form-row {
    display: flex;
    flex-wrap: wrap;  /* Permite que las columnas se acomoden en múltiples filas si es necesario */
    gap: 20px; /* Espacio entre las columnas */
    }
    /* Cada columna dentro de la fila */
    .form-column {
    /**   flex: 1;*/ /* Cada columna ocupa el mismo espacio */
    /**min-width: 300px;*/ /* Ancho mínimo para las columnas */
    flex: 1%; /* Las columnas ocupan el 48% del ancho (para dejar espacio entre ellas) */
    min-width: 45%; /* Ancho mínimo para mantener la estructura */|
    }
    /* Opcional: Estilo para los grupos de formulario */
    .form-group {
    margin-bottom: 15px; /* Espacio entre los campos */
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    }
    .form-group input {
    width: 75%;
    }
    .form-group label {
    width: 25%;
    }
    textarea {
    width: 100%; /* Hace que el textarea ocupe todo el ancho disponible */
    height: 100px; /* Ajusta la altura del textarea */
    }
    /* Para que el formulario no se desborde en pantallas pequeñas */
    @media (max-width: 768px) {
    .form-row {
    flex-direction: column;  /* En pantallas pequeñas, cambia a una columna */
    }
    .form-column {
    /**width: 100%;*/ /* Asegura que las columnas ocupen todo el ancho disponible */
    flex: 1 1 100%; /* Ocupa el 100% del ancho en dispositivos pequeños */
    }
    }
    </style>
  </HEAD>
  <BODY >
    <input type="hidden" name="ID_NIVEL" id="ID_NIVEL" value="<?php echo $_SESSION["level"] ?>">
    <input type="hidden" name="ID_USUARIO" id="ID_USUARIO" value="<?php echo $_SESSION["user"] ?>">
    <input type="hidden" name="input_title" id="input_title" value="Reporte Ordenes">
    <!--<div id="header"></div>-->
    <!--<div id="banderamenu"></div>-->
    <div class="easyui-layout div_principal" style="width:100%;height:1000px;padding:10px;border: thin solid #E0ECFF;" >
      <br/>
      <!-- Tooltip personalizado -->
      <div id="tooltip" class="custom-tooltip"></div>
      <!-- INCIO PASO 1-->
      <div id="dlg_paso1" class="easyui-dialog"
        title="Sistema:  Administración de Ordenes"
        data-options="iconCls:'icon-edit',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'100%',
        height: 'auto', minHeight: 800,
        "
        style="padding:10px;">
        <div id="hh" style="font-weight: bold;font-size: 18px;">
          Detalle Ordenes del sistema
          <p class="datos_paso1_certificacion"> </p>
        </div>
        <table id="dg_PASO1" class="easyui-datagrid dg_PASO1" title="--"
          data-options="
          header:'#hh',singleSelect:true,border:true,fit:true,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,
          pageSize:20,pageList:[10,20,30,50],
          onLoadSuccess: function() {}"
          toolbar="#toolbar_PAC_REVISION"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              <!--<th field="ID" width="10%"  >Id</th>-->
              <th field="ID" width="5%" >Id</th>
              <th field="Q_USUARIO_LOGIN" width="10%" >Vendedor</th>
              <th field="DATOS" width="35%" >Cliente</th>
              <th field="FECHA" width="10%" >Fecha</th>
              <th field="ESTADO" width="20%" >Estado</th>
              <th field="CREATED" width="20%"  >F.Creado</th>
            </tr>
          </thead>
        </table>
        <!-- PARA TOOLBAR -->
        <div id="toolbar_PAC_REVISION">
          <div id="filtros">
            <form id="form1" name="form1" method="get" action="#">
              <div id="hfiltro">Filtros<img src="images/add.png" name="addFiltro" width="48" height="48" id="addFiltro" onClick="fAddFiltro();">
              </div>
              <input type="button" id="buscar" value="Buscar" name="buscar" onclick="clic_buscar();" >
            </form>
          </div>
          <div>
            
            Cabecera :
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_open_nuevo_orden()" >Nuevo</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="q_open_dialog_edit()" >Editar</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="q_anular_orden(1)" >Anular</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" plain="true" onclick="" > || Detalle : </a>
            <!--<div class="menu-sep"></div>-->
            
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="q_open_nuevo_orden_detalle()" >Paso2 : Ir a Detalle Orden</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="q_orden_open_reporte()" >Paso3 : Reporte Individual</a>
            
            <!--<a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_edit_estado(1)" >Activar</a>-->
            
            <a href="home.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="#" >Cerrar Modulo</a>
          </div>
          <div class="opciones" >Opciones
            <div>Menu :
              <a href="#" class="easyui-linkbutton cerrar_menu" iconCls="icon-remove" plain="true" onclick="menu_open(0)" >Cerrar</a>
            </div>
          </div>
          <div class="btn-container reportes">Reporte :
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("pdf","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> PDF </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("excel","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> EXCEL </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("html","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> WEB </a> </div>
          </div>
        </div>
      </div>
      </div><!-- FIN PASO 1-->
      <!-- BOTONES DE DIALOG-->
      <!-- INCIO PARA APROBAR PRESUPUESTOS -->
      <div id="dlg_paso0_cabecera_orden" class="easyui-dialog"
        title="Datos ORDENES "
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:20,
        width:'100%'"
        style="padding:10px;background: #ffffff;">
        <!--<form id="dlg_paso0_cabecera_presupuesto_form" method="post" class="easyui-form" action="#">-->
        <form id="dlg_paso0_cabecera_orden_form" class="easyui-form" method="post" novalidate enctype="multipart/form-data">
          <div class="modal-content2">
            <!-- Contenedor de filas para las columnas -->
            <div class="form-row">
              <div class="form-column">
                <div class="form-group">
                  <label for="COLECCION">Cliente:</label>
                  <input id="Q_CLIENTE_NOMBRE" class="easyui-combobox texto" name="Q_CLIENTE_NOMBRE"
                  data-options="
                  valueField:'ID',
                  textField:'NOMBRE',
                  url:'jquery/q_cliente1_jquery.php?opcion=5',
                  required:true,
                  editable:true,  /* Permite autocompletar */
                  panelHeight:'auto',
                  onSelect: function(record) {
                  $('#Q_CLIENTE_CIUDAD').val(record.CIUDAD); // Llena el campo ciudad
                  $('#Q_CLIENTE_DIRECCION').val(record.DIRECCION); // Llena el campo ciudad
                  }
                  ">
                </div>
                <div class="form-group">
                  <label for="REFERENCIA">Ciudad: </label>
                  <input type="text" id="Q_CLIENTE_CIUDAD" name="Q_CLIENTE_CIUDAD" maxlength="100" class="easyui-validatebox texto" data-options="required:true" disabled="disabled">
                </div>
              </div>
              <div class="form-column">
                <div class="form-group">
                  <label for="REFERENCIA">Direccion:</label>
                  <input type="text" id="Q_CLIENTE_DIRECCION" name="Q_CLIENTE_DIRECCION" maxlength="100" class="easyui-validatebox texto" data-options="required:true" disabled="disabled">
                </div>
                <div class="form-group">
                  <label for="FECHA">Fecha:</label>
                  <input id="FECHA" name="FECHA" class="easyui-datebox texto"  data-options="required:true, formatter:myformatter, parser:myparser">
                </div>
              </div>
              <div class="form-row">
                <!-- Botones de acción -->
                <div class="form-group">
                  <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="q_grabar_nuevo_orden()">Continuar</a>
                </div>
                <div class="form-group">
                  <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick='$("#dlg_paso0_cabecera_orden").dialog("close");''>Cancelar</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- -FIN DE APROBAR PRESUPUESTOS-->
      <div id="dlg_message" class="easyui-dialog"
        title="Mensaje sistema"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'48%',
        height:'70%'"
        style="padding:10px;">
        <div class="modal-content2">
          <h2>Mensaje</h2>
          <div class="form-group dlg_message_detalle">
          </div>
        </div>
        <div class="form-group">
          <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick="$('#dlg_message').dialog('close')">Cerrar</a>
        </div>
      </div>
      <!-- dialgo para mostrar imagen -->
      <div id="dlgImagen" class="easyui-dialog"
        title="Datos Colecciones "
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        closable:true,
        modal:true,
        top:20,
        width:'80%',
        onOpen: function() {
        $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
        $('#dlgImagen').dialog('close');
        }
        });
        },
        "
        style="padding:10px;background: #ffffff;" >
        <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick='$("#dlgImagen").dialog("close");''>Cerrar</a>
        <img id="imgVistaPrevia" src="" style="width: 100%; height: auto;">
      </div>
      <!-- INCIO PARA ENCABEZADO -->
      <!-- INCIO PASO 2-->
      
      <div id="dlg_paso2" class="easyui-dialog"
        title="Sistema:  Administración de Detalle Ordenes"
        data-options="iconCls:'icon-edit',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'100%',
        height: 'auto', minHeight: 800,
        "
        style="padding:10px;">
        <div id="hh2" style="font-weight: bold;font-size: 18px;">
          Detalle Ordenes Paso2 : Colección Existente y stock
          <p class="datos_paso1_certificacion"> </p>
        </div>
        <div id="hh3" style="font-weight: bold;font-size: 18px;">
          Detalle Ordenes Paso3: Detalle cargado
          <p class="datos_paso1_certificacion"> </p>
        </div>
        
        <!--<div style="display: flex; gap: 10px; height: 100%;">-->
        <table id="dg_PASO2" class="easyui-datagrid dg_PASO2" title="--"
          data-options="
          header:'#hh2',singleSelect:true,border:true,fit:false,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,
          pageSize:5,pageList:[5,10,20,30,50],
          onLoadSuccess: function() {}"
          toolbar="#toolbar_PAC_REVISION2"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              <!--<th field="ID" width="10%"  >Id</th>-->
              <th field="ANEXO1" width="10%" formatter="imagenFormatter100">Imagen</th>
              <th field="REFERENCIA" width="10%" >Referencia</th>
              <th field="DATOS" width="40%" >Descripción</th>
              <th field="STOCK" width="40%" >Stock</th>
              
              
              
              <!--<th field="CREATED" width="10%"  >F.Creado</th>-->
              <!--<th field="ESTADO" width="10%" >Estado</th>-->
              
            </tr>
          </thead>
        </table>
        <!-- PARA TOOLBAR -->
        <div id="toolbar_PAC_REVISION2">
          
          <div id="filtros">
            <form id="form1_" name="form1_" method="get" action="#">
              <div id="hfiltro2">Filtros<img src="images/add.png" name="addFiltro" width="48" height="48" id="addFiltro" onClick="fAddFiltro2();">
              </div>
              <input type="button" id="buscar" value="Buscar" name="buscar" onclick="clic_buscar2();" >
            </form>
          </div>
          <div>
            
            Opciones:
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="q_open_add_orden_detalle()" >Agregar a detalle</a>
            
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_finalizar_orden(1)" >Finalizar Orden</a>
            
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="q_undo(2)" >Regresar</a>
            
            
            <a href="home.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="#" >Cerrar Modulo</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="q_orden_open_reporte_borrador()" > Reporte Individual Borrador</a>
            
          </div>
          
          
        </div>
        <table id="dg_PASO3" class="easyui-datagrid dg_PASO3" title="--"
          data-options="
          header:'#hh3',singleSelect:true,border:true,fit:false,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,
          pageSize:5,pageList:[5,10,20,30,50],
          onLoadSuccess: function() {}"
          toolbar="#toolbar_PAC_REVISION3"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              <th field="ID" width="10%" >Id</th>
              <th field="DATOS" width="30%" >Datos</th>
              <th field="PEDIDO" width="30%" >Pedido</th>
              <th field="ESTADO" width="20%" >Estado</th>
              <th field="CREATED" width="10%"  >F.Creado</th>
            </tr>
          </thead>
        </table>
        <div id="toolbar_PAC_REVISION3">
          <!--<div id="filtros">
            <form id="form1" name="form1" method="get" action="#">
              <div id="hfiltro">Filtros<img src="images/add.png" name="addFiltro" width="24" height="24" id="addFiltro" onClick="fAddFiltro();">
              </div>
              <input type="button" id="buscar" value="Buscar" name="buscar" onclick="clic_buscar();" >
            </form>
          </div>-->
          <div>
            
            Opciones:
            <!--<a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_open_nuevo_orden()" >Nuevo</a>-->
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="q_open_add_orden_detalle_edit()" >Editar Detalle</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="q_anular_orden_detalle(1)" >Eliminar Detalle</a>
            
            <!--<div class="menu-sep"></div>-->
            
            
            <!--<a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_edit_estado(1)" >Activar</a>-->
            
            
          </div>
          <div class="opciones" >Opciones
            <div>Menu :
              <a href="#" class="easyui-linkbutton cerrar_menu" iconCls="icon-remove" plain="true" onclick="menu_open(0)" >Cerrar</a>
            </div>
          </div>
          <!--
          <div>Reporte :
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("pdf","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> PDF </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("excel","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> EXCEL </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("html","jquery/q_orden1_jquery.php",99,$("#input_title").val(),6)'> WEB </a> </div>
          </div>-->
        </div>
        
        
      </div>
      <!-- FIN PASO 2-->
      <!-- add dlg para agregar detalle de la orden -->
      <div id="dlg_paso2_orden_detalle_add" class="easyui-dialog"
        title="Datos Colecciones Agregar a Orden "
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:20,
        width:'100%'"
        style="padding:10px;background: #ffffff;">
        <!--<form id="dlg_paso2_orden_detalle_add_form" method="post" class="easyui-form" action="#">-->
        <form id="dlg_paso2_orden_detalle_add_form" class="easyui-form" method="post" novalidate enctype="multipart/form-data">
          
          <div class="modal-content2">
            <!-- Contenedor de filas para las columnas -->
            
            <div class="form-row">
              <div class="form-column">
                <div class="form-group">
                  <input type="hidden" readonly="readonly"  id="ID" class="easyui-validatebox texto" name="ID">
                  <label for="COLECCION">Colección:</label>
                  <input readonly="readonly"  id="COLECCION" class="easyui-combobox texto" name="COLECCION"
                  data-options="valueField:'NOMBRE', textField:'NOMBRE', url:'jquery/q_coleccion_tipo_jquery.php?opcion=5', required:true, editable: false, panelHeight: 'auto'">
                  
                </div>
                <div class="form-group">
                  
                  <label for="TIPO">Tipo:</label>
                  <input readonly="readonly" id="TIPO" class="easyui-combobox texto" name="TIPO"
                  data-options="valueField:'NOMBRE', textField:'NOMBRE', url:'jquery/q_tipo_jquery.php?opcion=5', required:true, editable: false, panelHeight: 'auto'">
                </div>
                <div class="form-group">
                  
                  <label for="MARCA">Marca:</label>
                  <input readonly="readonly" id="MARCA" class="easyui-combobox texto" name="MARCA"  data-options="valueField:'NOMBRE', textField:'NOMBRE', url:'jquery/q_categoria.php?opcion=5', required:true, editable: false, panelHeight: 'auto'">
                  
                </div>
                <div class="form-group cc">
                  
                  <label for="REFERENCIA">Referencia:</label>
                  <input readonly="readonly" type="text" id="REFERENCIA" name="REFERENCIA" maxlength="50" class="easyui-validatebox texto" data-options="required:true">
                </div>
                <div class="form-group cc">
                  <label for="DESCRIPCION">Descripción:</label>
                  <input readonly="readonly" type="text" id="DESCRIPCION" name="DESCRIPCION" maxlength="50" class="easyui-validatebox texto" data-options="required:true">
                  
                  <label for="COLOR">Color:</label>
                  <input readonly="readonly" type="text" id="COLOR" name="COLOR" maxlength="50" class="easyui-validatebox texto" data-options="required:true">
                </div>
              </div>
              <div class="form-column">
                <div class="form-group">
                  <label for="TALLA26">Talla 6-26-XS:</label>
                  <input type="text" id="TALLA26" name="TALLA26" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA26" data-options="required:true, validType:'numero'">
                  
                </div>
                <div class="form-group">
                  <label for="TALLA28">Talla 8-28-S:</label>
                  <input type="text" id="TALLA28" name="TALLA28" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA28" data-options="required:true, validType:'numero'">
                </div>
                
                <div class="form-group">
                  <label for="TALLA30">Talla 10-30-M:</label>
                  <input type="text" id="TALLA30" name="TALLA30" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA30"  data-options="required:true, validType:'numero'">
                  
                </div>
                <div class="form-group">
                  <label for="TALLA32">TALLA 12-32-L:</label>
                  <input type="text" id="TALLA32" name="TALLA32" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA32"  data-options="required:true, validType:'numero'">
                  
                </div>
                <div class="form-group">
                  <label for="TALLA34">Talla 14-34-XL:</label>
                  <input type="text" id="TALLA34" name="TALLA34" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA34"  data-options="required:true, validType:'numero'">
                  
                </div>
                <div class="form-group">
                  <label for="TALLA36">Talla 16-36:</label>
                  <input type="text" id="TALLA36" name="TALLA36" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA36"  data-options="required:true, validType:'numero'">
                </div>
                
                <div class="form-group">
                  <label for="TALLA38">Talla 18-38:</label>
                  <input type="text" id="TALLA38" name="TALLA38" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA38"  data-options="required:true, validType:'numero'">
                  
                </div>
                <div class="form-group">
                  <label for="TALLA40">Talla 20-40:</label>
                  <input type="text" id="TALLA40" name="TALLA40" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA40"  data-options="required:true, validType:'numero'">
                </div>
                
                <div class="form-group">
                  <label for="TALLA44">Talla 22-42:</label>
                  <input type="text" id="TALLA42" name="TALLA42" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA42"  data-options="required:true, validType:'numero'">
                </div>
                <div class="form-group">
                  <label for="TALLA44">Talla 24-44:</label>
                  <input type="text" id="TALLA44" name="TALLA44" maxlength="50" class="easyui-validatebox texto talla-input" data-talla="TALLA44"  data-options="required:true, validType:'numero'">
                </div>
              </div>
              
            </div>
            
            <div class="form-row">
              <!-- Botones de acción -->
              <div class="form-group">
                <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="q_grabar_nuevo_orden_detalle()">Continuar</a>
                
              </div>
              <div class="form-group">
                <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick='$("#dlg_paso2_orden_detalle_add").dialog("close");''>Cancelar</a>
                
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- fin de add dlg para agrar detalle-->
    </body>
    <script  language="javascript" src="js/q_orden1_js.js?<?php echo r_v_2024(); ?>" ></script>
  </html>