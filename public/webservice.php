<?php
    include "../private/autoloader.php";

    if(!isset($_GET["date"]) || !isset($_GET["time"])) {
        throw new Exception("Datetime not valid");
    }

    $date = $_GET["date"];
    $time = $_GET["time"];


    echo 75 - TicketManager::getAmountByDate($date, $time);