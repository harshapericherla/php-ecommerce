<?php require_once("../functions/index.php") ?>
<html>
   <head>
     <link rel="stylesheet" href="../css/index.css" />
  </head>
  <body>
    <div class="navbar">
        <a class="navLink" href="../index.php">Home</a>
        <a class="navLink" href="./store.php">Store</a>
    </div>
     <div class="products">
         <?php storeAction()?>
     </div>
  </body>
</html>