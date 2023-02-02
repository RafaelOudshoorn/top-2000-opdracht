<?php
    try{
        $con = new PDO("mysql:dbname=top2000_2;host=portfolio.ictcampus.nl;charset=utf8","top2000_2","TOP2000#@!");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>