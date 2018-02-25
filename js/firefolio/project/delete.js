$('document').ready(function () {
  // Can't use 'delete' as that's a reserved keyword
  var del = {
    button: $('#delete'),
    attempt: function (checkboxes, uris) {
      var projects_to_delete = [];

      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          projects_to_delete.push(uris[checkbox].value);
        }
      }

      console.log(projects_to_delete);
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
