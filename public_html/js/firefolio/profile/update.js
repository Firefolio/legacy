var profile = {
  update: function () {
    ajax.request.form(
      $('#form'),
      $('#form').attr('action'),
      $('#form').attr('method')
    );
  }
}

$('document').ready(function () {
  var limit = 128;

  $('#save').click(function () {
    profile.update();
    hyperlinks.update();
  });

  $('#form').submit(function (event) {
    event.preventDefault();

    debounce(function () {
      profile.update();
      hyperlinks.update();
    }, limit);
  });
});
