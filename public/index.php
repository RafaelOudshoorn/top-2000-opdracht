<?php
    include "../private/autoloader.php";
    if($_POST){
        if(userManager::checkExist($_POST["email"]) == false && isset($_POST["EULA"])){
            userManager::addUser($_POST);
            $user = userManager::getUser($_POST);
            musicManager::addCustom(json_decode($_COOKIE["custom"]));
            $motivations = musicManager::matchCustom(json_decode($_COOKIE["custom"]), json_decode($_COOKIE["motivate"]));
            $selectedSongs = musicManager::matchSongs(json_decode($_COOKIE["custom"]), explode(",", $_COOKIE["selected"]));
            musicManager::pushVotes($selectedSongs, $motivations, $user);
            if(isset($_POST["copy"])){
                musicManager::sendList($selectedSongs, $_POST["email"]);
            }
        }
    }
    $time = localtime(time(),true);
    if(!($time["tm_year"] == 122 && $time["tm_mon"] == 11 && $time["tm_mday"] >= 1 && $time["tm_mday"] <= 7)){
        header("Location: novote.php");
    }
?>
<!doctype html>
<html lang="en">
    <head>
    <?php
        $webtitle = "stem tool";
        $stylesheets = array("tempIndex");
        include "../private/includes/head.php";        
    ?>
        <script src="scripts/tempIndex.js"></script>

    </head>
    <body>
        <div id="addCustom">
            <div class="customForm">
                <label for="customTitle">Titel</label>
                <input type="text" id="customTitle"> <br> <br>
                <label for="customArtist">Artiest</label>
                <input type="text" id="customArtist"> <br> <br>
                <button onclick="customForm()">Terug</button>
                <button onclick="addCustom()">Voeg toe</button>
            </div>
        </div>

    <?php
        include "../private/includes/header.php";
    ?>
    
        <main class="main-container" id="content">
            
        </main>
    </body>
</html>