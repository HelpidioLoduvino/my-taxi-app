<?php
$host = "localhost";
$port = 5432;
$dbname = "teste";
$user = "myuser";
$password = "mypassword";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Erro ao conectar com o banco de dados.";
    exit;
}

// Agora você está conectado ao banco de dados especificado
// e pode executar consultas e operações nele usando a conexão $conn

// Exemplo de consulta
$result = pg_query($conn, "SELECT * FROM users");

// Processar o resultado
while ($row = pg_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . ", Nome: " . $row['nome'] . "<br>";
}

// Fechar a conexão
pg_close($conn);

