<?php
    //Configuração de acesso ao banco de dados
    require_once("./ConfigBD.php");

    //Autenticação
    require_once("./AuthSession.php");

    include_once("./html/Cabecalho.php");

try{
                            //cria conexao (conn_mysql está em ConfigBD.php
                            $conexao = conn_mysql();
                            
                            $SQLParticipante = 'SELECT * FROM participantes WHERE login = ?';
                            
                            $operacao = $conexao->prepare($SQLParticipante);
                            
                            $participante = $operacao->execute(array($_SESSION['login']));
                            
                            $participante = $operacao->fetchAll();

                            
?>

<div>
		 <form role="form" enctype="multipart/form-data" method="post" action="./AtualizarParticipante.php" class="form-signin">
		      <h3 class="form-signin-heading">Participantes<br> Editar Participante</h3>
			  <div class="form-group">
				<label for="InputNome">Nome Completo:</label>
				<input type="text" class="form-control" id="InputNome" name="nomeCompleto" placeholder="Nome completo" required autofocus value="<?php echo $participante[0]['nomeCompleto']?>"/>
			  </div>
			  <div class="form-group">
			    <label for="InputLogin">Login:</label>
				<input type="text" class="form-control" id="InputLogin" name="login" placeholder="Login desejado" readonly value="<?php echo $participante[0]['login']?>"/>
			  </div>
			  <div class="form-group">
				<label for="InputSenha">Senha:</label>
				<input type="password" class="form-control" id="InputSenha" name="senha" placeholder="Senha (4 a 8 caracteres)" required />
			  </div>
			  <div class="form-group">
				<label for="InputSenhaConf">Confirmação de Senha:</label>
				<input type="password" class="form-control" id="InputSenhaConf" name="senha2" placeholder="Confirme a senha" required />
			  </div>
              <div class="form-group">
				<label for="InputCidade">Cidade:</label>
				<select class="form-control" id="InputCidade" name="cidade" placeholder="Selecione..." required>
                    <?php
                        
                            //cria conexao (conn_mysql está em ConfigBD.php
                            //$conexao = conn_mysql();

                            //SQL participantes
                            $SQLSelect = 'SELECT * FROM cidades order by nomeCidade';

                            //prepara a execução da sentença
                            $operacao = $conexao->prepare($SQLSelect);

                            $resultados = $operacao->execute();

                            //obter dados
                            $resultados = $operacao->fetchAll();
                            
                            //$SQLParticipante = 'SELECT * FROM participantes WHERE login = ?';
                            
                            //$operacao = $conexao->prepare($SQLParticipante);
                            
                            //$participante = $operacao->execute(array($_SESSION['login']));
                            
                            //$participante = $operacao->fetchAll();

                            //fecha a conexão
                            $conexao = null;
                             
                            // se há resultados
                            if (count($resultados)>0){	
                                
                                //preencher componente select

                                foreach($resultados as $cidade){
                                    
                                    if($cidade['idCidade'] == $participante[0]['cidade'])
                                    {
                                        echo '<option selected="true" value='.htmlspecialchars($cidade['idCidade']).'  >'.htmlspecialchars($cidade['nomeCidade']).'</option>';
                                    }
                                    else{

                                    echo '<option value='.htmlspecialchars($cidade['idCidade']).'>'.htmlspecialchars($cidade['nomeCidade']).'</option>';		                              }
                                }
                            }
                        
                    ?>
                </select>
			  </div>
              <div class="form-group">
				<label for="InputEmail">Email:</label>
				<input type="email" class="form-control" id="InputEmail" name="email" placeholder="E-mail" required value="<?php echo $participante[0]['email']?>" />
			  </div>
              <div class="form-group">
				<label for="InputDescricao">Descrição:</label>
				<textarea rows="4" cols="50" class="form-control" id="InputDescricao" name="descricao" placeholder="Descrição" required><?php echo $participante[0]['descricao']?></textarea>
			  </div>
              <div class="form-group">
				<label for="InputFile">Foto do Perfil:</label>
				<input type="file" id="InputFile" name="arquivo" ><br>
			  </div>
             
			  <button type="submit" class="btn btn-primary">Editar</button>
		 </form>

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