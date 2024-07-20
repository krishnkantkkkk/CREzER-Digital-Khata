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
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body id="body">
    <?php include("navbar.php"); ?>
    <!-- Main Content -->
    <div class="switch_button">
        <button class="borrower_page_button">Borrowers</button>
        <button class="lender_page_button" onclick="window.location.href='lenders.php'">Lenders</button>
    </div>
    <div class="create_sticky_button" onclick="createPopup()">
        +
    </div>
    <div class="container" id="container">
        <?php
        $result = $totals->query("SELECT * FROM totals WHERE lender_id = '$user_id'");
        while ($row = mysqli_fetch_assoc($result)) {
            $name_in_card = mysqli_fetch_assoc($users->query("SELECT * FROM users WHERE user_id =" . $row['borrower_id']))['name'];
        ?>
            <div class="box" id="box<?= $row['borrower_id'] ?>" ondblclick="showTransaction(event, this.id.slice(3))">
                <h3 class="name"><?php echo strtoupper($name_in_card) ?></h3>
                <h2 id="amount">&#8377;<?php echo strtoupper($row['amount']) ?></h2>
                <button class="modify_button" id="<?php echo $row['borrower_id'] ?>">Modify</button>
                <div id="delete_button">
                    <svg onclick="confirm(<?php echo $row['borrower_id'] ?>)" version="1.1" id="delete_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 482.428 482.429" xml:space="preserve">
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
				<div class="error_message"></div>
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
            <input type="text" name="input_userid" id="input_userid" placeholder="Borrower Phone/UserId" autocomplete="off">
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
                    $res = $transactions->query("select * from transaction where lender_id='$user_id' and borrower_id = '$id' order by dataTime desc");
										$borrower_id = "NULL";
                    if (mysqli_num_rows($res)) {
											// To Edit Borrower Id
											$borrower_id = strtoupper(mysqli_fetch_assoc($users->query("select * from users where user_id = '$id'"))['name']) . "_" . $id;
                        while ($rows = mysqli_fetch_assoc($res)) { ?>
                            <div class="transaction_box">
                                <div class="memo_container">
                                    <div class="memo"><?= ucwords($rows['memo']) ?></div>
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

    <script src="scripts/main.js"></script>
</body>

</html>
<?php
if (isset($_POST["create"])) {
    $borrower_userid = ($_POST['input_userid']);
    $name = strtolower($_POST['name']);
    $amount = $_POST['amount'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Borrowed';
    if ($name != "" && $amount != null) {
        if (mysqli_num_rows($users->query("SELECT * FROM users WHERE username = '$borrower_userid' OR phone = '$borrower_userid'"))) 
        {
            $borrower_id = mysqli_fetch_assoc($users->query("SELECT * FROM users WHERE phone = '$borrower_userid' OR username = '$borrower_userid'"))['user_id'];
            if (mysqli_num_rows($totals->query("SELECT * FROM totals WHERE borrower_id = $borrower_id and lender_id=$user_id")))
              $totals->query("UPDATE totals SET amount = amount + $amount WHERE borrower_id=$borrower_id");
            else 
							$totals->query("INSERT INTO totals VALUES($borrower_id, $user_id, $amount)");
						$transactions->query("INSERT INTO transaction VALUES('$borrower_id', $user_id, $amount, '$memo', 'p', now())");
						header("Refresh:0");
					} 
					else 
					{
						if (is_numeric($borrower_userid)) 
						{
							$users->query("INSERT INTO users VALUES(null, null, '$name', '$borrower_userid', null)");
							$borrower_id = mysqli_fetch_assoc($users->query("SELECT * FROM users WHERE phone = $borrower_userid AND name = '$name'"))['user_id'];
							$totals->query("INSERT INTO totals VALUES($borrower_id, $user_id, $amount)");
							$transactions->query("INSERT INTO transaction VALUES('$borrower_id', $user_id, $amount, '$memo', 'p', now())");
							header("Refresh:0");
					}
					else 
						echo "<script>
						createPopup();
						let error_message = document.querySelector('.error_message');
						error_message.innerHTML = '\'<span>$borrower_userid</span>\' UserId Doesn\'t Exists<br>Try Phone Number';
						document.querySelector('.popup_form').appendChild(error_message);
						console.log('Hello');
						setTimeout(()=>{
							document.querySelector('.popup_form').removeChild(error_message);
							console.log('hi');
						},5000);
						</script>";
        }
			}
		} elseif (isset($_POST["remove"])) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Paid';
    $removeQuery = "update totals set Amount= Amount-{$amount} where borrower_id={$id} and lender_id=$user_id;";
    $check_amount = mysqli_fetch_assoc($totals->query("select Amount from totals where borrower_id={$id}"))['Amount'];
    if ($amount != null) {
			if ((int)$check_amount - $amount >= 0) {
            $transactions->query("INSERT INTO transaction VALUES('$id', $user_id, $amount, '$memo', 'm', now())");
            if ((int)$check_amount - $amount == 0) $users_borrowers->query("delete from totals where borrower_id = {$id}");
            else mysqli_query($totals, $removeQuery);
            header("Refresh:0");
        }
    }
} elseif (isset($_POST["add"])) {
    $id = $_POST['id'];
    $memo = $_POST['memo'];
    if (empty($memo)) $memo = 'Borrowed';
    $amount = $_POST['amount'];
    $addQuery = "update totals set Amount= Amount+{$amount} where borrower_id={$id} and lender_id=$user_id;";
    if ($amount != null) {
        $transactions->query("INSERT INTO transaction VALUES('$id', $user_id, $amount, '$memo', 'p', now())");
        mysqli_query($totals, $addQuery);
        header("Refresh:0");
    }
}

if (isset($_GET['delId'])) {
	$id = $_GET['delId'];
    $amount = mysqli_fetch_assoc($totals->query("SELECT * FROM totals WHERE borrower_id = $id AND lender_id = $user_id"))['amount'];
    $transactions->query("INSERT INTO transaction VALUES('$id', $user_id, $amount, 'paid', 'm', now())");
    $totals->query("delete from totals where borrower_id={$id} and lender_id = $user_id");
    header("Location:main.php");
	}
	
	if (isset($_GET['logout'])) {
		session_unset();
        header("Location:index.php");
	}
	ob_end_flush();
	?>