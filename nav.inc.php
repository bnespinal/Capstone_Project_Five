<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date: 10/31/2019
 * Time: 7:29 PM
 */


?>
<ul>
    <?php
        echo ($currentfile == "index.php") ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
        echo ($currentfile == "memberinsert.php") ? "<li>Register</li>" : "<li><a href='memberinsert.php'>Register</a></li>";
        echo ($currentfile == "Menu.php") ? "<li>Menu</li>" : "<li><a href='Menu.php'>Menu</a></li>";
        echo ($currentfile == "commentdetails.php") ? "<li>Reviews</li>" : "<li><a href='commentdetails.php'>Reviews</a></li>";
        echo ($currentfile == "about.php") ? "<li>About Us</li>" : "<li><a href='about.php'>About Us</a></li>";

        if (isset($_SESSION['ID'])) {
            echo "<li><a href='memberpwd.php?ID=" . $_SESSION['ID'] ."'>Update My Password</a>";
            echo "<li><a href='order.php?ID=" . $_SESSION['ID'] ."'>Take Out</a>";
            echo "<li><a href='cart.php?ID=" . $_SESSION['ID'] ."'>My Cart</a>";
            echo "<li><a href='contact.php?ID=" . $_SESSION['ID'] ."'>Send a Message</a>";
            echo "<li><a href='logout.php'>Log Out</a></li>";
            echo "Welcome, " . $_SESSION['username'];
        } else {
            echo "<li><a href='login.php'>Log In</a></li>";
        }
    ?>
</ul>

