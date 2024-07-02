<?php
$sql_host = "localhost";
$sql_username = "root";
$sql_password = "password";

$check = mysqli_connect($sql_host, $sql_username, $sql_password);
$check->query("CREATE DATABASE IF NOT EXISTS users");
$check->query("CREATE DATABASE IF NOT EXISTS totals");
$check->query("CREATE DATABASE IF NOT EXISTS logged_in");
$check->query("CREATE DATABASE IF NOT EXISTS transactions");

$users = mysqli_connect($sql_host, $sql_username, $sql_password, 'users');
$totals = mysqli_connect($sql_host, $sql_username, $sql_password, 'totals');
$logged_in = mysqli_connect($sql_host, $sql_username, $sql_password, 'logged_in');
$transactions = mysqli_connect($sql_host, $sql_username, $sql_password, 'transactions');

$users->query("CREATE TABLE IF NOT EXISTS users(user_id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(20) unique, name VARCHAR(20), phone varchar(15) unique, password VARCHAR(20))");
$totals->query("CREATE TABLE IF NOT EXISTS totals(borrower_id int, lender_id int, amount int)");
$logged_in->query("CREATE TABLE IF NOT EXISTS username(username varchar(20), user_id int)");
$transactions->query("CREATE TABLE IF NOT EXISTS transaction(borrower_id int, lender_id int, amount int, memo varchar(30), type varchar(1), dataTime DATETIME)");
