<?php require_once("../functions/index.php") ?>
<html>
  <body>
      <div class="navbar">
         <a class="navLink" href="../index.php">Home</a>
         <a class="navLink" href="./store.php">Store</a>
      </div>
     <div class="checkout">
         <div class="checkout-action">
            <?php checkOutAction() ?>
         </div>
         <?php if(isset($_SESSION["productId"])) {?>
            <form method="post">
               <div class="form-group">
                  <label>First Name:</label>
                  <input type="text" name="firstname" value="<?php stickyValue("firstname")?>" />
               </div>
               <div class="form-group">
                  <label>Last Name:</label>
                  <input type="text" name="lastname" value="<?php stickyValue("lastname")?>" />
               </div>
               <div class="form-group">
                  <label>Select Card</label>
                  <select name="cardType">
                     <option value="Master">Master</option>
                     <option value="Visa">Visa</option>
                  </select>
               </div>
               <input type="submit" />
            </form>
         <?php } ?>
     </div>
  </body>
</html>