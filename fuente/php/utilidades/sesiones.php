<?php
    /**
     * Comprueba si se ha iniciado sesión, sino lo manda a la página del login
     */
    function comprobarSesion(){
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: ../../index.php?redirigido=true");
        }
    }

    