<?php
require_once "../CONTROLLER/carroDAO.php";
require_once "../MODEL/carro.php";

$carroDAO = new CarroDAO();
$carros = $carroDAO->listar();

$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id';
$direcao = isset($_GET['direcao']) ? $_GET['direcao'] : 'ASC';

$proxima_direcao = ($direcao == 'ASC') ? 'DESC' : 'ASC';

$mensagem = '';
if (isset($_GET['mensagem'])) {
    $mensagem = '<div class="alert alert-success">' . $_GET['mensagem'] . '</div>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Carros</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Carros</h1>
        
        <?php echo $mensagem; ?>
        
        <div class="actions">
            <a href="adicionar.php" class="btn btn-primary">Adicionar Novo Carro</a>
        </div>
        
        <div class="table-responsive">
            <?php if (!empty($carros)): ?>
                <table>
                    <thead>
                        <tr>
                            <th><a href="?ordem=id&direcao=<?php echo $proxima_direcao; ?>">ID <?php echo ($ordem == 'id') ? ($direcao == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                            <th><a href="?ordem=marca&direcao=<?php echo $proxima_direcao; ?>">Marca <?php echo ($ordem == 'marca') ? ($direcao == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                            <th><a href="?ordem=modelo&direcao=<?php echo $proxima_direcao; ?>">Modelo <?php echo ($ordem == 'modelo') ? ($direcao == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                            <th><a href="?ordem=ano&direcao=<?php echo $proxima_direcao; ?>">Ano <?php echo ($ordem == 'ano') ? ($direcao == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($carros as $carro): ?>
                            <tr>
                                <td><?php echo $carro->getId(); ?></td>
                                <td><?php echo $carro->getMarca(); ?></td>
                                <td><?php echo $carro->getModelo(); ?></td>
                                <td><?php echo $carro->getAno(); ?></td>
                                <td class="actions">
                                    <a href="editar.php?id=<?php echo $carro->getId(); ?>" class="btn btn-edit">Editar</a>
                                    <a href="javascript:void(0);" onclick="confirmarExclusao(<?php echo $carro->getId(); ?>)" class="btn btn-delete">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-records">Nenhum carro cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este carro?")) {
                window.location.href = "excluir.php?id=" + id;
            }
        }
    </script>
</body>
</html>