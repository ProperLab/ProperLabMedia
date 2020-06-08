function validURL(str) {
  var pattern = new RegExp(
    "^(https?:\\/\\/)?" + // protocol
    "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
    "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
    "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
    "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
      "(\\#[-a-z\\d_]*)?$",
    "i"
  ); // fragment locator
  return !!pattern.test(str);
}

function fetchRooms() {
  $.get("api/playAPI.php", function (data, status) {
    var parsed = JSON.parse(data);
    var newHTML = [];
    newHTML.push(
      "<p>Tus salas creadas:</p>" +
        `<table>
      <tr>
        <th>Video</th>
        <th style="width: 25%;">Sala</th>
        <th style="width: 25%;">Ver</th>
      </tr>`
    );
    parsed.forEach((element) => {
      $("#rooms").html(element);
      newHTML.push(
        "<tr>" +
          "<td>" +
          element.video +
          "</td>" +
          "<td>" +
          element.sala +
          "</td>" +
          "<td>" +
          '<a href="play.php?p=' +
          element.sala +
          '">Ir a la sala' +
          "</a>" +
          "</td>" +
          "</tr>"
      );
    });
    newHTML.push("</table>");
    $("#rooms").html(newHTML.join(""));
  });
}

$(document).ready(function () {
  "use strict";
  $("#datos").click(function () {
    var videoUrl = $("#video-url").val();

    if (videoUrl === "") {
      $("#message").fadeOut(0, function () {
        $(this)
          .html(
            '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor introduce la url del vídeo</div>'
          )
          .fadeIn();
      });
      $("#video-url").attr("disabled", false);
      $("#datos").attr("disabled", false);
      $("#cerrar").attr("disabled", false);
      $("#salir").attr("disabled", false);
    } else if (!validURL(videoUrl)) {
      $("#message").fadeOut(0, function () {
        $(this)
          .html(
            '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Por favor introduce una url válida</div>'
          )
          .fadeIn();
      });
      $("#video-url").attr("disabled", false);
      $("#datos").attr("disabled", false);
      $("#cerrar").attr("disabled", false);
      $("#salir").attr("disabled", false);
    } else {
      $.ajax({
        type: "POST",
        url: "api/sendform.php",
        data: {
          videoUrl: videoUrl,
        },
        // dataType: 'JSON', (En el caso de que el servidor devuelva JSON)
        success: function (html) {
          $("#message").fadeOut(0, function () {
            $(this).html(html).fadeIn();
          });
        },
        error: function (textStatus, errorThrown) {
          console.log(textStatus);
          console.log(errorThrown);
          if (textStatus.status == 429) {
            $("#message").fadeOut(0, function () {
              $(this)
                .html(
                  "<div class='alert alert-warning'>" +
                    textStatus.responseText +
                    "</div>"
                )
                .fadeIn();
            });
          } else {
            $("#message").fadeOut(0, function () {
              $(this)
                .html(
                  "<div class='alert alert-danger'>Ha ocurrido un error interno del servidor, si el error persiste contacte con ProperLab o crea un issue en Github. Error:" +
                    textStatus.responseText +
                    "</div>"
                )
                .fadeIn();
            });
          }
          $("#video-url").attr("disabled", false);
          $("#datos").attr("disabled", false);
          $("#cerrar").attr("disabled", false);
          $("#salir").attr("disabled", false);
        },
        beforeSend: function () {
          $("#video-url").attr("disabled", true);
          $("#datos").attr("disabled", true);
          $("#cerrar").attr("disabled", true);
          $("#salir").attr("disabled", true);
          $("#message").fadeOut(0, function () {
            $(this)
              .html(
                "<p class='text-center'><img src='assets/img/icon/ajax-loader.gif'></p>"
              )
              .fadeIn();
          });
        },
      });
    }
  });
});
