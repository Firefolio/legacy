$('document').ready(function () {
  var preview = {
    button: $('#preview'),
    open: function (checkboxes, uris) {
      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          open_window('../../index.php/project/' + uris[checkbox].value);
        }
      }
    }
  };

  // Preview multiple checked projects
  if (preview.button != null) {
    preview.button.click(function (event) {
      event.preventDefault();

      var checkboxes = $('input[name=toggle]');
      var uris = $('input[name=uri]');

      preview.open(checkboxes, uris);
    });
  }
});
