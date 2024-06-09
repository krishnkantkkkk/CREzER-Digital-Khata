<?php
    $sql_host = "localhost";
    $sql_username = "root";
    $sql_password = "password";

    $check = mysqli_connect($sql_host, $sql_username, $sql_password);
    $check->query("CREATE DATABASE IF NOT EXISTS users");
    $check->query("CREATE DATABASE IF NOT EXISTS users_borrowers");
    $check->query("CREATE DATABASE IF NOT EXISTS logged_in");
    $check->query("CREATE DATABASE IF NOT EXISTS transactions");
    
    $users = mysqli_connect($sql_host, $sql_username, $sql_password, 'users');
    $users_borrowers = mysqli_connect($sql_host, $sql_username, $sql_password, 'users_borrowers');
    $logged_in = mysqli_connect($sql_host, $sql_username, $sql_password, 'logged_in');
    $transactions = mysqli_connect($sql_host, $sql_username, $sql_password, 'transactions');

    $logged_in->query("CREATE TABLE IF NOT EXISTS username(username varchar(20))");    
    $transactions->query("CREATE TABLE IF NOT EXISTS transaction(lender_username varchar(20), borrower_id int, amount int, type varchar(1), dataTime DATETIME)");

    // if(!$con) die("Connection Error");
?>