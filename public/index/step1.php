<?php

    require_once "../../static/database.php";
    require_once "../../private/managers/musicManager.php";
    $songs = musicManager::getAll();

?>
<div class="mainL">
    <div class="lTitle">
        <div class="step">Stap 1</div>
        <div class="title">Wat zijn de beste nummers ooit?</div>
    </div>
    <div class="lContent">
        <div class="desc">
            Van 1 tot en met 7 December kan je hier je
            stem uitbrengen voor de Top 2000, editie
            2022!
            <br> <br>
            Selecteer minimaal 5 en maximaal 35 nummers.
            <br> <br>
            <span style="font-size:20px;">Jouw stemlijst<span style="float:right; font-size:15px;">(MIN 5, MAX 35)</span></span>
        </div>
        <div class="lElement">  
            <table id="yourSongs">
                <tbody>
                    <script>
                        $(document).ready(function(){
                            backup.forEach(recoverSongs);
                            backup = [];
                        });
                    </script>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mainR">
    <div class="songs">
        <div class="hotbar">
            <input type="text" id="searchField" onkeyup="search()" placeholder="Zoek naar nummer of artiest...">
            <div id="filter" onclick="triggerFilter()">
                <span class="material-symbols-outlined cursor">filter_alt</span>
            </div>
        </div>
        <div id="letterFilter">
            <div onclick="searchLetter('a')">A</div>
            <div onclick="searchLetter('b')">B</div>
            <div onclick="searchLetter('c')">C</div>
            <div onclick="searchLetter('d')">D</div>
            <div onclick="searchLetter('e')">E</div>
            <div onclick="searchLetter('f')">F</div>
            <div onclick="searchLetter('g')">G</div>
            <div onclick="searchLetter('h')">H</div>
            <div onclick="searchLetter('i')">I</div>
            <div onclick="searchLetter('j')">J</div>
            <div onclick="searchLetter('k')">K</div>
            <div onclick="searchLetter('l')">L</div>
            <div onclick="searchLetter('m')">M</div>
            <div onclick="searchLetter('n')">N</div>
            <div onclick="searchLetter('o')">O</div>
            <div onclick="searchLetter('p')">P</div>
            <div onclick="searchLetter('q')">Q</div>
            <div onclick="searchLetter('r')">R</div>
            <div onclick="searchLetter('s')">S</div>
            <div onclick="searchLetter('t')">T</div>
            <div onclick="searchLetter('u')">U</div>
            <div onclick="searchLetter('v')">V</div>
            <div onclick="searchLetter('w')">W</div>
            <div onclick="searchLetter('x')">X</div>
            <div onclick="searchLetter('y')">Y</div>
            <div onclick="searchLetter('z')">Z</div>
        </div>
        
        <table id="songsTable">
            <tbody id="songsTableB">
                <tr>
                    <td class="tImg"><img src="images/covers/default.png" alt="Default"></td>
                    <td class="tName">Voeg je eigen nummer toe</td>
                    <td class="tBtn" onclick="customForm()"><span class='material-symbols-outlined cursor'>add_box</span></td>
                </tr>
                <?php
                    foreach($songs as $song){
                        echo "
                            <tr id='id$song->id' data-title='$song->name' data-artist='$song->artist' data-cover='images/covers/default.png'>
                                <td class='tImg'><img src='images/covers/default.png' alt='$song->name' class='sSImg'></td>
                                <td class='tName'>
                                    $song->name <br>
                                    <span class='tArtist'>$song->artist</span>
                                </td>
                                <td class='tBtn' onclick='select($song->id)'><span class='material-symbols-outlined cursor'>add_box</span></td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="arrow g1">
        <div id="next" class="arrowC">
            <div class="arrowR" style="background-color:gray" id="xdxarow1">
                Stap 2 | Motiveer je keuze
            </div>
            <div class="arrowTR" style="border-left: 15px solid gray" id="xdxarow2"></div>
        </div>
    </div>
</div>