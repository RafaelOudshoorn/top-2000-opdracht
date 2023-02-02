<?php
    include "../private/autoloader.php";
    $schema = SchemaManager::getRadioSchema();
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
                    Dit is het radioschema van de dj's in het Top 2000 Cafe
                    <br><br>
                    ...
                    <br><br>
                    ...
                    <br><br>
                    ...
                </p>
            </div>
            <div class="main-right">
                <table class="table table-light">
                    <thead class="table-dark thxdx">
                        <tr>
                            <th>
                                Dj
                            </th>
                            <th>
                                Begintijd
                            </th>
                            <th>
                                Eindtijd
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($schema as $schedule) {
                                echo "
                                    <tr>
                                        <td>{$schedule->firstname} {$schedule->lastname}</td>
                                        <td>{$schedule->beginTime}</td>
                                        <td>{$schedule->endTime}</td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
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
