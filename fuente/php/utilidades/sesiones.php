<?php
    // se inicia sesión y comprueba si el usuario está registrado, sino lo manda al login
    function comprobarSesion(){
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: ../../index.php?redirigido=true");
        }
    }

    