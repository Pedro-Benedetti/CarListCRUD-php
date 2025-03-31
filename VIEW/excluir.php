<?php
require_once "../CONTROLLER/carroDAO.php";
require_once "../MODEL/carro.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php?mensagem=ID não fornecido para exclusão");
    exit();
}

$id = $_GET['id'];
$carroDAO = new CarroDAO();

$carro = $carroDAO->buscarPorId($id);
if (!$carro) {
    header("Location: listar.php?mensagem=Carro não encontrado para exclusão");
    exit();
}

if ($carroDAO->excluir($id)) {
    header("Location: listar.php?mensagem=Carro excluído com sucesso!");
} else {
    header("Location: listar.php?mensagem=Erro ao excluir carro");
}
?>