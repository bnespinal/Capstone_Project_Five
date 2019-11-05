<?php
$pagename = "Authentication Confirmation";
require_once "header.inc.php";

?>
    <div class="row">

        <div class="side">
        </div>
        <div class="main">
            <?php

            if($_GET['state']==1)
            {
                echo "<p id='statment'>You have been logged out.  Please <a href='login.php'>log in</a> again to view restricted content.<p>";
            }
            elseif($_GET['state']==2)
            {
                echo "<p id='statment'>Welcome back, <b>" . $_SESSION['username'] . "</b>!</p>";
            }
            elseif($_GET['state']==3)
            {
                echo "<p id='statment'>Your password has been changed and you have been logged out.  Please <a href='login.php'>log in</a> again to view restricted content.<p>";
            }
            else
            {
                echo "<p id='statment'>Please continue by choosing an item from the menu.</p>";
            }
            ?>
        </div>
        <div class="side">
        </div>
    </div>
<?php

require_once "footer.inc.php";










