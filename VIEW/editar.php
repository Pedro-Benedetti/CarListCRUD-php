<?php
require_once "../CONTROLLER/carroDAO.php";
require_once "../MODEL/carro.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php?mensagem=ID não fornecido");
    exit();
}

$id = $_GET['id'];
$carroDAO = new CarroDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    
    $erros = [];
    
    if (empty($marca)) {
        $erros[] = "Marca é obrigatória";
    }
    
    if (empty($modelo)) {
        $erros[] = "Modelo é obrigatório";
    }
    
    if (empty($ano) || !is_numeric($ano) || $ano < 1900 || $ano > date("Y") + 1) {
        $erros[] = "Ano deve ser um valor numérico válido entre 1900 e " . (date("Y") + 1);
    }
    
    if (empty($erros)) {
        $carro = new Carro();
        $carro->setId($id);
        $carro->setMarca($marca);
        $carro->setModelo($modelo);
        $carro->setAno($ano);
        
        if ($carroDAO->atualizar($carro)) {
        
            header("Location: listar.php?mensagem=Carro atualizado com sucesso!");
            exit();
        } else {
            $erros[] = "Erro ao atualizar o carro";
        }
    }
} else {
    
    $carro = $carroDAO->buscarPorId($id);
    
    if (!$carro) {
        header("Location: listar.php?mensagem=Carro não encontrado");
        exit();
    }
    
    $marca = $carro->getMarca();
    $modelo = $carro->getModelo();
    $ano = $carro->getAno();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Carro</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Carro</h1>
        
        <?php if (!empty($erros)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo $erro; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
            <div class="form-group">
                <label for="marca">Marca*:</label>
                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($marca); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="modelo">Modelo*:</label>
                <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="ano">Ano*:</label>
                <input type="number" id="ano" name="ano" value="<?php echo $ano; ?>" min="1900" max="<?php echo date('Y') + 1; ?>" required>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>