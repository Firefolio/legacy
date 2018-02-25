$('document').ready(function () {
  // Can't use 'delete' as that's a reserved keyword
  var del = {
    button: $('#delete'),
    url: 'projects/delete',
    attempt: function (checkboxes, uris) {
      var projects_to_delete = [];

      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          projects_to_delete.push(uris[checkbox].value);
        }
      }

      var data = {
        projects: JSON.stringify(projects_to_delete);
      };

      request = $.post(
        del.url,
        data,
        'JSON'
      );

      request.done(function (message) {

      });

      request.fail(function (message) {
        console.console.error(message);
      });
    }
  };

  if (del.button != null) {
    del.button.click(function (event) {
      event.preventDefault();

      var checkboxes = $('input[name=toggle]');
      var uris = $('input[name=uri]');

      del.attempt(checkboxes, uris);
    });
  }
});
