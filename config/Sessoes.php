<?php
class Sessoes
{

    // Inicia a sessão, caso ainda não tenha sido iniciada
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Função para armazenar dados na sessão
    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Função para recuperar dados da sessão
    public function getSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Função para verificar se uma chave existe na sessão
    public function sessionExists($key)
    {
        if (!isset($_SESSION[$key])) {
            // Redireciona para a página inicial (index.php)
            header('Location: ../public_html/login.php');
            exit; 
        }
        return true;
    }

    // Função para remover dados da sessão
    public function removeSession($key)
    {
        if ($this->sessionExists($key)) {
            unset($_SESSION[$key]);
        }
    }

    // Função para destruir a sessão
    public function destroySession()
    {
        session_unset();
        session_destroy();
    }
}
