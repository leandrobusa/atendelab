<?php
require_once __DIR__ . '/../config/database.php';

$email = 'admin@atendelab.com';
$senha = '123456';

$sql = 'SELECT id, nome, email, senha, perfil, status FROM usuarios WHERE email = :email LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($usuario);
echo '</pre>';

echo '<br>Senha informada: ' . $senha;
echo '<br>Hash no banco: ' . $usuario['senha'];
echo '<br>Resultado do verify: ';
var_dump(password_verify($senha, $usuario['senha']));