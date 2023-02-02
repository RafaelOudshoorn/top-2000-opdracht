<?php
require_once "../static/database.php";

if ($_POST) {

    $stmtt = $con->prepare('SELECT 
    vote.`song_id`,
    s.name AS song,
    s.artist AS artiest,
    count(vote.`song_id`) AS aantal_stemmen
    FROM vote
    JOIN song s ON s.id = vote.`song_id`
    GROUP BY vote.`song_id`
    ORDER BY count(vote.`song_id`) desc
    LIMIT 2000;');

    $stmtt->execute();

    $topsongs = $stmtt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $con->prepare("SELECT * FROM song ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetchObject();

    function staatIn2000(array $topSongs, object $searchSong) : bool {
        foreach($topSongs as $song) {
            if($song->song == $searchSong->name) {
                return true;
            }
        }

        return false;
    }

    $result->in2000 = staatIn2000($topsongs, $result);

    echo json_encode($result);

}
