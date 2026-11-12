<?php
require 'funciones.php';
// La tienda requiere iniciar sesión antes de entrar.
ir(usuario_actual() ? 'panel.php' : 'login.php');
