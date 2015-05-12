<?php
    //Configuração de acesso ao banco de dados
    require_once("./ConfigBD.php");
    
try
{
    //cria conexao (conn_mysql está em ConfigBD.php
    $conexao = conn_mysql();
    
    //SQL participantes
    $SQLSelect = 'SELECT * FROM participantes WHERE arquivoFoto IS NOT NULL';
    
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);
    
    $resultados = $operacao->execute();
    
    //obter dados
	$resultados = $operacao->fetchAll();
		
    //fecha a conexão
	$conexao = null;
    
    // se há resultados, os escreve em uma tabela
    if (count($resultados)>0){		
        
        $diretorio = './fotos/';
        echo '<div class="row">';
        
        
        
		//echo '<table class="table table-striped">';	
		//echo '<tbody><tr>';
        $count = 0;
            
		foreach($resultados as $participante){		//para cada elemento do vetor de resultados...
            
            $fname = $participante['arquivoFoto'];
					
			//echo "<td><a href='./Perfil.php?participante=".htmlspecialchars($participante['login'])."'><img class='thumbnail' src='" .$diretorio .$fname."'></img></a></td>";	
            echo '<div class="col-md-3">';
            echo "<a href='./PerfilParticipante.php?participante=".htmlspecialchars($participante['login']). "' title='" .$participante['nomeCompleto'] ."'>";
            echo '<img  src="' .$diretorio .$fname.'" alt="imagemParticipante" class="thumbnail imgT" />';	
            echo '</a>';
            echo '</div>';
            
            $count++;
            
            if ($count == 12)
            {
                break;    
            }
		
		}
        //echo '</tr></tbody>';
		//echo '</table>';
        
        echo '</div>';
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>