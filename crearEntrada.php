<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonCrearEntrada']) && isset($_POST['tituloEntrada'])) {
    // Comprobamos que el email es válido
    $sql=
    $entrada = filter_var(trim($_POST['tituloEntrada']));
    


    
  
            }
            ?>