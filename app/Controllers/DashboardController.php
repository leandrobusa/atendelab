<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Middleware/auth.php';

class DashboardController
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function resumo(): void
    {
        exigirAutenticacao();

        header('Content-Type: application/json; charset=UTF-8');

        $totalPessoas = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM pessoas WHERE status = 'ativo'")
            ->fetchColumn();

        $totalTipos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM tipos_atendimentos WHERE status = 'ativo'")
            ->fetchColumn();

        $totalAtendimentos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM atendimentos")
            ->fetchColumn();

        $sqlRecentes = "SELECT
                a.id,
                p.nome AS pessoa,
                t.nome AS tipo,
                a.status,
                a.data_atendimento
            FROM atendimentos a
            INNER JOIN pessoas p ON p.id = a.pessoa_id
            INNER JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id
            ORDER BY a.data_atendimento DESC, a.id DESC
            LIMIT 5";

        $atendimentosRecentes = $this->pdo
            ->query($sqlRecentes)
            ->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'indicadores' => [
                'total_pessoas' => $totalPessoas,
                'total_tipos' => $totalTipos,
                'total_atendimentos' => $totalAtendimentos,
            ],
            'atendimentos_recentes' => $atendimentosRecentes,
        ]);
    }
}