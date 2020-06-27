<?php
   require_once("./dbConnection.php");

   session_start();
   function storeAction()
   {
       if($_SERVER["REQUEST_METHOD"] == "GET")
       {
           if(isset($_GET["productId"]))
           {
              storeProductIDInSession();
           }
           else
           {
              fetchProducts();
           }
       }
   }

   function storeProductIDInSession()
   {
       $_SESSION["productId"] = $_GET["productId"];
       header("Location: checkout.php");
       die();
   }

   function fetchProducts()
   {
      global $mysqli;
      try{

        $selectQuery = "SELECT inventory_id,inventory_name,quantity FROM inventory";
        $result = $mysqli->query($selectQuery);
        if($result->num_rows > 0)
        {
            $innerHtml = "<div class'products'>";
            while($row = $result->fetch_array())
            {
                $innerHtml .= "
                <div class='product'>
                    <div class='productname'>{$row["inventory_name"]}</div>
                    <div class='productquantity'>{$row["quantity"]}</div>
                    <a class='productbutton' href='store.php?productId={$row["inventory_id"]}'>checkout</a>
                </div>";
            }
            $innerHtml .= "</div>";
        }
        $result->close();
        $mysqli->close();
      }catch(Exception $e)
      {
         $innerHtml = $e->getMessage();
      }
      echo $innerHtml;
   }
?>