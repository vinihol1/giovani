<?php
/// Insira isso antes da geração do número sorteado
// Configurações de conexão
$servername = "localhost";
$username = "root";
$password = "vinihol1";
$database = "sorteio_db";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recupera os dados do formulário
$quantidade_numeros = isset($_POST['quantidade_numeros']) ? $_POST['quantidade_numeros'] : 0;
$nome_comprador = isset($_POST['nome_comprador']) ? $_POST['nome_comprador'] : '';
$nome_vendedor = isset($_POST['nome_vendedor']) ? $_POST['nome_vendedor'] : '';

// Inicializa uma variável para armazenar os números sorteados
$numeros_sorteados = [];

// Gera e armazena os números sorteados
for ($i = 0; $i < $quantidade_numeros; $i++) {
    do {
        $numero_sorteado = rand(0000, 9999);
        $check_query = "SELECT COUNT(*) as count FROM numeros_sorteio WHERE numero = '$numero_sorteado'";
        $result = $conn->query($check_query);
        $row = $result->fetch_assoc();
    } while ($row['count'] > 0);

    $sql = "INSERT INTO numeros_sorteio (numero, comprador_nome, vendedor) VALUES ('$numero_sorteado', '$nome_comprador', '$nome_vendedor')";

    if ($conn->query($sql) !== TRUE) {
        echo "Erro ao inserir número sorteado: " . $conn->error;
        break; // Encerra o loop em caso de erro
    }
}

// Fecha a conexão
$conn->close();

// Exibe os números sorteados e a mensagem de boa sorte
echo "Números Sorteados: " . implode(', ', $numeros_sorteados) . "<br>";
echo "Boa sorte, $nome_comprador!";
?>

