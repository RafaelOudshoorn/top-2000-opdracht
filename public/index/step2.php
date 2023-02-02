<div class="mainL">
    <div class="lTitle">
        <div class="step">Stap 2</div>
        <div class="title">Motiveer je keuzes</div>
    </div>
    <div class="lContent">
        <div class="desc">
            Waarom heb je voor deze platen gekozen?
        </div>
    </div>
</div>
<div class="mainR">
    <div class="songs">
        <table id="motivateTable">
            <script>
                $(document).ready(function() {
                    placeMotivate();
                    if(backupM != ""){
                        document.getElementById("motivateTable").innerHTML = backupM;
                        motivations.forEach(item => {
                            document.getElementById("ev" + item.id).value = item.text;
                        });
                        motivations = [];
                    }
                });
            </script>
        </table>
    </div>
    <div class="arrow g2">
        <div id="prev" class="arrowC">
            <div class="arrowTL"></div>
            <div class="arrowL" id="changexdx">
                Vorige
            </div>
        </div>
        <div id="next" class="arrowC">
            <div class="arrowR">
                Stap 3 | Jouw gegevens
            </div>
            <div class="arrowTR"></div>
        </div>
    </div>
</div>