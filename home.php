<?php
/**
* @author Desarrollado por Wcunalata@2025*
*/
require_once "autoload_q.php";
vsmedoogn($cn);
//pf($_SESSION,0);
/**
* @details [long description]
*/
// AL INCICO CARGAR EL ID
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE><?php echo $site ?></TITLE>
    <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
    <link rel="shortcut icon" type="image/ico" href="favicon.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--<link rel="stylesheet" href="css/style_tooltip.css" type="text/css">-->
    <!--<link rel="stylesheet" href="css/style_modal.css" type="text/css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style type="text/css">
    #banderamenu2 {
    position: relative;
    }
    .menu {
    list-style: none;
    padding: 10;
    margin: 10;
    background: #001f3f;
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 40px;
    left: 0;
    width: 100%;
    display: none; /* Oculto por defecto */
    font-size:30px;
    }
    .menu li {
    padding: 20px;
    }
    .menu a {
    text-decoration: none;
    color: #fff;
    display: block;
    }
    .menu-icon {
    background: none;
    border: none;
    font-size: 24px;
    color: black;
    cursor: pointer;
    position: absolute;
    top: 5px;
    left: 10px;
    width: 50px;
    height:50px;
    transition: transform 0.3s ease-in-out;
    }
    /* Mostrar menú cuando está activo */
    .menu.active {
    display: flex;
    }
    .menu-icon.active {
    content: "✖"; /* Cambia el ícono */
    }
    .modulo{
    
    font-weight: bold;
    background-color: #fff;
    }
    .modulo2{
    
    font-weight: bold;
    
    }
    
    .menu li {
    position: relative;
    }
    .menu li::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 3px;
    background: #0074D9;
    transition: width 0.3s ease-in-out;
    }
    .menu li:hover::after {
    width: 100%;
    }
    #menuToggle {
    transform: scale(3.5); /* Aumenta el tamaño al 150% */
    }
    </style>
    <style>
    ul {
    list-style: none;
    padding: 0;
    }
    li {
    padding: 20px;
    font-size: 28px;
    margin-bottom: 20px; /* Espacio entre cada elemento del menú */
    }
    i {
    margin-right: 10px; /* Espacio entre el icono y el texto */
    }
    li i {
    font-size: 10px; /* Ajusta el tamaño del icono */
    }
    
    @media screen and (max-width: 768px) {
    .menu li {
    padding: 50px; /* Aumenta el espacio interno */
    margin-bottom: 30px; /* Espacio entre los elementos */
    font-size: 24px; /* Ajusta el tamaño del texto si es necesario */
    }
    #menuToggle {
    transform: scale(10); /* Aumenta más el tamaño en móviles */
    font-size: 40px; /* Ajusta el tamaño de la fuente */
    width: 70px;
    height: 70px;
    }
    }
    
    </style>


 <style>
  .menu2 {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menu2 li {
    margin-bottom: 15px;
  }

  .menu2 li a {
    display: flex;
    align-items: center;        /* Centra verticalmente */
    justify-content: center;    /* Centra horizontalmente */
    background-color: #001f3f;  /* Azul */
    color: white;
    height: 70px;               /* Altura del botón */
    font-size: 22px;            /* Tamaño del texto */
    font-weight: bold;
    border-radius: 10px;
    text-decoration: none;
    transition: background-color 0.3s;
  }

  .menu2 li a:hover {
    background-color: #0056b3;
  }

  .menu2 li a .fa {
    margin-right: 10px;
    font-size: 24px;
  }
</style>



  </HEAD>
  <BODY style="background: #fff;" >
    <input type="hidden" name="LEVEL" id="LEVEL" value="<?php echo $_SESSION["level"]?>">
    <div id="banderamenu2">
      <!-- style="border: medium solid black"-->
      <button id="menuToggle" class="menu-icon" >&#9776;</button>
      <ul id="menuList" class="menu">
        
        <li><a href="q_orden1.php">Orden</a></li>
        <li><a href="#">Salir</a></li>
      </ul>
      
    </div>
    
    <!--<div class="easyui-layout div_principal" data-options="fit:true" style="color:#fff">-->
    <div style="padding: 100px;">
      <img src="images/inicial2.png" style="max-width: 100%; height: auto;">
    </div>
    <!--</div>-->
    
    <div class="titulo2" style="color:#000;padding: 10px;text-align: center;font-size:50px;font-weight: 500;">ESPECIALISTAS EN DENIM</div>
    <div class="div_menu2">
      <ul id="menuList2" class="menu2">
        <li><a href="jquery/logout.php">Salir</a></li>
      </ul>
      
    </div>
    
    
  </body>
  <script type="text/javascript">
  document.getElementById("menuToggle").addEventListener("click", function () {
  let menu = document.getElementById("menuList");
  menu.classList.toggle("active");
  this.classList.toggle("active");
  // Cambiar el ícono entre "☰" (hamburguesa) y "✖" (cerrar)
  if (this.classList.contains("active")) {
  this.innerHTML = "✖";
  } else {
  this.innerHTML = "☰";
  }
  });
  </script>
  <script type="text/javascript" src="js/home_menu_js.js?<?php echo r_v_2024(); ?>" ></script>
  
  <!-- <script  language="javascript" src="js/pac_ejecucion_certificacion.js?<?php echo r_v_2024(); ?>" ></script>-->
</html>