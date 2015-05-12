<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Atividade 5 - Aberta(Yearbook)</title>
        <meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Wilson Donizetti"/>
        <meta name="description" content="Pós Graduação Desenvolvimento Web PUC Minas, Atividade 5 Aberta"/>
        <link rel="stylesheet" href="Content/css/normalize.css"/>
        <link rel="stylesheet" href="Content/css/atividade.css"/>
        
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>

    <div class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarYearBook">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./Index.php">Yearbook</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarYearBook">
            
            <?php
                //require_once('./AuthSession.php');
                if(!empty($_SESSION['auth']) && ($_SESSION['auth']==true)){
                    echo '<form class="navbar-form navbar-left" role="search" method="post" action="./Busca.php">';
                    echo '<div class="form-group">';
                    echo '<input type="text" class="form-control" id="inputFiltro" name="filtro" placeholder="Nome participante">';
                    echo '</div>';
                    echo '<button type="submit" class="btn btn-default">Buscar</button>';
                    echo '</form>';
                    echo '<ul class="nav navbar-nav navbar-right">';
                    echo '<li><a href="./PerfilParticipante.php?participante='.htmlspecialchars($_SESSION['login']).'">'.htmlspecialchars($_SESSION['nomeCompleto']).'</a></li>';
                    echo '<li><a href="./Logout.php">Logout</a></li>';
                    echo '</ul>';
                }
            ?>
        </div>    
       </div>
    </div>

    <div class="container">

      <div class="starter-template">