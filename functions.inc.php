<?php



function checkLogin()
{
    if(!isset($_SESSION['ID']))
    {
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.inc.php";
        exit();
    }
}
function checkDup($pdo, $sql, $userentry)
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $userentry);
        $stmt->execute();
        return $stmt->rowCount();
    }
    catch (PDOException $e)
    {
        echo "<p class='error'> Error checking duplicate entries!" . $e->getMessage() . "</p>";
        exit();
    }
}



