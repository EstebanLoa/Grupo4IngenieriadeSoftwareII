<?php
  require 'Database.php';
  $clientes="Cliente";
  $empleados="Empleado";
  //Verifica que los campos de email y contraseña esten llenos
  if (isset($_POST['btn-ingresar'])) {
    //Realiza un select a la tabla de la base de datos
    //Mediante el objeto de conexion. Prepare ejecuta un Query
    //Obtenermos los datos de la tabla, donde el email sea igual al parametro email que aun no lo he definido
    $records = $conn->prepare("SELECT id_usuario, username, password, categoria FROM usuario WHERE username = :username");
    //Vinculamos el parametro username, lo que obtenemos del metodo post del fomrulario
    $records->bindParam(':username', $_POST['username']);
    //Ejecutamos la Consulta
    $records->execute();
    //Obtener los datos, con una variable, y de esta son consulta su metodo fetch. Un array asociativo. 
    $results = $records->fetch(PDO::FETCH_ASSOC); // results=[Id_usuario][mail]  
    $message = '';
    $numRegistros = $records->rowCount(); //0
    if ($numRegistros > 0){ 
      //Vamos a verificar las contraseñas las contraseñas del navegador y del resultado del password de la bd
      if(password_verify($_POST['password'], $results['password'])) {
        //Lo asignamos en memoria, ejecutar y almacenar un dato. El Id del usuario. 
        $_SESSION['usuario_id'] = $results['id_usuario'];
          //Si emepleado es igual a la categoria de la bd
          if($empleados==$results['categoria']){
            //Es un empleado manda a la pantalla Admin
            header("Location: Admin.php?categoria=".$results['categoria']);
          }else{
            //Es un ciente, mandalo a la pantalla Cliente
            header("Location: Reservacion.php");
          }
      }else{
        $message = 'Sus credenciales son incorrectas';
      }
    } else {
      $message = 'Usuario no existe';
    }
    echo $message;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi ESPE</title>

    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <link href="libs/bootstrap_3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/Roboto.css" rel="stylesheet">
    <link href="css/custom-common.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/affe9412eb.js" crossorigin="anonymous"></script>

    <style>
        .row:before, .row:after {display: none !important;}
        .carousel-item h1 {
            color: #fff;
            font-size: 20px;
            margin: 75px auto;
            text-align: center;
        }

        .login-block r {

            width: 50%;
            margin: 0 auto;

        }

        .signup__overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
        }

        .login_sec {


            padding: 0px;
            background-color: #f8fafb;

        }

        .login_sec img {

            margin: 24px auto;

        }

        .banner-sec {
            /*background: url(/authenticationendpoint/images/sidebar-4.jpg) no-repeat left bottom;*/
            background-size: cover;
            min-height: 500px;
            max-height: auto;
            padding: 0;
        }

        .banner-sm {
            /*background: url(/authenticationendpoint/images/miespesm.png) no-repeat left bottom;*/
            background-size: cover;
            min-height: 500px;
            padding: 0;
        }

        .carousel-fade .carousel-item {
            opacity: 0;
            transition-duration: .6s;
            transition-property: opacity;
        }

        .carousel-indicators {

            bottom: -41px;
        }

        .carousel-indicators .active {
            background-color: #fff;
        }

        .carousel-fade .carousel-item.active,
        .carousel-fade .carousel-item-next.carousel-item-left,
        .carousel-fade .carousel-item-prev.carousel-item-right {
            opacity: 1;
        }

        .carousel-fade .active.carousel-item-left,
        .carousel-fade .active.carousel-item-right {
            opacity: 0;
        }

        .carousel-fade .carousel-item-next,
        .carousel-fade .carousel-item-prev,
        .carousel-fade .carousel-item.active,
        .carousel-fade .active.carousel-item-left,
        .carousel-fade .active.carousel-item-prev {
            transform: translateX(0);
            transform: translate3d(0, 0, 0);
        }

        .container {

            -webkit-box-shadow: 0 0.1875rem 1.5rem rgba(0, 0, 0, 0.2);
            box-shadow: 0 0.1875rem 1.5rem rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;
            margin-bottom: 5%;

        }

        .carousel-inner {
            border-radius: 0 10px 10px 0;
        }

        .carousel-caption {
            text-align: left;
            left: 5%;
        }

        .login-sec {
            padding: 50px 30px;
            position: relative;
        }

        .login-sec .copy-text {
            position: absolute;
            width: 80%;
            bottom: 20px;
            font-size: 13px;
            text-align: center;
        }

        .login-sec .copy-text i {
            color: #00713d;
        }

        .login-sec .copy-text a {
            color: #007bff;
        }

        .login-sec h2 {
            margin-bottom: 30px;
            font-weight: 800;
            font-size: 30px;
            color: #00713d;
        }

        .login-sec h2:after {
            content: " ";
            width: 100px;
            height: 5px;
            background: #00713d;
            display: block;
            margin-top: 8px;
            border-radius: 3px;
            margin-left: auto;
            margin-right: auto
        }


        .banner-text {
            width: 70%;
            position: absolute;
            bottom: 40px;
            padding-left: 20px;
        }

        .banner-text h2 {
            color: #fff;
            font-weight: 600;
        }

        .banner-text h2:after {
            width: 100px;
            height: 5px;
            background: #FFF;
            display: block;
            margin-top: 20px;
            border-radius: 3px;
        }

        .banner-text p {
            color: #fff;
        }

        /* login start */

        .container-login100-form-btn {
            margin: 0 auto;
            display: block;
            text-align: center;
            padding-top: 1%;
            padding-bottom: 2%;
        }

        .login100-form {
            width: 100%;
        }


        .validate-input {
            position: relative;
        }

        .wrap-input100 {
            width: 100%;
            position: relative;
            border-bottom: 2px solid #d9d9d9;
            margin-bottom: 5%;
        }

        .label-input100 {

            font-size: 14px;
            color: #333333;
            line-height: 1.5;
            padding-left: 7px;
        }

        textarea:focus,
        input:focus {
            border-color: transparent !important;
        }

        .input100:focus+.focus-input100::before {
            width: 100%;
        }



        .input100 {
            font-size: 12px;
            color: #333333;
            line-height: 1.2;
            display: block;
            width: 100%;
            height: 30px;
            background: transparent;
            padding: 0 7px 0 43px;
        }

        .focus-input100 {
            position: absolute;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .focus-input100::before {
            content: "";
            display: block;
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #7f7f7f;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .focus-input100::after {
            font-family: "FontAwesome";
            content: "\f007";
            color: #adadad;
            font-size: 22px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            height: calc(100% - 20px);
            bottom: 0;
            left: 0;
            padding-left: 13px;
            padding-top: 3px;
        }

        .focus-input100.password::after {
            font-family: "FontAwesome";
            content: "\f023";
            color: #adadad;
            font-size: 22px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            height: calc(100% - 20px);
            bottom: 0;
            left: 0;
            padding-left: 13px;
            padding-top: 3px;
        }

        input {
            outline: none;
            border: none;
        }



        .flex-c-m {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            -ms-align-items: center;
            align-items: center;
        }

        .login100-social-item {
            font-size: 12px;
            color: #fff;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin: 5px;
        }

        .bg1 {
            background-color: #00713d;
        }


        .bg3 {
            background-color: #ea4335;
        }


        @import url(https://fonts.googleapis.com/css?family=Raleway:400,500,700);
        @import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);


        /*movimiento del slider de las 6 imagenes*/

        @keyframes cambio {
            0% {
                margin-left: 0;
            }

            15% {
                margin-left: 0;
            }




            15% {
                margin-left: -100%;
            }

            30% {
                margin-left: -100%;
            }



            30% {
                margin-left: -200%;
            }

            45% {
                margin-left: -200%;
            }




            45% {
                margin-left: -300%;
            }

            60% {
                margin-left: -300%;
            }



            60% {
                margin-left: -400%;
            }

            75% {
                margin-left: -400%;
            }



            75% {
                margin-left: -500%;
            }

            90% {
                margin-left: -500%;
            }


            100% {
                margin-left: -600%;
            }

            120% {
                margin-left: -600%;
            }





        }

        figure.snip1477 {
            margin: auto;

            font-family: 'Raleway', Arial, sans-serif;
            position: absolute;
            padding-top: 0px;
            margin: 0%;
            overflow: hidden;
            width: 100%;
            height: 100%;
            color: #ffffff;
            font-size: 15px;
            background-color: #000000;

        }

        figure.snip1477 img {
            min-height: 1000px;
            max-height: 100%;
            backface-visibility: hidden;
            vertical-align: top;
            opacity: 0.9;
            background-size: cover;
            padding: 0;
            position: absolute;

        }

        figure.snip1477 ul {
            display: flex;
            padding: 0;
            width: 600%;
            background-size: cover;
            animation: cambio 25s infinite linear;
            animation-timing-function: step-end;
            margin-top: 0;

        }

        figure.snip1477 li {
            width: 100%;
            list-style: none;

        }



        figure.snip1477 figcaption {
            position: absolute;
            bottom: 50%;
            left: 25px;
            text-align: left;
            opacity: 0;
            padding: 5px 60px 5px 10px;
            font-size: 0.8em;
            font-weight: 500;
            letter-spacing: 1.5px;
        }

        figure.snip1477 figcaption p {
            margin: 0;
        }


        figure.snip1477:hover figcaption,
        figure.snip1477.hover figcaption {
            opacity: 1;
            -webkit-transition-delay: 0.2s;
            transition-delay: 0.2s;
        }

        figure.snip1477:hover img,
        figure.snip1477.hover img {
            zoom: 1;
            filter: alpha(opacity=35);
            -webkit-opacity: 0.35;
            opacity: 0.35;
        }

        figure.snip1477:hover .title:before,
        figure.snip1477:hover .title:after,
        figure.snip1477:hover .title div:before,
        figure.snip1477.hover .title div:before,
        figure.snip1477:hover .title div:after,
        figure.snip1477.hover .title div:after {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }

        figure.snip1477:hover .title:before,
        figure.snip1477.hover .title:after {
            -webkit-transition-delay: 0.15s;
            transition-delay: 0.15s;
        }


        figure.snip1477 *,
        figure.snip1477 *:before,
        figure.snip1477 *:after {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: all 0.55s ease;
            transition: all 0.55s ease;

        }

        figure.snip1477 .title {
            position: absolute;
            top: 50%;
            left: 25px;
            padding: 10px 10px 5px;

        }

        /*lineas de abajo y arriba*/

        figure.snip1477 .title:before,
        figure.snip1477 .title:after {
            height: 2px;
            width: 1300px;
            position: absolute;
            content: '';
            background-color: #ffffff;
        }

        figure.snip1477 .title:before {
            top: 0px;
            left: 10px;
            -webkit-transform: translateX(100%);
            transform: translateX(100%);
        }

        /*linea abajo*/
        figure.snip1477 .title:after {
            bottom: 15px;
            right: 15px;
            left: -880px;
            -webkit-transform: translateX(-100%);
            transform: translateX(-100%);
        }

        /*lados*/
        figure.snip1477 div:before,
        figure.snip1477 div:after {
            width: 2px;
            height: 680px;
            position: absolute;
            content: '';
            background-color: white;
        }

        /*lado solo izquierdo*/
        figure.snip1477 div:after {
            bottom: 27px;
            left: 0;
            -webkit-transform: translateY(-100%);
            transform: translateY(-100%);
        }

        /*lado solo derecho*/
        figure.snip1477 div:before {
            top: 10px;
            right: 0px;
            -webkit-transform: translateY(100%);
            transform: translateY(100%);

        }

        figure.snip1477 .title .bord .slider {
            position: center;

            overflow: hidden;
            background-color: transparent;
            width: 410px;
            height: 90px;

        }

        figure.snip1477 .title .bord .slider ul {
            display: flex;
            width: 600%;
            background-size: cover;
            animation: movimiento 25s infinite linear;
            animation-timing-function: step-end;

        }

        figure.snip1477 .title .bord .slider li {
            list-style: none;
        }

        @keyframes movimiento {
            0% {
                margin-left: 0;
            }

            15% {
                margin-left: 0;
            }

            15% {
                margin-left: -100%;
            }

            30% {
                margin-left: -100%;
            }

            30% {
                margin-left: -200%;
            }

            45% {
                margin-left: -200%;
            }

            45% {
                margin-left: -300%;
            }

            60% {
                margin-left: -300%;
            }



            60% {
                margin-left: -400%;
            }

            75% {
                margin-left: -400%;
            }



            75% {
                margin-left: -500%;
            }

            90% {
                margin-left: -500%;
            }


            100% {
                margin-left: -600%;
            }

            120% {
                margin-left: -600%;
            }

        }

        figure.snip1477 h2,
        figure.snip1477 h3,
        figure.snip1477 h4 {
            margin: 0;
            text-transform: uppercase;
        }

        figure.snip1477 h2 {
            font-weight: 300;
        }

        /* parte de  Mi Espe*/
        figure.snip1477 h3 {
            top: 0px;
            margin: 15px 430px -100px;

            width: 14%;
            font-weight: 400;
            text-shadow: rgb(235, 228, 228);
            background-color: #292424;
            padding: 24px 10px;
            color: #ffffff;
            text-align: left;
            font-size: 25px;
        }

        /*-------------------------------*/

        figure.snip1477 h4 {
            top: 100%;
            left: 25px;

            display: block;
            font-weight: 500;
            background-color: #ffffff;
            padding: 5px 10px 15px;
            color: #000000;
        }

        figure.snip1477 .title .bord .slider h2 {
            width: 140%;
            font-weight: 200;
            background-color: #292424;
            /*padding: 5px 10px;*/
            color: #ffffff;
            text-align: left;

        }

        /*parte blanca del texto*/
        figure.snip1477 .title .bord .slider h4 {

            display: block;
            font-weight: 700;
            background-color: #ffffff;
            padding: 10px 10px;
            color: #000000;
            text-align: center;

        }


        figure.snip1477 .title .bord .slider h4 {
            display: block;
            font-weight: 600;
            padding: 10px 5px;
            background-color: #ffffff;
            color: #000000;
            font-size: 20px;


        }

        /* -------fecto opup overlay*-----*/
        @import url(https://fonts.googleapis.com/css?family=Open+Sans);
        @import url(https://fonts.googleapis.com/css?family=Federo);

        /* overlay styles, all needed */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: #141212f1;
            z-index: 5;
        }

        /* just some content with arbitrary styles for explanation purposes */
        .modal {
            display: none;
        }

        .modal:target {

            display: block;
            position: fixed;
            background: rgba(0, 0, 0, 0.8);
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .imagen {
            top: 0;
            width: 100%;
            height: 50%;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .imagen a {
            color: rgb(252, 250, 250);
            font-size: 40px;
            text-decoration: none;
            margin: 0 10px;
            cursor: pointer;
        }


        .imagen a:nth-child(2) {
            margin: 0;
            height: 100%;
            flex-shrink: 2;
        }

        .imagen img {
            width: 100%;
            height: auto;
            max-width: 100%;
            border: 7px solid rgb(231, 231, 231);
            box-sizing: border-box;
        }

        /*.cerrar {
            color: rgb(252, 250, 250);
            font-size: 20px;
            text-decoration: none;
            margin: 0 10px;
            cursor: pointer;

            display: block;
            background: #fff;
            width: 35px;
            height: 38px;
            margin: 15px auto;
            text-align: center;
            text-decoration: none;
            font-size: 25px;
            color: #000;
            padding: 5px;
            border-radius: 50%;
            line-height: 25px;

        }

        /*EFECTO SLIDER*/
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: #141414ec;
            z-index: 5;

        }

        .overlay1 {
            width: 50%;
            margin: 100px auto;
            overflow: hidden;

        }

        .overlay1 ul {
            display: flex;
            padding: 0;
            width: 500%;

            animation: cambio3 30s infinite alternate linear;
            cursor: pointer;

        }


        .overlay1 li {
            width: 100%;
            list-style: none;
            cursor: pointer;

        }

        .overlay1 img {
            width: 100%;
            cursor: pointer;
        }

        @keyframes cambio3 {
            0% {
                margin-left: 0;
            }

            10% {
                margin-left: 0;
            }


            15% {
                margin-left: -100%;
            }

            25% {
                margin-left: -100%;
            }


            30% {
                margin-left: -200%;
            }

            45% {
                margin-left: -200%;
            }



            50% {
                margin-left: -300%;
            }

            65% {
                margin-left: -300%;
            }


            70% {
                margin-left: -400%;
            }

            100% {
                margin-left: -400%;
            }


        }

        /*botonSalir*/
        .button {

            width: 7%;
            cursor: pointer;
            display: inline-block;
            vertical-align: middle;
            padding: auto;
            border-radius: auto;
            background: none;
            margin: 0 0 0 -5px;

        }

        /*flechas de navegacion*/
        .triangulo {
            border-style: solid;
            border-width: 21px;
            width: auto;
            height: 0;
        }


        .triangulo.right {
            border-color: transparent transparent transparent black;
            top: -10px;
            left: -21px;
        }



        .triangulo.left {
            border-color: transparent black transparent transparent;
            top: -10px;
            left: -21px;

        }
    </style>

    <script>

        function checkSessionKey() {
            $.ajax({
                type: "GET",
                url: "/logincontext?sessionDataKey=" + getParameterByName("sessionDataKey") + "&relyingParty=" + getParameterByName("relyingParty") + "&tenantDomain=" + getParameterByName("tenantDomain"),
                success: function (data) {
                    if (data && data.status == 'redirect' && data.redirectUrl && data.redirectUrl.length > 0) {
                        window.location.href = data.redirectUrl;
                    }
                }
            });

        }


        function getParameterByName(name, url) {
            if (!url) {
                url = window.location.href;
            }
            name = name.replace(/[\[\]]/g, '\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return "";
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
    </script>

</head>

<body onload="checkSessionKey()">
    
    <!-- page content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-lg-8 banner-sm  hidden-xs visible-sm visible-md visible-lg">
                <figure class="snip1477">
                    <ul>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                        <li><img src="https://img.freepik.com/vector-gratis/joven-conduciendo-scooter-ciudad_23-2148573638.jpg?w=2000" alt="sample38" width="100%" height="auto" /></li>
                    </ul>
                    <div class="title">
                        <div class="bord">
                            <div class="slider">
                                <ul>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4><a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </i></a></h4>
                                    </li>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4><a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </i></a></h4>
                                    </li>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4><a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </i></a></h4>
                                    </li>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4> <a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </a></h4>
                                    </li>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4><a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </a></h4>
                                    </li>
                                    <li>
                                        <h2>&nbsp;&nbsp;SISTEMA INTEGRADO DE INFORMACIÓN</h2>
                                        <h4> <a href="https://miespe.espe.edu.ec" style="color:rgb(3, 3, 3);"> "Plataforma Mi ESPE" </a></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <figcaption>
                        <H2>UNIVERSIDAD DE LAS FUERZAS ARMADAS - ESPE</H2>
                    </figcaption>
                    <a href="#"></a>
                </figure>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="col-10 offset-1 hidden-xs hidden-sm text-center">
                    <img src="https://www.espe.edu.ec/wp-content/uploads/2018/11/espe.png" style="padding-top: 65px; width: 375; " 
                        class="img-fluid">
                </div>
                <div class="col-10 offset-1 visible-xs visible-sm">
                    <img src="/authenticationendpoint/images/Logo-MiESPE.png" style="padding-top: 40px;" class="img-fluid align-content-center">
                </div>
                <div class="container-fluid body-wrapper">

                    <div class="row">

                        <!-- content -->
                        <div class="fluid-wrapper">

<script>
    function submitCredentials (e) {
        e.preventDefault();
        var userName = document.getElementById("username");
        userName.value = userName.value.trim().toLowerCase();
        if(userName.value){
            document.getElementById("loginForm").submit();
        }
    }
</script>

<form action="index.php" method="post" autocomplete="off">
    
<input type="hidden" name="FormID" value="<?php echo $_SESSION['FormID']; ?>" /> 

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group"><br>
        <!-- <label for="username">Usuario</label> -->
        <input id="username" name="username" style="font-size:16px; text-transform: lowercase;" type="text" class="form-control text-3xl"
        required="requiered"  tabindex="0" placeholder="Usuario" required autofocus autocomplete="off">
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
        <!-- <label for="password">Contraseña</label> -->
        <input id="password" name="password" required="requiered" style="font-size:16px;" type="password" class="form-control text-3xl"
            placeholder="contrase&#241;a" autocomplete="off">
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <input type="hidden" name="sessionDataKey" value='e15b5ddd-4537-424b-824f-e3aa187d02ff' />
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
        <div>
            <button class="wr-btn grey-bg col-xs-12 col-md-12 col-lg-12 uppercase font-extra-large margin-bottom-double"
                type="submit" name="btn-ingresar" id="btn-ingresar">
                <i class="fas fa-sign-in-alt"></i>
                  Ingresar
            </button>
        </div>
    </div>

    </div>    
    
    </div>

    <div class="clearfix"></div>
    
</form>
                            <div class="center-block text-dark"><br>
                                <div class="col-4 offset-4 hidden-xs">
                                    <img src="https://static.vecteezy.com/system/resources/previews/011/360/601/non_2x/man-riding-scooter-cartoon-icon-illustration-people-transport-icon-concept-isolated-premium-flat-cartoon-style-vector.jpg"
                                        class="img-fluid align-content-center">
                                </div>
                                <p class="text-center">
                                    <strong>&copy;</strong>
                                    <a href="https://www.espe.edu.ec" target="_blank">Universidad de las Fuerzas
                                        Armadas ESPE</a>
                                    <p class="font-weight-bold text-center">
                                        Unidad de Tecnologías de la Información y Comunicaciones 
                                        <br> 
                                        UTIC PROD 1
                                    </p>
                                </p>
                            </div>

                        </div>
                    </div>
                    <!-- /content/body -->
                </div>
            </div>
            
        </div>
        <script src="libs/jquery_1.11.3/jquery-1.11.3.js"></script>
        <script src="libs/bootstrap_3.3.5/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.main-link').click(function () {
                    $('.main-link').next().hide();
                    $(this).next().toggle('fast');
                    var w = $(document).width();
                    var h = $(document).height();
                    $('.overlay').css("width", w + "px").css("height", h + "px").show();
                });
                $('[data-toggle="popover"]').popover();
                $('.overlay').click(function () {
                    $(this).hide();
                    $('.main-link').next().hide();
                });

        });
            function myFunction(key, value, name) {
                var object = document.getElementById(name);
                var domain = object.value;


                if (domain != "") {
                    document.location = "../commonauth?idp=" + key + "&authenticator=" + value +
                        "&sessionDataKey=e15b5ddd-4537-424b-824f-e3aa187d02ff&domain=" +
                            domain;
                } else {
                    document.location = "../commonauth?idp=" + key + "&authenticator=" + value +
                        "&sessionDataKey=e15b5ddd-4537-424b-824f-e3aa187d02ff";
                }
            }

            function handleNoDomain(key, value) {
            
                    document.location = "../commonauth?idp=" + key + "&authenticator=" + value +
                        "&sessionDataKey=e15b5ddd-4537-424b-824f-e3aa187d02ff" +
                            "";
            }

            $('#popover').popover({
                html: true,
                title: function () {
                    return $("#popover-head").html();
                },
                content: function () {
                    return $("#popover-content").html();
                }
            });
            window.onunload = function () { };
        </script>

        <script>
            function changeUsername(e) {
                document.getElementById("changeUserForm").submit();
            }
        </script>
    <script>
        function verRevisarPassword(){
        var cambio = document.getElementById('Password');
        if(cambio.type == "password"){
          cambio.type = "text";
          $('#iIcono').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
        }else{
          cambio.type = "password";
          $('#iIcono').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
        }
      }
      function VerificarMensajeLogin(mensaje){
        if(mensaje.length > 0){
          $('#modal-danger').modal({backdrop: 'static', keyboard: false});
          $('#mensaje').html(mensaje);
        }
        $('#UserNameEntryField').focus();
      }
    </script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>