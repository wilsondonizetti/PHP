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
	if((count($_POST)!=7)&&($origem!='Editar.php')){
		header("Location:./AcessoNegado.php");
		die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nome = utf8_encode(htmlspecialchars($_POST['nomeCompleto']));
		$login = utf8_encode(htmlspecialchars($_POST['login']));
		$senha = utf8_encode(htmlspecialchars($_POST['senha']));
		$senhaConf = utf8_encode(htmlspecialchars($_POST['senha2']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));
        $cidade = utf8_encode(htmlspecialchars($_POST['cidade']));
        $arquivo = utf8_encode(htmlspecialchars($_FILES["arquivo"]["name"]));
		
		if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
            header("Location:./ErroCadastro.php");
            die();
		}
        
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["arquivo"]["name"]);
        $extension = end($temp);

        //&& ($_FILES["arquivo"]["size"] < 20000)
        if ((($_FILES["arquivo"]["type"] == "image/gif")
        || ($_FILES["arquivo"]["type"] == "image/jpeg")
        || ($_FILES["arquivo"]["type"] == "image/jpg")
        || ($_FILES["arquivo"]["type"] == "image/pjpeg")
        || ($_FILES["arquivo"]["type"] == "image/x-png")
        || ($_FILES["arquivo"]["type"] == "image/png"))
        && in_array($extension, $allowedExts)) {
          if ($_FILES["arquivo"]["error"] > 0) {
            echo "Return Code: " . $_FILES["arquivo"]["error"] . "<br>";
          } else {
            echo "Upload: " . $_FILES["arquivo"]["name"] . "<br>";
            echo "Type: " . $_FILES["arquivo"]["type"] . "<br>";
            echo "Size: " . ($_FILES["arquivo"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["arquivo"]["tmp_name"] . "<br>";
            if (file_exists("./fotos/" . $_FILES["arquivo"]["name"])) {
              echo $_FILES["arquivo"]["name"] . " already exists. ";
            } else {
              move_uploaded_file($_FILES["arquivo"]["tmp_name"],
              "./fotos/" . $_FILES["arquivo"]["name"]);
              echo "Gravado em: " . "./fotos/" . $_FILES["arquivo"]["name"];
            }
          }
        } else {
          header("Location:./ErroUpLoadFoto.php");
            die();
        }
		
		// cria instrução SQL parametrizada
		$SQLUpdate = 'UPDATE participantes set senha = MD5(?), nomeCompleto = ?, arquivoFoto = ?, cidade = ?, email = ?, descricao = ? WHERE login = ?';
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQLUpdate);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
		$update = $operacao->execute(array($senha, $nome, $arquivo, $cidade, $email, $descricao, $login));
		
		// fecha a conexão ao banco
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro ou falso,
		//imprimindo mensagens ao cliente
		if ($update){
			 echo "<h1>Atualização efetuada com sucesso.</h1>\n";
			 echo "<p class=\"lead\"><a href=\"./index.php\">Página principal</a></p>\n";
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
				$erro = utf8_decode($arr[2]);
				echo "<p>$erro</p>";							//deve ser melhor tratado em um caso real
			    echo '<p><a href="./Editar.php?participante="'.$login.'>Retornar</a></p>\n';
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
