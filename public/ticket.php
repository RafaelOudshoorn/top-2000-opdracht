<?php
    include "../private/autoloader.php";

    if ($_POST) {
        if (!TicketManager::checkBoughtTickets($_POST["email"])) {
            TicketManager::executeAll(
                $_POST["name"],
                $_POST["email"],
                $_POST["date"],
                $_POST["time"],
                $_POST["amount"]
            );
        } else {
            TicketManager::displayWarning("U heeft het maximum aantal tickets gekocht");
        }
    }
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
                    Hier kan je tickets bestellen voor het Top 2000 café
                    <br><br>
                    Je kan per persoon maar één keer tickets halen. Je hebt dan de keuze tussen 1 t/m 4 tickets.
                    <br><br>
                    Als je de tickets besteld hebt krijg je ze per e-mail binnen. In deze e-mail staan de qrcodes dus raak ze niet kwijt
                    <br><br>
                    Als je de tickets als nog kwijt bent kan je ze hier onder terug vragen.
                </p>
                <a class="main-left-text" href="resendticket.php" >Tickets kwijt?</a>
            </div>
            <div class="main-right">
                <form class="main-form" method="post">
                    <div class="main-form-group">
                        <label class="main-form-label">Naam: </label> <br/>
                        <input class="main-form-input" type="text" name="name"/>
                    </div>
                    <div class="main-form-group">
                        <label class="main-form-label">E-Mail: </label> <br/>
                        <input class="main-form-input" type="text" name="email"/>
                    </div>
                    <div class="main-form-group">
                        <label class="main-form-label">Aantal: </label> <br/>
                        <select name="amount">
                            <option hidden>-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>                    </div>
                    <div class="main-form-group">
                        <label class="main-form-label">Tijdslot: </label> <br/>
                        <select name="date" id="date" class="date">
                            <option value="" hidden>-</option>
                            <option value="2022-12-25">25 december</option>
                            <option value="2022-12-26">26 december</option>
                            <option value="2022-12-27">27 december</option>
                            <option value="2022-12-28">28 december</option>
                            <option value="2022-12-29">29 december</option>
                            <option value="2022-12-30">30 december</option>
                            <option value="2022-12-31">31 december</option>
                        </select>
                        <select name="time" id="time" class="date">
                            <option value="" hidden>-</option>
                            <option value="08:00">08:00</option>
                            <option value="10:00">10:00</option>
                            <option value="12:00">12:00</option>
                            <option value="14:00">14:00</option>
                            <option value="16:00">16:00</option>
                            <option value="18:00">18:00</option>
                            <option value="20:00">20:00</option>
                            <option value="22:00">22:00</option>
                        </select>
                        <p>Tickets beschikbaar: <span id="beschikbaar">-</span></p>
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
