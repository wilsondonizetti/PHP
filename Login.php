<?php
setcookie("loginYearBook", '', time()-42000); 
setcookie("loginYearBookAutomatico", '', time()-42000); 

include_once("./html/Cabecalho.php");

?>

    <div class="container">

      <div>
        <h1>Não foi possível realizar o login.</h1>
		<p class="lead"><a href="./Index.php">Tente novamente.</a></p>
        
	 </div>

	  
	  
    </div><!-- /.container -->

<?php
include_once("./html/Rodape.html");
?>