<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 11/1/2019
 * Time: 6:23 PM
 */
require_once "header.inc.php";
checkLogin();
?>
    <div class="row">
        <div class="side">
        </div>
        <div class="main">
<?php
echo "<h3 align='center'><a href='order.php'>Continue Shopping?</a></h3>";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $formdata['remove'] = $_POST['remove'];
    $formdata['id'] = $_POST['id'];
    $formdata['quantity'] = $_POST['quantity'];
    if($formdata['remove'] == 'yes'){
        try{
            $sql = "DELETE FROM cart WHERE id =:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $formdata['id']);
            $stmt->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    else{
        try{
            $sql = "UPDATE cart SET quantity = :quantity WHERE id =:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':quantity', $formdata['quantity']);
            $stmt->bindValue(':id', $formdata['id']);
            $stmt->execute();

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
try {
    $sql = "SELECT * FROM cart WHERE user_id = :user_id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['ID']);
    $stmt->execute();
    $count = $stmt->rowCount();
    $user_order = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
    $ctotal = $count;
    ?>
    <form id='cart' method="post" action="cart.php">
    <table align="center">
    <?php
    foreach ($user_order as $item) {
        $ctotal += $item['price'] * $item['quantity'];
        $food_total = $item['price'] * $item['quantity'];
        ?>
                    <tr>
                        <td><?php echo $item['food']; ?></td>
                        <td>$ <?php echo $item['price']; ?></td>
                        <td><label for="quantity">Quantity</label></td>
                        <td><input type="number" id='quantity' name="quantity" value="<?php
                            if(isset($formdata['quantity']) && !empty($formdata['quantity']))           {
                                echo $formdata['quantity'];
                            }
                            else
                            {
                                echo $item['quantity'];
                            }

                            ?>"/></td>
                        <td><label for="remove">Remove</label></td>
                        <td><select name="remove" id="remove">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                            </select></td>
                        <td><input type="hidden" name="id" id="id" value="<?php echo $item['id'];?>"/></td>
                        <td><input type="submit" name="submit" id="submit" value="submit"/></td>
                    </tr>
        <?php
}
    ?>
    <tr><?php $ctotal ?></tr>
    </table>
    </form>
    <?php
    ?>

    <br/>
    <h3>Total: <?php echo $ctotal;?></h3>
    <?php
    if($ctotal > 0) {
        ?>
        <h2 id="payment" align="center"><a href="payment.php">Process Payment</a></h2>
        <?php
    }
    ?>
    </div>
    <div class="side">
    </div>
    </div>
<?php
require_once "footer.inc.php";