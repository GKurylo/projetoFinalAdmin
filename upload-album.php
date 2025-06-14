<?php
include('conexao.php');

// Diretório onde os arquivos serão salvos
$uploadDir = 'uploads/';

if (!empty($_FILES['file']) && isset($_POST['album_id'])) {
    $albumId = intval($_POST['album_id']);
    $file = $_FILES['file'];

    // Gera um nome único para o arquivo
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('img_', true) . '.' . strtolower($ext);
    $destination = $uploadDir . $newFileName;

    // Verifica e move o arquivo
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        // Grava no banco de dados
        $sql = $conn->prepare("INSERT INTO albuns_imagens (album_id, nome_arquivo) VALUES (?, ?)");
        $sql->execute([$albumId, $destination]);

        echo json_encode([
            'status' => 'success',
            'mensagem' => 'Imagem enviada com sucesso!',
            'nomeArquivo' => $destination
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'mensagem' => 'Erro ao mover o arquivo.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'mensagem' => 'Dados inválidos.'
    ]);
}
?>
