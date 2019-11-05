<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 11/2/2019
 * Time: 8:00 AM
 */
$pagename = "Order Out";
require_once 'header.inc.php';
?>
<div class="row">
    <div class="side">
    </div>
    <div class="main">
<?php
checkLogin();
$showform = 1;
if($_SERVER['REQUEST_METHOD']== "POST"){
    $formdata['quantity'] = $_POST['quantity'];
    $formdata['price'] = $_POST['price'];
    $formdata['id'] = $_POST['id'];
    $formdata['food'] = $_POST['food'];
    try {
        $sql = "SELECT * FROM cart WHERE (id =:id AND user_id =:user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $formdata['id']);
        $stmt->bindValue(':user_id', $_SESSION['ID']);
        $stmt->execute();
        $count = $stmt->rowCount();
        echo $count;
    }catch(PDOException $e){
        die($e->getMessage());
    }
    if($count>0){
        try{
            $sql = "SELECT quantity FROM cart 
                   WHERE id =:food_id";
            $stmt= $pdo->prepare($sql);
            $stmt->bindValue(':food_id', $formdata['id']);
            $stmt->execute();
            $result = $stmt->fetch();
            $adjust_quantity = $result['quantity'] + $formdata['quantity'];

            $newsql = "UPDATE cart SET quantity =:quantity 
                      WHERE id =:id";
            $newstmt = $pdo->prepare($newsql);
            $newstmt->bindValue(':quantity', $adjust_quantity);
            $newstmt->bindValue(':id', $formdata['id']);
            $newstmt->execute();
            header('Location: cart.php');
        }catch(PDOException $e){

            die($e->getMessage());
        }
    }
    else {
        try {
            $sql = "INSERT INTO cart ( id, user_id, food, price, quantity) 
                    VALUES (:id, :user_id, :food, :price, :quantity)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $formdata['id']);
            $stmt->bindValue(":user_id", $_SESSION['ID']);
            $stmt->bindValue(':food', $formdata['food']);
            $stmt->bindValue(":price", $formdata['price']);
            $stmt->bindValue(":quantity", $formdata['quantity']);
            $stmt->execute();
            header("Location: cart.php");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
if($showform == 1) {
    try {
        $sql = "SELECT * FROM orders";
        $result = $pdo->query($sql);
        $food = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    ?>
    <form method="post" action="order.php">
    <table align="center">
    <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
    <?php
    foreach ($food as $item) {
        ?>
            <tr>
            <td><?php echo $item['food']; ?></td>
            <td><?php echo "$".$item['price']; ?></td>
            <td><input type="number" name="quantity" id="quantity" min='1' value="<?php if(isset($formdata['quantity'])){echo $formdata['quantity'];}?>">
            <input type="hidden" name="id" id="id" value="<?php echo $item['order_id'];?>">
            <input type="hidden" name="price" id="price" value="<?php echo $item['price'];?>">
            <input type="hidden" name="food" id="food" value="<?php echo $item['food'];?>">
            <input type="submit" name="submit" id="submit" class="btn btn-info" value="submit">
            </td>
            </tr>
        <?php
    }
    ?>
    </table>
    </form>
    <?php
}
?>
    </div>
    <div class="side">
    </div>
</div>
<?php
require_once 'footer.inc.php';
