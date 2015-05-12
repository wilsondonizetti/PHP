<?php
    //Configuração de acesso ao banco de dados
    require_once("./ConfigBD.php");
    //Autenticação
    require_once("./AuthSession.php");
    //HTML
    include_once("./html/Cabecalho.php");
try
{
	
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor GET
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$perfil = utf8_encode(htmlspecialchars($_GET['participante']));
		
		// cria instrução SQL parametrizada
		$SQL = 'SELECT * FROM participantes WHERE login=?';
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQL);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
		$resultados = $operacao->execute(array($perfil));
        //obter dados
        $resultados = $operacao->fetchAll();
		
        $SQLCidade = 'SELECT * FROM cidades WHERE idCidade = ?';
    
        //prepara a execução
		$operacao = $conexao->prepare($SQLCidade);
    
        $cidade = $operacao->execute(array($resultados[0]['cidade']));
        $cidade = $operacao->fetchAll();
    
        $SQLEstado = 'SELECT * FROM estados WHERE idEstado = ?';
    
        //prepara a execução
		$operacao = $conexao->prepare($SQLEstado);
    
        $estado = $operacao->execute(array($cidade[0]['idEstado']));
        $estado = $operacao->fetchAll();
    
		// fecha a conexão ao banco
		$conexao = null;
    
        $diretorio = './fotos/';
		
?>
<div class="content">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                     <?php 
                        //quando coloco data-src='holder.js/165x180' fica no tamanho que eu quero mas não mostra a imagem
                        echo "<img class='thumbnail imgT' src='" .$diretorio .$resultados[0]['arquivoFoto']."' alt='imagemParticipante'></img>";?>
                
            </div>
            <div class="col-sm-6 col-md-2">
                     <?php 
                        //$perfil = utf8_encode(htmlspecialchars($_GET['participante']));
                        //botão editar
                        if($perfil == $_SESSION['login'])
                        {
                            echo '<a href="./Editar.php?participante='.htmlspecialchars($perfil).'"><button type="button" class="btn btn-primary">Editar</button></a>';
                            echo '<a href="./Excluir.php?participante='.htmlspecialchars($perfil).'" ><button type="button" class="btn btn-danger" >Excluir</button></a>';
                        }
                     ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="InputNome">Nome Completo:</label>
		<input type="text" class="form-control" id="InputNome" name="nomeCompleto" readonly value="<?php echo $resultados[0]['nomeCompleto']?>" />
    </div>
    <div class="form-group">
        <label for="InputEmail">E-mail:</label>
		<input type="text" class="form-control" id="InputEmail" name="email" readonly value="<?php echo $resultados[0]['email']?>" />
    </div>
    <div class="form-group">
        <label for="InputEstado">Estado:</label>
		<input type="text" class="form-control" id="InputEstado" name="estado" readonly value="<?php echo $estado[0]['nomeEstado']?>" />
    </div>
    <div class="form-group">
        <label for="InputCidade">Cidade:</label>
		<input type="text" class="form-control" id="InputCidade" name="cidade" readonly value="<?php echo $cidade[0]['nomeCidade']?>" />
    </div>
    <div class="form-group">
        <label for="InputDescricao">Descrição:</label>
        <textarea rows="4" cols="50" class="form-control" id="InputDescricao" name="descricao" readonly><?php echo $resultados[0]['descricao']?></textarea>
    </div>
    
    <?php
        include_once("./Galeria.php");
    ?>
</div>
    
<?php    
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("./html/Rodape.html");

?>
