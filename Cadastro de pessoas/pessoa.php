<?php
class Pessoa{
    private $pdo;

    public function __construct($dbname,$host,$user,$senha){
       try{
           $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
           
       } catch (PDOException $e){
            echo "Erro com o banco de dados".$e->getMessage();
       }
      
    }
   
   //Método SELECT 
   public function buscarDados(){
    $res = array();
    $cmd =$this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
    //Transformar em informação (uma matriz)
    $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}
//Cadastrar pessoa
public function cadastrarPessoa($nome, $telefone, $email){
    //ANTES DE CADASTRAR, VERIFICAR SE JÁ POSSUI CADSTRO
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        //verificação
        if($cmd->rowCount() > 0){            
            return false;
        }else{
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;

        }
    }

    //Método excluir
    public function excluirPessoa($id){
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd -> bindValue(":id", $id);
        $cmd->execute();
    }
    //Método editar
    public function buscarDadosPessoa($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;

    }
    //Método para atualizar os dados
    public function atualizarDados($id,$nome,$telefone,$email){
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":t",$telefone);
        $cmd->bindValue(":e",$email);
        $cmd->bindValue(":id",$id);
        $cmd->execute();


    }

  }
?>