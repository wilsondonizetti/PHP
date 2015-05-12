<?php
	session_start();
    if(!empty($_SESSION['auth']) && ($_SESSION['auth']==true)){
        header("Location:./PerfilParticipante.php?participante=".$_SESSION['login']);
        die();
    }
	if(isset($_COOKIE['loginYearBookAutomatico'])){
	   header("Location: ./verificarLogin.php");
	}
	else if(isset($_COOKIE['loginYearBook']))
		$usuario = $_COOKIE['loginYearBook'];
		else $usuario="";
		
	include_once("./html/cabecalho.php");
?>
	<div id="contentLogin">
		<div class="login">
			<form class="form-signin" role="form" method="post" action="./verificarLogin.php">
				<h3 class="form-signin-heading">Yearbook - Login</h3>
				<input type="text" class="form-control" placeholder="Login" name="login" value="<?php echo $usuario?>"required autofocus>
				<input type="password" class="form-control" placeholder="Senha" name="senha" required>
				<label>
				  <input type="checkbox"  name="lembrarLogin" value="loginAutomatico"> Permanecer conectado
				</label>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
				<br>
				<button class="btn btn-lg btn-success btn-block" type="button" onclick="javascript:window.location.href='./CadastroParticipante.php'">Cadastrar-se</button>
			</form>
		</div>
		<div class="loginImgUniv">
			<img id="imgUniv" src="Images/universitarios.png"/>
		</div>
	</div>
    <div class="container">
        <div class="starter-template">
            <?php
                include_once("./Galeria.php");
            ?>
        </div> 
    </div>  
<?php
	include_once("./html/rodape.html");
?>