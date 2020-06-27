<?php

    function checkOutAction()
    {
        checkSessionAndRedirect();
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $firstname = strip_tags($_POST["firstname"]);
            $lastname = strip_tags($_POST["lastname"]);
            $cardType = strip_tags($_POST["cardType"]);
            $errMsg = validateCheckOutForm($firstname,$lastname,$cardType);

            if(strlen($errMsg) == 0)
            {
                placeOrder($firstname,$lastname,$cardType);
                unset($_POST);
                unset($_SESSION["productId"]);
            }
            else
            {
                echo $errMsg;
            }
        }
    }
    
    function checkSessionAndRedirect()
    {
        if(!isset($_SESSION["productId"]))
        {
            header("Location: store.php");
            die();
        }
    }

    function placeOrder($firstname,$lastname,$cardType)
    {
        $innerHTML = "";
        global $mysqli;
        $inventoryId = (int)$_SESSION["productId"];
        try{
            $mysqli -> autocommit(FALSE);

            $insert_order_query = "INSERT INTO inventory_order values(null,?,?,?)";
            // inserting new order record 
            $stmt = $mysqli -> prepare($insert_order_query);
            $stmt->bind_param("sss",$firstname,$lastname,$cardType);
            $stmt->execute();
            if($stmt->affected_rows == 0)
            {
                throw new Exception("Unable to insert order");
            }

            $orderId = (int)$stmt->insert_id;
            $i_od_query = "INSERT INTO inventory_order_details values(null,?,?)";
            // inserting new order details record
            $stmt = $mysqli -> prepare($i_od_query);
            $stmt->bind_param("ii",$orderId,$inventoryId);
            $stmt->execute();
            if($stmt->affected_rows == 0)
            {
                throw new Exception("Unable to insert into order details");
            }

            $update_query = "UPDATE inventory SET quantity = quantity - 1 WHERE inventory_id = ?";
            // reducing the quantity
            $stmt = $mysqli -> prepare($update_query);
            $stmt->bind_param("i",$inventoryId);
            $stmt->execute();
            if($stmt->affected_rows == 0)
            {
                throw new Exception("Unable to reduce the quantity");
            }
            $mysqli->commit();
            $innerHTML = "Order has been placed successfully";
        }catch(Exception $e)
        {
            $mysqli->rollback();
            $innerHTML = $e->getMessage();
        }
        finally{
            if(isset($stmt))
            {
                $stmt->close();
            }
            $mysqli->close();
        }
        echo $innerHTML;
    }

    function validateCheckOutForm($firstname,$lastname,$cardType)
    {
        $errMsg = "";
        if(empty($firstname))
        {
            $errMsg .= "firstname should not be empty<br/>";
        }

        if(empty($lastname))
        {
            $errMsg .= "lastname should not be empty<br/>";
        }

        if(empty($cardType))
        {
            $errMsg .= "cardtype should not be empty<br/>";
        }
        return $errMsg;
    }

?>