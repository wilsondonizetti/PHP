<?php
 function conn_mysql(){

   $servidor = 'servidor';
   $porta = 3306;
   $banco = "banco";
   $usuario = "usuario";
   $senha = "senha";
   
      $conn = new PDO("mysql:host=$servidor;
	                   port=$porta;
					   dbname=$banco", 
					   $usuario, 
					   $senha,
					   array(PDO::ATTR_PERSISTENT => true)
					   );
      return $conn;
   }
?>