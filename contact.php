<?php
/**
 * Created by PhpStorm.
 * User: bnespinal
 * Date: 11/4/2019
 * Time: 5:45 PM
 */
$pagename = "Contact US";
include_once "header.inc.php";
?>
    <div class="row">
        <div class="side">
        </div>
        <div class="main">
    <h2>Contact Us</h2>
<?php
checkLogin();
$showform = 1;
$errmsg = 0;
$errcomment = "";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $formdata['comment'] = trim($_POST['comment']);
    if (empty($formdata['comment'])) {$errcomment = "A comment is required."; $errmsg = 1; }
    if($errmsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{
        try{
            $sql = "INSERT INTO survey (comment, inputdate)
                    VALUES (:comment, :inputdate) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':comment', $formdata['comment']);
            $stmt->bindValue(':inputdate', $rightnow);
            $stmt->execute();

            $showform =0; //hide the form
            echo "<p class='success'>Thanks for sending us a message!</p>";

            $to = $_SESSION['email'];
            $from = 'Project 5 Restaurant update';
            $subject = 'Survey';
            $message = 'This is a message to confirm the sending of a survey with this project site.';

            mail($to, $from, $subject, $message);
        }
        catch (PDOException $e)
        {
            die( $e->getMessage() );
        }
    }
}
if($showform == 1)
{
    ?>
    <form name="contact" id="contact" method="post" action="contact.php">
        <table class = "center">
            <tr><th><label for="comment">Message:</label><span class="error">*</span></th>
                <td><span class="error"><?php if(isset($errcomment)){echo $errcomment;}?></span>
                    <textarea name="comment" id="comment" placeholder="Required Comment"><?php if(isset($formdata['comment'])){echo $formdata['comment'];}?></textarea>
                </td>
            </tr>
            <tr><th><label for="submit">Submit:</label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>

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
include_once "footer.inc.php";
?>
<?php
