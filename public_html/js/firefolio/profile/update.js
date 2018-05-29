var profile = {
  update: function () {
    ajax.request.form(
      $('#form'),
      $('#form').attr('action'),
      $('#form').attr('method')
    );
    hyperlinks.update();
  }
}

$('document').ready(function () {
  var limit = 128;

  $('#save').click(function () {
    debounce(profile.update(), limit)
  });

  $('#form').submit(function (event) {
    event.preventDefault();

    debounce(profile.update(), limit);
  });

  $(window).bind('keydown', function (event) {
    if (event.ctrlKey || event.metaKey) {
      switch (String.fromCharCode(event.which).toLowerCase()) {
        case 's':
          event.preventDefault();

          debounce(profile.update(), limit);
          break;
      }
    }
  });
});
