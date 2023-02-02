let selectedSongs = [];
let contentSongs = "";
let backup = [];
let custom = 1;
let backupM = "";

$(document).ready(function() {
    getStep("index/step1.php");

    let step = 1;
    $(document).on('click','#next',function () {
        switch (step){
            case 1:
                if(selectedSongs.length >=5 && selectedSongs.length <=35){
                  selectedSongs.forEach(setMotivate);
                  document.getElementById("content").innerHTML = "";
                  getStep("index/step2.php")
                  step = 2;
                }
                break;
            case 2:
              updateMotivateValues();
              backupM = document.getElementById("motivateTable").innerHTML
              getStep("index/step3.php")
              finalize(selectedSongs, customSongs, motivations);
              step = 3;
              break;
        }
    });
    $(document).on('click','#prev',function () {
      switch (step){
          case 2:
            document.getElementById("changexdx").innerHTML = "Nummers aan het laden...";
            document.getElementById("motivateTable").innerHTML = "";
            getStep("index/step1.php")
            step = 1;
            backup = selectedSongs;
            selectedSongs = [];
            motivations = [];
            break;
          case 3:
            getStep("index/step2.php")
            step = 2;
            break;
      }
  });
});

function recoverSongs(item) {
  if(item <= 1998){
    song = customSongs.find(i => i.id === item);
    title = song.t
    artist = song.a
    if(title != "" && artist != ""){
      if(selectedSongs.length <=35){
        selectedSongs.push(customId);
    
        selected = document.getElementById("yourSongs");
        selected.innerHTML = selected.innerHTML + "<tr id='ID" + song.id + "'><td class='tImg'><img src='images/covers/default.png' alt='" + song.t + "' class='sSImg'></td><td class='tName'>" + song.t + " <br><span class='tArtist'>" + song.a + "</span></td><td class='tBtn' onclick='remove(" + song.id + ")'><span class='material-symbols-outlined'>delete</span></td></tr>";
  
        customSongs.push({id:customId, t:title, a:artist});
  
        title = document.getElementById("customTitle").value = "";
        artist = document.getElementById("customArtist").value = "";
        customId++;
        customForm();
      }
    }
  } else{
  select(item);
  }
}

function getStep(step) {
    $.get(
        step,
        function(data) {
            $("#content").html(data);
        }
    );
}

function search() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchField");
    filter = input.value.toUpperCase();
    table = document.getElementById("songsTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

function select(id){
  if(!selectedSongs.includes(id) && selectedSongs.length <=34){
    song = document.getElementById("id" + id);
    song.style.backgroundColor = "#71797E";
    title = song.dataset.title;
    artist = song.dataset.artist;
    cover = song.dataset.cover;

    xdx1 = document.getElementById("xdxarow1");
    xdx2 = document.getElementById("xdxarow2");
    if(selectedSongs.length <=3){
      xdx1.style.backgroundColor = "gray";
      xdx2.style.borderLeft = "15px solid gray";
    } else{
      xdx1.style.backgroundColor = "yellowgreen";
      xdx2.style.borderLeft = "15px solid yellowgreen";
    }

    selectedSongs.push(id);

    selected = document.getElementById("yourSongs");
    selected.innerHTML = selected.innerHTML + "<tr id='ID" + id + "'><td class='tImg'><img src='" + cover +"' alt='" + title + "' class='sSImg'></td><td class='tName'>" + title + " <br><span class='tArtist'>" + artist + "</span></td><td class='tBtn' onclick='remove(" + id + ")'><span class='material-symbols-outlined cursor'>delete</span></td></tr>";
  }
}

function remove(id){
  songS = document.getElementById("ID" + id)
  songS.remove();

  if(id >= 1999){
    song = document.getElementById("id" + id);
    song.style.backgroundColor = "";
  }

  selectedSongs = selectedSongs.filter(function(item) {
    return item !== id
  })
  
  xdx1 = document.getElementById("xdxarow1");
  xdx2 = document.getElementById("xdxarow2");
  if(selectedSongs.length <=4){
    xdx1.style.backgroundColor = "gray";
    xdx2.style.borderLeft = "15px solid gray";
  } else{
    xdx1.style.backgroundColor = "yellowgreen";
    xdx2.style.borderLeft = "15px solid yellowgreen";
  }
}

function setMotivate(item){
  if(item <= 1998){
    song = customSongs.find(i => i.id === item);
    contentSongs += "<tr id='m" + item + "'><td class='tImg'><img src='images/covers/default.png' alt='" + song.t + "' class='sSImg'></td><td class='tName'>" + song.t + " <br><span class='tArtist'>" + song.a + "</span></td><td class='tBtn' onclick='editMotivate("+item+")'><span class='material-symbols-outlined cursor'>edit</span></td></tr><tr id='e"+item+"' class='editField'><td colspan='3'><textarea id='ev"+item+"' placeholder='Max 200 tekens' maxlength='200'></textarea></td></tr>";
  } else{
    song = document.getElementById("id" + item);
    title = song.dataset.title;
    artist = song.dataset.artist;
    cover = song.dataset.cover;
    contentSongs += "<tr id='m" + item + "'><td class='tImg'><img src='" + cover +"' alt='" + title + "' class='sSImg'></td><td class='tName'>" + title + " <br><span class='tArtist'>" + artist + "</span></td><td class='tBtn' onclick='editMotivate("+item+")'><span class='material-symbols-outlined cursor'>edit</span></td></tr></tr><tr id='e"+item+"' class='editField'><td colspan='3'><textarea id='ev"+item+"' placeholder='Max 200 tekens' maxlength='200'></textarea></td></tr>";
  }
}

function placeMotivate(){
  document.getElementById("motivateTable").innerHTML = contentSongs;
  contentSongs = "";
}

formStatus = 0;
function customForm(){
  form = document.getElementById("addCustom")
  header = document.getElementById("header")
  main = document.getElementById("content")
  if(formStatus == 0){
    formStatus = 1;
    form.style.display = "flex"
    header.style.filter = "blur(4px)"
    main.style.filter = "blur(4px)"
  } else{
    formStatus = 0;
    form.style.display = "none"
    header.style.filter = ""
    main.style.filter = ""
  }
}

customId = 0;
let customSongs = [];

function addCustom(){
  title = document.getElementById("customTitle").value;
  artist = document.getElementById("customArtist").value;
  if(title != "" && artist != ""){
    if(selectedSongs.length <=35){
      selectedSongs.push(customId);
  
      selected = document.getElementById("yourSongs");
      selected.innerHTML = selected.innerHTML + "<tr id='ID" + customId + "'><td class='tImg'><img src='images/covers/default.png' alt='" + title + "' class='sSImg'></td><td class='tName'>" + title + " <br><span class='tArtist'>" + artist + "</span></td><td class='tBtn' onclick='remove(" + customId + ")'><span class='material-symbols-outlined cursor'>delete</span></td></tr>";

      customSongs.push({id:customId, t:title, a:artist});

      title = document.getElementById("customTitle").value = "";
      artist = document.getElementById("customArtist").value = "";
      customId++;
      customForm();
      formStatus = 0;
    }
  }
}

function editMotivate(id){
  form = "e" + id;
  editField = document.getElementById(form)
  if(editField.style.display == "table"){
    editField.style.setProperty("display", "none", "important")
  } else{
  editField.style.setProperty("display", "table", "important")
  }
}

let motivations = [];
function updateMotivateValues(){
  selectedSongs.forEach(element => {
    tr = document.getElementById("ev" + element).value;
    motivation = {id:element, text:tr};
    motivations.push(motivation);
  });
}

function createCookie(name, value) {
  document.cookie = escape(name) + "=" + escape(value) + "" + "; path=/";
}

function searchLetter(input) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  table = document.getElementById("songsTable");
  tr = table.getElementsByTagName("tr");
  filter = input.toUpperCase();

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < tr.length; i++) {
    txtValue = tr[i].dataset.title
    if (txtValue) {
      txt = txtValue[0].toUpperCase()
      if (txt == filter) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

trigger = false;
function triggerFilter(){
  switch (trigger){
    case false:
      document.getElementById("letterFilter").style.display = "flex";
      document.getElementById("songsTableB").style.maxHeight = "62vh";
      trigger = true;
      break;
    case true:
      document.getElementById("letterFilter").style.display = "none";
      document.getElementById("songsTableB").style.maxHeight = "64vh";
      trigger = false;
      break;
  }
}

function finalize(selected, customsong, motivations){
  createCookie("selected", selected);
  custom = JSON.stringify(customsong);
  createCookie("custom", custom);
  motivate = JSON.stringify(motivations);
  createCookie("motivate", motivate);
}