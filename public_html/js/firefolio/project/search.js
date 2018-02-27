$('document').ready(function () {
  var search = {
    bar: $('#search'),
    list: $('#projects'),
    url: $('#base-url').val() + 'index.php/firefolio/projects/search',
    attempt: function () {
      var data = {
        query: search.bar.val()
      };
      data[$('#csrf').attr('name')] = $('#csrf').val();

      var request = $.post(
        search.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        response = JSON.parse(response);

        if (response.success) {
          $('#csrf').val(response.hash);
          search.list.html(response.html);
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
  }
});
