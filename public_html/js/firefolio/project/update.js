$(document).ready(function () {
  var update = {
    form: $('#form'),
    button: {
      primary: $('#update'),
      save: $('#save')
    },
  save: function (redirect = false) {
      if (title.current != title.original) {
        ajax.request.form(
          $('#form'),
          $('#form').attr('action'),
          $('#form').attr('method'),
          $('#base-url').val() +
            $('#index-page').val() +
            '/backend/projects/update/' +
            generate_uri(title.current)
        );
      } else {
        ajax.request.form(
          $('#form'),
          $('#form').attr('action'),
          $('#form').attr('method')
        );
      }
    },
    open: function (checkboxes, uris) {
      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          open_window('projects/update/' + uris[checkbox].value);
        }
      }
    },
    saved: true
  };

  // Save and exit
  if (update.form != null) {
    // Submitting the form via the enter key
    update.form.submit(function (event) {
      event.preventDefault();

      screenshots.update();
      hyperlinks.update();
      ajax.request.form(
        $('#form'),
        $('#form').attr('action'),
        $('#form').attr('method'),
        $('#redirect-url').val()
      );
    });

    // Clicking the 'Finish' button
    $('button#finish').click(function (event) {
      event.preventDefault();

      screenshots.update();
      ajax.request.form(
        $('#form'),
        $('#form').attr('action'),
        $('#form').attr('method'),
        $('#redirect-url').val()
      );
    });

    var title = {
      original: $('input[name=title]').val(),
      current: $('input[name=title]').val()
    };

    $('input[name=title]').on('input', function () {
      title.current = $(this).val();
    });

    // Save and keep editing
    if (update.button.save !== null) {
      // Save the project when the button is clicked
      update.button.save.click(function (event) {
        event.preventDefault();

        screenshots.update();
        hyperlinks.update();
        update.save();
      });
    }

    // Override the keyboard shortcut to let them do that too
    $(window).bind('keydown', function (event) {
      if (event.ctrlKey || event.metaKey) {
        switch (String.fromCharCode(event.which).toLowerCase()) {
          case 's':
            event.preventDefault();

            screenshots.update();
            hyperlinks.update();
            update.save();
            break;
        }
      }
    });
  }

  // Opening multiple tabs for updating projects
  if (update.button.primary != null) {
    update.button.primary.click(function (event) {
      event.preventDefault();

      var checkboxes = $('input[name=toggle]');
      var uris = $('input[name=uri]');

      console.log(uris);

      update.open(checkboxes, uris);
    });
  }
});
