<?php include("conexao.php");

    $usuario = $_POST["txtUsuario"];
    $senha = $_POST["txtSenha"];


    $sql = $conn->prepare("
    SELECT * FROM usuarios WHERE usuario = '$usuario' and senha = '$senha'
    ");
    $sql->execute();

    if($sql->rowCount() > 0) {
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['id'] = $dados['id'];
        $_SESSION['nome'] = $dados['nome'];

        header("location: index.php");

    } else {

        header("location: login.php");
    }
?>
    