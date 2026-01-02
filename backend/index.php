<?php
// Ativar exibição de erros
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

echo '<h1>Teste de Integração Docker</h1>';
echo '<h3>Versão Atual do PHP: ' . phpversion() . '</h3>';

// Configuração do Banco
// ATENÇÃO: "db" é o nome do serviço definido no docker-compose.yml
$servername = "db"; 
$username = "root";
$password = "root1234";
$database = "meubanco_db";

// Conexão
$link = new mysqli($servername, $username, $password, $database);

// Verificação Cética
if (mysqli_connect_errno()) {
    printf("<strong>Falha fatal na conexão:</strong> %s\n", mysqli_connect_error());
    exit();
}

echo "<p style='color:green'><strong>Conexão com o MySQL (Container 'db') realizada com sucesso!</strong></p>";
echo "<hr>";

$valor_rand1 = rand(1, 999);
$valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));
$host_name = gethostname(); // Pega o ID do container que atendeu a requisição

$query = "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) VALUES ('$valor_rand1' , '$valor_rand2', '$valor_rand2', '$valor_rand2', '$valor_rand2','$host_name')";

if ($link->query($query) === TRUE) {
//   echo json_encode(["status" => "success", "message" => "Novo registro criado", "host" => $host_name]);
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 26px;'>";
    echo "<h1>Status da Requisição:</h1>";
    echo "<h2 style='color: darkgreen; font-size: 44px;'>" . "SUCESSO" . "</h2>";
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h1>Requisição atendida pelo Host:</h1>";
    echo "<h2 style='color: blue; font-size: 60px;'>" . $host_name . "</h2>";
    echo "<p>Atualize a página para ver o Load Balancer trocar o container.</p>";
    echo "</div>";
} else {
  echo json_encode(["status" => "error", "message" => "Erro: " . $link->error]);
}

$link->close();
?>