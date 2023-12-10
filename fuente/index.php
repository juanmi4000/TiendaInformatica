<?php
    /* Importa utilidades el fichero conexiones.php */
    require_once "./php/utilidades/conexiones.php";
    /* Cada vez que se entre se comprobará si existe un usuario y un administrador
        Si existe no hace nada, si no existe los crea:
            - Administrador: correo --> admin@gmail.com | clave --> admin
            - Usuario: correo --> usuario@gmail.com | clave --> 1234
    */
    crearAdminPredeterminado();
    crearUsuarioPredeterminado();
    
    /* Verifica si la solicitud HTTP actual se realizó utilizando el método POST */
    if ($_SERVER["REQUEST_METHOD"] == "POST") { // REQUEST_METHOD --> es un indice específico de $_SERVER: POST/GET
        // iba a poner un comentario pero solo hay que poner el cursor encima de comprobar usuario
        $usuario = comprobarUsuario($_POST['correo'], $_POST['contrasena']);
        if ($usuario === false) { // si no existe declara la variable error y emailErroneo es el email incorrecto
            $err = true;
            $emailErroneo = $_POST['correo'];
        } else { // inicia sesión, se declara e inicializa la variables de sesión llamada usuario y carrito, redirige y termina
            session_start();
            $_SESSION['usuario'] = $usuario;
            if ($usuario['rol'] === "admin") {
                header("Location: ./php/admin/admin.php");
                return;
            }
            $_SESSION['carrito'] = []; 
            header("Location: ./php/usuario/inicio.php");
            return;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda Informática</title>
        <link rel="stylesheet" href="./style/styleIndex.css">
        <style>
            .inputSubmit{
                border-radius: 25px;
                font-size: 16px;
            }
            .formulario h1 span{
                display: block;
                align-items: center;
                white-space: nowrap;
                border-right: 4px solid;
                width: 13ch;
                margin-left: 90px;
                animation: typing 2s steps(13), blink .5s infinite step-end alternate;
                overflow: hidden;
            }

            @keyframes typing{
                from{width: 0;}
            }

            @keyframes blink{
                50%{border-color: transparent;}
            }
        </style>
    </head>
    <body>
        <div class="formulario">
            <h1><span>Inicio de sesión</span></h1>
            <!-- formulario de inicio de sesión. Cuando se pulsa el botón se lo auto envía con el método post -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="username">
                 <!-- Si se ha equivocado le pone el email introducido  -->
                    <input type="text" name="correo" id="correoId" value="<?php if(isset($emailErroneo)) echo $emailErroneo;?>" required>
                    <label id="email">Correo</label>
                </div>
                <div class="username">
                    <input type="password" id="claveId" name="contrasena" required>
                    <label id="clave" id>Contraseña</label>
                </div>
                <script>
                    function actualizarLabel(inputId, labelId) {
                        let valor = document.getElementById(inputId).value;
                        let label = document.getElementById(labelId);
                        label.style.top = (valor.trim() !== '') ? '-5px' : '50%';
                        label.style.color = (valor.trim() !== '') ? '#6C3483' : '#adadad';
                    }

                    document.getElementById('correoId').addEventListener('input', function(){
                        actualizarLabel('correoId', 'email');
                    });

                    document.getElementById('claveId').addEventListener('input', function(){
                        actualizarLabel('claveId', 'clave');
                    });
                </script>
                <input class="inputSubmit" type="submit" value="Iniciar">
                <div class="registrarse">
                    <!-- Dirige al fichero de registrarse -->
                    <p>No tengo una cuenta: <a href="./php/usuario/registrarse.php">Crear cuenta</a></p>
                </div>
                <div class="erroresOtros">
                    <?php 
                        if (isset($_GET['redirigido'])) {
                            echo "<p><b>Haga login para continuar</b></p>";
                        }
                        if(isset($err) and $err == true){
                            echo "<p><b>Revise su usuario y contraseña</b></p>";
                        }
                        // se comprueba que ha pasado si ha intentado registrarse 
                        if(isset($_GET['existe'])){
                                echo "<p><b>El usuario que has intentado registrar ya existe</b></p>";
                        }
                        if (isset($_GET['noExiste'])) {
                            echo "<p><b>Te has registrado correctamente</b></p>";    
                        }
                        if(isset($_GET['cerrarSesion'])){
                            $usuario = '';
                            unset($_SESSION['usuario']);
                            echo "<p><b>Se ha cerrado correctamente la sesión</b></p>";
                        }
                    ?>
                </div>
            </form>
        </div>
    </body>
</html>