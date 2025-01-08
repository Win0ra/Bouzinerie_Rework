<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <link rel="stylesheet" href="public/css/styles-navbar.css" type="text/css" media="all">
   <script src="https://kit.fontawesome.com/e98829b701.js" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body>
   <div class="Navbar admin">
      <ul>
         <li><a href="index.php?page=home">Front</a></li>
         <li><a href="index.php?page=admin&action=questions">Gérer les Questions</a></li>
         <li><a href="index.php?page=admin&action=categories">Gérer les catégories</a></li>
         <li><a href="index.php?page=admin&action=users">Gérer les utilisateurs</a></li>
         <li><a href="index.php?page=logout">Déconnexion</a></li>

      </ul>
      <div class="logo"><a href="index.php?page=home"><img src="<?php dirname(__DIR__) ?>public/img/logo_bleu.svg" alt="logo_la_bouzinerie"></a></div>
   </div>
   </div>

</body>

</html>