<?php

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
                $innerHtml = "<div class='productswrapper'>";
                while($row = $result->fetch_array())
                {
                    $quantity = $row["quantity"];
                    if($quantity == 0)
                    {
                        $innerHtml .= "
                        <div class='product'>
                            <div><label>ProductName</label><div class='productname'>{$row["inventory_name"]}</div></div>
                            <div><label>Quantity</label><div class='productquantity'>out of stock</div></div>
                        </div>";
                    }
                    else
                    {
                        $innerHtml .= "
                        <div class='product'>
                            <div><label>ProductName</label><div class='productname'>{$row["inventory_name"]}</div></div>
                            <div><label>Quantity</label><div class='productquantity'>{$row["quantity"]}</div></div>
                            <div class='checkout'><a class='productbutton' href='store.php?productId={$row["inventory_id"]}'>checkout</a></div>
                        </div>";
                    }
                }
                $innerHtml .= "</div>";
            }
        }catch(Exception $e)
        {
            $innerHtml = $e->getMessage();
        }
        finally
        {
            if(isset($result))
            {
                $result->close();
            }
            $mysqli->close();
        }
        echo $innerHtml;
    }
