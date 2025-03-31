<?php
require_once "../CONTROLLER/carroDAO.php";
require_once "../MODEL/carro.php";


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
        $carro->setMarca($marca);
        $carro->setModelo($modelo);
        $carro->setAno($ano);
        
        $carroDAO = new CarroDAO();
        
        if ($carroDAO->adicionar($carro)) {
           
            header("Location: listar.php?mensagem=Carro cadastrado com sucesso!");
            exit();
        } else {
            $erros[] = "Erro ao cadastrar o carro";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Carro</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Novo Carro</h1>
        
        <?php if (!empty($erros)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo $erro; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="marca">Marca*:</label>
                <input type="text" id="marca" name="marca" value="<?php echo isset($marca) ? $marca : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="modelo">Modelo*:</label>
                <input type="text" id="modelo" name="modelo" value="<?php echo isset($modelo) ? $modelo : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="ano">Ano*:</label>
                <input type="number" id="ano" name="ano" value="<?php echo isset($ano) ? $ano : date('Y'); ?>" min="1900" max="<?php echo date('Y') + 1; ?>" required>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>