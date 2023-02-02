<?php
require_once "../../static/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['search'])) {
        $Search = $_POST['search'];
    }
    if (isset($_POST['song'])) {
        $searchTrack = $_POST['song'];
    }

    $sql = "SELECT DISTINCT artist from song WHERE artist LIKE :artist LIMIT 5";
    if (isset($searchTrack)) {
        $sql = "SELECT name, id from song WHERE artist LIKE :artist AND `name` LIKE :song  LIMIT 5";
    }

    $stmt = $con->prepare($sql);
    $stmt->bindValue(':artist', $Search . "%");
    if (isset($searchTrack)) {
        $stmt->bindValue(':song', "%" . $searchTrack . "%");
    }

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);


    foreach ($result as $r) {
        if(isset($searchTrack)){
            $id = $r->id;
            echo "<a onclick='selectSong($id);'>$r->name</a> <br/>";
        }
        else{
            //$id = $r->id;
            echo "<a onclick='selectArtist(\"$r->artist\");'>$r->artist</a> <br/>";
        }
    }
}
?>
<script>
    function selectArtist(artist) {
        window.location.href = "staatheterin.php?artistname=" + artist;
    }
    function selectSong(id) {
        window.location.href += "&songid=" + id;
    }

</script>