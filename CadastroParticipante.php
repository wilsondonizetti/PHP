<?php
    //Configuração de acesso ao banco de dados
    require_once("./ConfigBD.php");

    include_once("./html/Cabecalho.php");
?>

<div>
		 <form role="form" enctype="multipart/form-data" method="post" action="./CadastroNovoParticipante.php" class="form-signin">
		      <h3 class="form-signin-heading">Participantes<br> Cadastro de novo Participante</h3>
			  <div class="form-group">
				<label for="InputNome">Nome Completo:</label>
				<input type="text" class="form-control" id="InputNome" name="nomeCompleto" placeholder="Nome completo" required autofocus />
			  </div>
			  <div class="form-group">
			    <label for="InputLogin">Login:</label>
				<input type="text" class="form-control" id="InputLogin" name="login" placeholder="Login desejado" required />
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
                        try{
                            //cria conexao (conn_mysql está em ConfigBD.php
                            $conexao = conn_mysql();

                            //SQL participantes
                            $SQLSelect = 'SELECT * FROM cidades order by nomeCidade';

                            //prepara a execução da sentença
                            $operacao = $conexao->prepare($SQLSelect);

                            $resultados = $operacao->execute();

                            //obter dados
                            $resultados = $operacao->fetchAll();

                            //fecha a conexão
                            $conexao = null;

                            // se há resultados
                            if (count($resultados)>0){	
                                
                                //preencher componente select

                                foreach($resultados as $cidade){		

                                echo '<option value='.htmlspecialchars($cidade['idCidade']).'>'.$cidade['nomeCidade'].'</option>';		
                                }
                            }
                        }
                        catch (PDOException $e)
                        {
                            // caso ocorra uma exceção, exibe na tela
                            echo "Erro!: " . $e->getMessage() . "<br>";
                            die();
                        }
                    ?>
                </select>
			  </div>
              <div class="form-group">
				<label for="InputEmail">Email:</label>
				<input type="email" class="form-control" id="InputEmail" name="email" placeholder="E-mail" required />
			  </div>
              <div class="form-group">
				<label for="InputDescricao">Descrição:</label>
				<textarea rows="4" cols="50" class="form-control" id="InputDescricao" name="descricao" placeholder="Descrição" required></textarea>
			  </div>
              <div class="form-group">
				<label for="InputFile">Foto do Perfil:</label>
				<input type="file" id="InputFile" name="arquivo" ><br>
			  </div>
             
			  <button type="submit" class="btn btn-primary">Cadastrar</button>
		 </form>

	 </div>

<?php
	include_once("./html/Rodape.html");
?>