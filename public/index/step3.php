<div class="mainL">
    <div class="lTitle">
        <div class="step">Stap 3</div>
        <div class="title">Jouw gegevens</div>
    </div>
    <div class="lContent">
        <div class="desc">
            Vul hier je gegevens in zodat we weten wie er gestemd heeft.
            Daarnaast hebben we nog wat aanvullende vragen voor je die niet
            verplicht zijn om je stem in te sturen.
        </div>
    </div>
</div>
<div class="mainR">
    <form method="POST" id="userdata">
        <label class="leftL" for="name">Naam *</label>
        <input type="text" name="name" id="name" required maxlength="50"> <br> <br>
        <label class="leftL" for="email">E-mailadres *</label>
        <input type="email" name="email" id="email" required maxlength="50"> <br> <br>
        <div class="descriptText">
            Deze gegevens zijn verplicht om je stem in te kunnen sturen.
            Zodat we weten dat je maar één keer hebt gestemd. We gaan je
            geen reclame sturen of je emailadres verkopen.
        </div> <br>
        <label class="leftL" for="zip">Postcode</label>
        <input type="text" name="zip" id="zip" maxlength="50"> <br> <br>
        <label class="leftL" for="city">Woonplaats</label>
        <input type="text" name="city" id="city" maxlength="50"> <br> <br>
        <label class="leftL" for="country">Land</label>
        <select name="country" id="country"> 
            <option disabled selected>Maak een keuze</option>
            <option value="nl">Nederland</option>
            <option value="be">België</option>
        </select> <br> <br>
        <label class="leftL" for="birthyear">Geboortejaar</label>
        <input type="text" name="birthyear" id="birthyear" maxlength="4"> <br> <br>
        <label class="leftL">Geslacht</label>
        <input type="radio" name="sex" id="m" value="man"> 
        <label for="m">Man</label> <br>
        <label class="leftL"></label>
        <input type="radio" name="sex" id="f" value="vrouw"> 
        <label for="f">Vrouw</label> <br>
        <label class="leftL"></label>
        <input type="radio" name="sex" id="a" value="anders">
        <label for="a">Anders</label> <br> <br>
        <div class="descriptText">
            We vragen deze details om een goed beeld te krijgen van onze
            stemmers. Het is niet verplicht om hierop te antwoorden als
            je wilt stemmen.
        </div> <br>
        <label class="leftL" for="phone" maxlength="20">Telefoonnummer</label>
        <input type="text" name="phone" id="phone"> <br> <br>
        <label class="leftL"></label>
        <input type="checkbox" name="contact" id="contact">
        <label for="contact">Ja, NPO Radio 2 mag contact met met opnemen voor de uitzending</label> <br> <br>
        <div class="descriptText">
            We vragen dit omdat we sommige mensen willen bellen om meer
            te weten te komen over hun keuzes en dit te gebruiken in de uitzending
        </div> <br>
        <label class="leftL"></label>
        <input type="checkbox" name="newsletter" id="newsletter">
        <label for="newsletter">Ja, NPPO Radio 2 mag me mailen over de Top 2000</label> <br> <br>
        <label class="leftL"></label>
        <input type="checkbox" name="EULA" id="EULA" required>
        <label for="EULA">Ik ga akkoord met de algemene voorwaarden</label> <br> <br>
        <div class="descriptText">
            Je moet minimaal 16 jaar zijn om deel te nemen aan deze dienst.
            Wil je meer informatie over hoe wij omgaan met jou gegevens,
            lees ons privacy statement.
        </div> <br>
        <label class="leftL"></label>
        <input type="checkbox" name="copy" id="copy">
        <label for="copy">Stuur mij een kopie van mijn stemlijst.</label> <br> <br> <br>
    </form>
    <div class="arrow g2">
        <div id="prev" class="arrowC">
            <div class="arrowTL"></div>
            <div class="arrowL">
                Vorige
            </div>
        </div>
        <div class="arrowC">
            <input  onclick="finalize(selectedSongs, customSongs, motivations)" type="submit" form="userdata" class="arrowR" value="Verstuur">
            <div class="arrowTR"></div>
        </div>
    </div>
</div>