$('document').ready(function () {
  var search = {
    bar: $('#search'),
    dropdown: $('#language'),
    grid: $('#projects'),
    url: $('#base-url').val() + 'index.php/search',
    attempt: function () {
      var data = {
        query: search.bar.val(),
        language: search.dropdown.val()
      };
      data[$('#csrf').attr('name')] = $('#csrf').val();

      var request = $.post(
        search.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        response = JSON.parse(response);

        // Remember to always regenerate the anti-CSRF hash
        $('#csrf').val(response.hash);

        if (response.success) {
          search.grid.html(response.html);
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      });
    }
  };

  if (search.bar != null) {
    search.bar.on('input', function () {
      search.attempt();
    });

    search.dropdown.on('input', function () {
      search.attempt();
    });
  }
});
