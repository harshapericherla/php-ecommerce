<?php

    function stickyValue($name)
    {
        if(isset($_POST[$name]))
        {
            echo $_POST[$name];
        }
        else
        {
            echo "";
        }
    }
?>