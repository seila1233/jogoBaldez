<?php
// Importa o arquivo de conexão com o banco de dados usando PDO
session_start();
require_once 'conexao.php';

// Verifica se o formulário foi enviado com o método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Captura os dados enviados pelo formulário, ou usa string vazia caso não venham
    $nome = $_POST['nomeJogador'];

    // Criptografa a senha usando o algoritmo padrão do PHP (bcrypt atualmente)

    // Monta o comando SQL com placeholders (parâmetros nomeados) para evitar SQL Injection
    $sql = "INSERT INTO nomeRanking (nome) VALUES (:nomeJogador)";

    // Prepara a consulta para ser executada
    $stmt = $pdo->prepare($sql);

    // Associa os valores do formulário aos parâmetros da consulta
    $stmt->bindParam(':nomeJogador', $nome);

    // Executa a consulta preparada
    if ($stmt->execute()) {
        // Se tudo ocorreu bem, mostra mensagem de sucesso
        echo "Usuário cadastrado com sucesso!";
    } else {
        // Caso ocorra algum erro durante a execução
        echo "Erro ao cadastrar usuário.";
    }
} else {
    // Se o script for acessado por método diferente de POST, impede a execução
 echo 'Acesso invalido';
}
?>