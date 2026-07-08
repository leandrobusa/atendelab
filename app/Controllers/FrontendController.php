<?php

require_once __DIR__ . '/../Middleware/auth.php';

class FrontendController
{
    public function pessoas(): void
    {
        exigirAutenticacao();

        $usuario = usuarioAtual();

        require __DIR__ . '/../Views/pessoas/index.php';
    }

    public function tiposAtendimentos(): void
    {
        exigirAutenticacao();

        $usuario = usuarioAtual();

        require __DIR__ . '/../Views/tipos-atendimentos/index.php';
    }

    public function atendimentos(): void
    {
        exigirAutenticacao();

        $usuario = usuarioAtual();

        require __DIR__ . '/../Views/atendimentos/index.php';
    }
}