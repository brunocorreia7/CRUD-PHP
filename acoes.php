<?php
session_start();
require 'conexao.php';

if (isset($_POST['create_usuario'])) {
    $nome = mysqli_real_escape_string($conn, trim($_POST['Nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['Data_nascimento']));
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conn, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';

    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha')";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['mensagem'] = 'Usuário criado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi criado';
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['update_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conn, $_POST['usuario_id']);

    $nome = mysqli_real_escape_string($conn, trim($_POST['Nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['Data_nascimento']));
    $senha = mysqli_real_escape_string($conn, trim($_POST['senha']));

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";

    if (!empty($senha)) {
        $sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
    }

    $sql .= " WHERE id = '$usuario_id'";

    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
        } else {
            $_SESSION['mensagem'] = 'Nenhuma alteração foi feita';
        }
    } else {
        $_SESSION['mensagem'] = 'Erro: ' . mysqli_error($conn);
    }

    header('Location: index.php');
    exit;
}

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conn, $_POST['delete_usuario']);
    
    $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";

    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = 'Usuario deletado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['message'] = 'Usuario não foi deletado';
        header('Location: index.php');
        exit;
        
    }
}
?>
