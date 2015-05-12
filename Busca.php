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
		$filtro = utf8_encode(htmlspecialchars($_POST['filtro']));
		
		// cria instrução SQL parametrizada
        $SQL = 'SELECT * FROM participantes ';
        if(!empty($filtro)){
	         $nomeBusca = utf8_encode(htmlspecialchars($_POST['filtro']));
			 $nomeBusca = "%".$nomeBusca."%";
			 $SQL .= ' WHERE nomeCompleto like ?';
		}
		
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQL);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
        if(!empty($filtro)){
		  $resultados = $operacao->execute(array($nomeBusca));
        }
        else{
            $resultados = $operacao->execute();
        }
        //obter dados
        $resultados = $operacao->fetchAll();
    
		// fecha a conexão ao banco
		$conexao = null;
		
        // se há resultados, os escreve em uma tabela
    if (count($resultados)>0){		
        
        $diretorio = './fotos/';

		echo '<table class="table table-striped">';	
        echo '<thead><th style="width:100px;"></th><th></></thead>';
		echo '<tbody>';
        $count = 0;
            
		foreach($resultados as $participante){		//para cada elemento do vetor de resultados...
            
            $fname = $participante['arquivoFoto'];
					
			//echo "<td><a href='./Perfil.php?participante=".htmlspecialchars($participante['login'])."'><img class='thumbnail' src='" .$diretorio .$fname."'></img></a></td>";	
            echo "<tr><td><a href='./PerfilParticipante.php?participante=".htmlspecialchars($participante['login']). "' class='img-thumbnail' title='" .$participante['nomeCompleto'] ."'>";
            echo '<img data-src="holder.js/65x80" src="' .$diretorio .$fname.'" alt="imagemParticipante" class="img-responsive" />';	
            echo '</a>';
            echo '</td>';
            echo '<td><a href="./PerfilParticipante.php?participante='.htmlspecialchars($participante['login']).'">'.$participante['nomeCompleto'].'</a></td></tr>';
		}
        echo '</tbody>';
		echo '</table>';
        
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
