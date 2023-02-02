function SupriseSong() {
  $.ajax({
    url: "../public/verras.php",
    method: "POST",
    data: { action: "call_this" },
    success: function (data) {
      var song = JSON.parse(data);
      console.log(song);
      $("#surpise-song-artist").html(song.name + " van " + song.artist);

      if(song.in2000 == false) {
        $("#status-2000").html('Staat er niet in!');
      }
      else{
        $("#status-2000").html('Staat er in!');
      }
     
      $("#suprise-container").show();
    },
  });
}
