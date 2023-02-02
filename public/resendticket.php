<?php
    include "../private/autoloader.php";

    TicketManager::resendTicket("apenstaartje.max@gmail.com");
?>
<!doctype html>
<html lang="en">
    <head>
<?php
    $webtitle = "Tickets";
    $stylesheets = array("ticket");
    include "../private/includes/head.php";        
?>
    </head>
    <body>
        <?php
            include "../private/includes/header.php";
        ?>
        <main class="main-container">
            <div class="main-left">
                <p class="main-left-text">
                    Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro. Nescio brains an Undead zombies. Sicut malus putrid voodoo horror. Nigh tofth eliv ingdead.
                </p>
            </div>
            <div class="main-right">
                <form class="main-form" method="post">
                    <div class="main-form-group">
                        <label class="main-form-label">E-Mail: </label> <br/>
                        <input class="main-form-input" type="text" name="email"/>
                    </div>
                    <div class="main-form-group">
                        <input type="submit"/>
                    </div>
                </form>
            </div>
        </main>
    <script>
        $(".date").change(function() {
            var date = $("#date").val();
            var time = $("#time").val();
            if(date !== "" && time !== "") {
                $.get(
                    "webservice.php?date=" + date + "&time=" + time,
                    function updatePage(data) {
                        $("#beschikbaar").html(data);
                    }
                );
            }
            else {
                $("#beschikbaar").html("-");
            }
        });
    </script>
    </body>
</html>
