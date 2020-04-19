function fetchFriends() {
  const media = document.getElementById("media");

  var fetchFriendsInterval = setInterval(function () {
    var mediaTime = Math.round(media.currentTime);

    var horas = Math.floor((mediaTime % (60 * 60 * 24) / (60 * 60)));
    var minutos = Math.floor((mediaTime % (60 * 60) / 60));
    var segundos = Math.floor(mediaTime % 60);

    if (horas < 10) {
      horas = '0'+horas;
    }
    if (minutos < 10) {
      minutos = '0'+minutos;
    }
    if (segundos < 10) {
      segundos = '0'+segundos;
    }

    $.post(
      "api/playAPI.php",
      {
        action: "fetchUsers",
        salaId: document.getElementById("salaId").value,
      },
      function (data, status) {}
    )
      .done(function (data) {
        var parsed = JSON.parse(data);
        var newHTML = [];
        parsed.forEach((element) => {
          $("#friends").html(element);
          newHTML.push(
          '<div class="container">' +
            '<a>' + element.nombre + '</a>' +
            '<p>' + element.estado + '</p>' +
          '</div>'
          );
          $("#friends").html(newHTML.join(""));
        });
      })
      .fail(function (data) {
        alert("Ha ocurrido un error: " + data.responseText);
      });
      $.post(
        "api/playAPI.php",
        {
          action: "update",
          userId: document.getElementById("nameId").value,
          status: media.readyState >= 3 ? (media.paused ? 'PAUSADO EN '+horas+':'+minutos+':'+segundos :  horas+':'+minutos+':'+segundos) : 'Cargando...' ,
        },
        function (data, status) {}
      )
        .done(function (data) {})
        .fail(function (data) {
          alert("Ha ocurrido un error: " + data.responseText);
        });
  }, 500);
}
