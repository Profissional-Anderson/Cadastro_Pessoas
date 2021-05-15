<?php
    require_once 'pessoa.php';
    $p = new Pessoa("crudpdo","localhost","root",""); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa!</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
    //Colher os dados através do metodo post
    if (isset($_POST['cadastrar'])){
        //-----------------editar---------------------
        if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
            $id_upd = addcslashes($_GET['id_up'],"");
            $nome = addcslashes($_POST['nome'],"");
            $telefone = addcslashes($_POST['telefone'],"");
            $email = addcslashes($_POST['email'],"");
            if (!empty($nome) && !empty($telefone) && !empty($email)){
                //atualizar os dados
                $p->atualizarDados($id_upd,$nome,$telefone,$email); 
                header("location:index.php");     
                }else{
                echo "Preencha todos os campos!";
                }
            }
        else{
        $nome = addcslashes($_POST['nome'],"");
        $telefone = addcslashes($_POST['telefone'],"");
        $email = addcslashes($_POST['email'],"");
        if (!empty($nome) && !empty($telefone) && !empty($email)){
            if(!$p->cadastrarPessoa($nome,$telefone,$email)){
                echo "Email já cadastrado!";            
                }
            }else{
            echo "Preencha todos os campos!";
            }
        }
    }   
    ?>
    <?php
        if(isset($_GET['id_up'])){
            $id_update = $_GET['id_up'];
            $res = $p->buscarDadosPessoa($id_update);       

        }
    ?>
   <section id="esquerda">
            <form method="POST">  
                <h2>CADASTRAR PESSOAS</h2>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder="Digite seu Nome..." id="nome" value="<?php if(isset($res)){echo $res['nome'];} ?>">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" placeholder="Digite seu Telefone..." id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?>">
                <label for="email">Email:</label>
                <input type="text" name="email" placeholder="Digite seu Email..." id="email" value="<?php if(isset($res)){echo $res['email'];} ?>">
                <input type="submit" value="<?php if(isset($res)){ echo "Atualizar";}else{echo "Cadastrar";} ?>" name="cadastrar">
             </form>
    </section>

    <section id="direita">

        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan="2">Email</td>
                <tr>
                <?php
        $dados = $p->buscarDados();
        if(count($dados) > 0){
            for ($i=0; $i < count($dados); $i++) { 
                echo "<tr>";
                foreach ($dados[$i] as $key => $value) {
                    if ($key != "id") {
                        echo "<td>".$value."</td>";
                    }
                }
                ?>
                <td>
                    <a href='index.php?id_up=<?php echo $dados[$i]['id'];?>"'>Editar</a>
                    <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                </td>
                <?php
                echo "</tr>";
            }

        }else{
            echo "Não existe dados no banco!";
        }
    ?>      
        </table>
    </section>
</body>
</html>
<?php

if(isset($_GET['id'])){
    $id_pessoa = addcslashes($_GET['id'],"");
    $p->excluirPessoa($id_pessoa);
    header("location:index.php");
}


?>