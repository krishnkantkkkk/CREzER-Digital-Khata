<?php
ob_start();
session_start();
require_once('data.php');
$user_id = $_SESSION['logged_in'];
if(!$user_id) header("Location:register.php");
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Khata</title>
        <link rel="stylesheet" href="styles/lender.css">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    
    <body id="body">
        <?php include("navbar.php"); ?>
        <!-- Main Content -->
        <div class="switch_button">
            <button class="borrower_page_button" onclick="window.location.href='main.php'">Borrowers</button>
            <button class="lender_page_button">Lenders</button>
        </div>
        <div class="container" id="container">
            <?php 
            $result = $totals->query("SELECT * FROM totals WHERE borrower_id = '$user_id'");
            if(mysqli_num_rows($result)){
            while ($row = mysqli_fetch_assoc($result)) {
            $name_in_card = mysqli_fetch_assoc($users->query("SELECT * FROM users WHERE user_id =" .$row['lender_id']))['name'];
            ?>
            <div class="box" id="box<?= $row['lender_id'] ?>" ondblclick="showTransaction(event, this.id.slice(3))">
                <h3 class="name"><?php echo strtoupper($name_in_card) ?></h3>
                <h2 id="amount">&#8377;<?php echo strtoupper($row['amount']) ?></h2>
                <button class="pay_button" id="<?php echo $row['lender_id'] ?>">Pay</button>
            </div>
        <?php }}
        else echo "<p style='color:var(--color6); font-size:1rem; width:100%; text-align:center;'>NOT ANY LENDER</p>";
         ?>
    </div>

    <!-- Template -->
    <div class="box" id="template">
        <button name="pay" id="payButton" value="Pay">Pay</button>
        <input type="text" name="name" placeholder="Enter Name" id="name_input" autocomplete="off" required>
        <a id="confirm_button">Yes</a>
        <button id="cancel_button">No</button>
        <div id="buttons"></div>


        <!-- Form to Append inside the popup -->
        <form class="popup_form" method="post">
            <h1 class="command_text"></h1>
            <input type="text" name="id" id="hidden_input" autocomplete="off">
            <input type="text" name="input_userid" id="input_userid" placeholder="Borrower Phone/UserId" required autocomplete="off">
            <input type="number" step="0.01" name="amount" placeholder="Enter Amount" id="amount_input" autocomplete="off" required onkeydown="pay_or_borrow(event)">
            <input type="text" name="memo" id="memo_input" placeholder="Enter Memo" autocomplete="off" onkeydown="pay_or_borrow(event)">
        </form>

        <div class="popup_background" onclick="popdown(event)">
            <div class="popup_container">
                <img src="./images/close-button-svgrepo-com.svg" class="popup_close_button" onclick="popdown(event)">
                <!-- Append Anything -->
            </div>
        </div>

        <!-- Element to Append inside the popup for transaction -->
        <div class="transaction">
            <div class="borrower_id"></div>
            <h2>Transactions</h2>
            <div class="transactions_table">
            <?php
                if (isset($_GET['transaction_id'])) {
                    $id = $_GET['transaction_id'];
                    $res = $transactions->query("select * from transaction where lender_id='$id' and borrower_id = '$user_id' order by dataTime desc");
                    $borrower_id = "";
                    if (mysqli_num_rows($res)) {
                        // To Edit Borrower Id
                        $borrower_id = strtoupper(mysqli_fetch_assoc($users->query("select * from users where user_id = '$id'"))['name']) . "_" . $id;
                        while ($rows = mysqli_fetch_assoc($res)) { ?>
                            <div class="transaction_box">
                                <div class="memo_container">
                                    <div class="memo"><?= ucfirst($rows['memo']) ?></div>
                                    <div class="datetime"><?= $rows['dataTime'] ?></div>
                                </div>
                                <div class="transaction_amount<?= $rows['type'] ?>">&#8377;<?= $rows['amount'] ?><?php if ($rows['type'] == 'm') echo '<img class="transaction_img" src ="./images/deposit.svg">';
                                else echo '<img class="transaction_img" src="./images/note_down.svg">'; ?> </div>
                            </div>
                <?php }
                    } else echo "<h3 style='color:#ff9945;'>No Transactions</h3>";
                    echo "<script>
                    document.getElementsByClassName('popup_container')[0].style='height:400px;';
                    document.getElementById('body').appendChild(document.getElementsByClassName('popup_background')[0]);
                    document.getElementsByClassName('popup_container')[0].appendChild(document.getElementsByClassName('transaction')[0]);
                    document.querySelector('.borrower_id').innerHTML = '<span>#$borrower_id</span>' </script>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="scripts/lenders.js"></script>
</body>

</html>
<?php
if (isset($_POST["create"])) {
    $borrower_userid = ($_POST['input_userid']);
    $name = strtolower($_POST['name']);
    $amount = $_POST['amount'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Borrowed';
    $createQuery = "insert into $table values(null, '{$name}', {$amount})";
    if ($name != "" && $amount != null) {
        mysqli_query($users_borrowers, $createQuery);
        $borrower_id = (int)mysqli_fetch_assoc($users_borrowers->query("SELECT max(id) from $table"))['max(id)'];
        $transactions->query("INSERT INTO TRANSACTION VALUES('$table', $borrower_id, $amount, '$memo', 'p', now())");
        header("Refresh:0");
    }
} elseif (isset($_POST["remove"])) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Paid';
    $removeQuery = "update $table set Amount= Amount-{$amount} where Id={$id};";
    $check_amount = mysqli_fetch_assoc($users_borrowers->query("select Amount from $table where id={$id}"))['Amount'];
    if ($amount != null) {
        if ((int)$check_amount - $amount >= 0) {
            $transactions->query("INSERT INTO TRANSACTION VALUES('$table', $id, $amount, '$memo', 'm', now())");
            if ((int)$check_amount - $amount == 0) $users_borrowers->query("delete from $table where Id = {$id}");
            else mysqli_query($users_borrowers, $removeQuery);
            header("Refresh:0");
        }
    }
} elseif (isset($_POST["add"])) {
    $id = $_POST['id'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Borrowed';
    $amount = $_POST['amount'];
    $addQuery = "update $table set Amount= Amount+{$amount} where Id={$id};";
    if ($amount != null) {
        $transactions->query("INSERT INTO TRANSACTION VALUES('$table', $id, $amount, '$memo', 'p', now())");
        mysqli_query($users_borrowers, $addQuery);
        header("Refresh:0");
    }
}

if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $users_borrowers->query("delete from $table where Id ={$id}");
    $transactions->query("DELETE FROM TRANSACTION WHERE lender_username='$table' AND borrower_id = '$id'");
    header("Location:main.php");
}

if (isset($_GET['logout'])) {
    $logged_in->query("DELETE FROM USERNAME WHERE USERNAME = '$table'");
    header("Location:index.php");
}
ob_end_flush();
?>