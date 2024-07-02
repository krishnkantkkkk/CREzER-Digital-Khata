<?php
ob_start();
require_once('data.php');
$table = "";
if (mysqli_num_rows($logged_in->query("select * from username")))
    $table = mysqli_fetch_assoc($logged_in->query("select * from username"))['username'];
else header("Location:register.php");
$query = "select * from $table";
$result = mysqli_query($users_borrowers, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khata</title>
    <link rel="stylesheet" href="style.css">
</head>

<body id="body">
    <?php include("navbar.php"); ?>
    <!-- Main Content -->
    <div class="container" id="container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="box" id="box<?= $row['Id'] ?>" ondblclick="showTransaction(event, this.id.slice(3))">
                <h3 class="name"><?php echo strtoupper($row['Name']) ?></h3>
                <h2 id="amount">&#8377;<?php echo strtoupper($row['Amount']) ?></h2>
                <button class="modify_button" id="<?php echo $row['Id'] ?>">Modify</button>
                <div id="delete_button">
                    <svg onclick="confirm(<?php echo $row['Id'] ?>)" version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 482.428 482.429" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0" />
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098 c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117 h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828 C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879 C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096 c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266 c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979 V115.744z" />
                                    <path d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07 c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z" />
                                    <path d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07 c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z" />
                                    <path d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07 c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        <?php } ?>
        <div class="box" id="add" title="Add New Borrower" onclick="createPopup()">
            <p id="plus">+</p>
        </div>
    </div>

    <!-- Template -->
    <div class="box" id="template">
        <button name="remove" id="decrease_button" value="Deduct">Paid</button>
        <button name="add" id="increase_button" value="Add">Borrowed</button>
        <button name="create" id="create_button" value="Create">Create</button>
        <input type="text" name="name" placeholder="Enter Name" id="name_input" autocomplete="off" required>
        <a id="confirm_button">Yes</a>
        <button id="cancel_button">No</button>
        <div id="buttons"></div>


        <!-- Form to Append inside the popup -->
        <form class="popup_form" method="post">
            <h1 class="command_text"></h1>
            <input type="text" name="id" id="hidden_input" autocomplete="off">
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
                    $res = $transactions->query("select * from transaction where lender_username= '$table' and borrower_id = $id order by dataTime desc");
                    $borrower_id = 'NO_USER';
                    if (mysqli_num_rows($res)) {
                        // To Edit Borrower Id
                        $borrower_id = strtoupper(mysqli_fetch_assoc($users_borrowers->query("select * from $table where id = '$id'"))['Name'] . "_" . mysqli_fetch_assoc($users_borrowers->query("select * from $table where id = '$id'"))['Id']);
                        while ($rows = $res->fetch_assoc()) { ?>
                            <div class="transaction_box">
                                <div class="memo_container">
                                    <div class="memo"><?= ucfirst($rows['memo']) ?></div>
                                    <div class="datetime"><?= $rows['dataTime'] ?></div>
                                </div>
                                <div class="transaction_amount<?= $rows['type'] ?>">&#8377;<?= $rows['amount'] ?><?php if ($rows['type'] == 'm') echo '<img class="transaction_img" src ="./images/deposit.svg">';
                                else echo '<img class="transaction_img" src="./images/note_down.svg">'; ?> </div>
                            </div>
                            <?php }
                    } else echo "<h3 style='color:#ff9945;'>User Doesn't Exists</h3>";
                    echo "<script>
                    document.getElementsByClassName('popup_container')[0].style='height:400px;';
                    document.getElementById('body').appendChild(document.getElementsByClassName('popup_background')[0]);
                    document.getElementsByClassName('popup_container')[0].appendChild(document.getElementsByClassName('transaction')[0]);
                    </script>";
                    echo "<script> document.querySelector('.borrower_id').innerHTML = '<span>#$borrower_id</span>' </script>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>
<?php
if (isset($_POST["create"])) {
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
        ob_end_flush();
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
            ob_end_flush();
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
        ob_end_flush();
    }
}

if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $users_borrowers->query("delete from $table where Id ={$id}");
    $transactions->query("DELETE FROM TRANSACTION WHERE lender_username='$table' AND borrower_id = '$id'");
    header("Location:main.php");
    ob_end_flush();
}

if (isset($_GET['logout'])) {
    $logged_in->query("DELETE FROM USERNAME WHERE USERNAME = '$table'");
    header("Location:index.php");
}
?>