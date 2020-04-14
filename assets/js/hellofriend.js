function fetchFriends() {
  var fetchFriendsInterval = setInterval(function () {
    var now = new Date().getTime();

    $.post(
      "/api/playAPI.php",
      {
        action: "fetchUsers",
        salaId: document.getElementById("salaId").value,
      },
      function (data, status) {}
    )
      .done(function (data) {
        var parsed = JSON.parse(data);
        parsed.forEach(element => {
            console.log(element);
        });
      })
      .fail(function (data) {
        alert("Ha ocurrido un error: " + data.responseText);
      });
  }, 500);
}