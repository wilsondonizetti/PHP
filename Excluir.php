<?php
    //Configuração de acesso ao banco de dados
    require_once("./ConfigBD.php");
    //Autenticação
    require_once("./AuthSession.php");
    include_once("./html/Cabecalho.php");
try
{
	// se não foram passados 4 parâmetros na requisição e não vier da página de cadastro
	//desvia para a mensagem de erro: 	// "previne" acesso direto à página
	$origem = basename($_SERVER['HTTP_REFERER']);
	if((count($_GET)!=1)&&($origem!='PerfilParticipante.php')){
		header("Location:./AcessoNegado.php");
		die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$login = $_SESSION['login'];
		
		
		// cria instrução SQL parametrizada
		$SQL = 'DELETE FROM participantes WHERE login = ?';
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQL);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
		$delete = $operacao->execute(array($login));
		
		// fecha a conexão ao banco
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro ou falso,
		//imprimindo mensagens ao cliente
		if ($delete){
			 header("Location: ./Logout.php");
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
				$erro = utf8_decode($arr[2]);
				echo "<p>".$erro."</p>";							//deve ser melhor tratado em um caso real
			    echo '<p><a href="./PerfilParticipante.php?participante="'.$login.'>Retornar</a></p>\n';
		}
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("./html/Rodape.html");

?>

