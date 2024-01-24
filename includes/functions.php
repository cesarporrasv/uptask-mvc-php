<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function snz($html) : string {
    $snz = htmlspecialchars($html);
    return $snz;
}

// Crear Sesion
function createSession() {
    if(!isset($_SESSION)) {
        session_start();
    }
}

function theLast(string $current, string $next): bool {
    if($current !== $next) {
        return true;
    }
    return false;
}

// Funcion revisa usuario autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}