<?php
require_once __DIR__ . "/conexao.php";
require_once __DIR__ . "/../MODEL/carro.php";

class CarroDAO {
    private $conn;
    
    public function __construct() {
        $this->conn = Conexao::conectar();
    }
    
    public function adicionar(Carro $carro) {
        try {
            $sql = "INSERT INTO carros (marca, modelo, ano) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $carro->getMarca());
            $stmt->bindValue(2, $carro->getModelo());
            $stmt->bindValue(3, $carro->getAno());
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao adicionar: " . $e->getMessage();
            return false;
        }
    }
    
    public function listar() {
        try {
            $sql = "SELECT * FROM carros";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $carros = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $carro = new Carro();
                $carro->setId($row['id']);
                $carro->setMarca($row['marca']);
                $carro->setModelo($row['modelo']);
                $carro->setAno($row['ano']);
                
                $carros[] = $carro;
            }
            
            return $carros;
        } catch (PDOException $e) {
            echo "Erro ao listar: " . $e->getMessage();
            return array();
        }
    }
    
    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM carros WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $carro = new Carro();
                $carro->setId($row['id']);
                $carro->setMarca($row['marca']);
                $carro->setModelo($row['modelo']);
                $carro->setAno($row['ano']);
                
                return $carro;
            }
            
            return null;
        } catch (PDOException $e) {
            echo "Erro ao buscar: " . $e->getMessage();
            return null;
        }
    }
    
    public function atualizar(Carro $carro) {
        try {
            $sql = "UPDATE carros SET marca = ?, modelo = ?, ano = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $carro->getMarca());
            $stmt->bindValue(2, $carro->getModelo());
            $stmt->bindValue(3, $carro->getAno());
            $stmt->bindValue(4, $carro->getId());
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return false;
        }
    }
    
    public function excluir($id) {
        try {
            $sql = "DELETE FROM carros WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir: " . $e->getMessage();
            return false;
        }
    }
}
?>