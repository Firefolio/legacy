$(document).ready(function () {
  var update = {
    form: $('#form'),
    button: {
      primary: $('#update'),
      save: $('#save')
    },
    url: $('#base-url').val() +
         'index.php/firefolio/projects/update/' +
         $('#uri').val() +
         '/submit',
    csrf: {
      name: $('#csrf').attr('name'),
      hash: $('#csrf').val()
    },
    attempt: function (url) {
      var inputs = this.form.find('input, textarea, button');
      var data = this.form.serialize();
      var success = false;

      inputs.prop('disabled', true);

      var request = $.post(
        update.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        // Generate a new anti-CSRF hash
        update.csrf.hash = response.hash;
        $('#csrf').val(response.hash);

        if (response.success) {
          console.log(response.message);

          // Only redirect the user if a URL is specified
          if (url != null) {
            window.location.replace(url);
          }
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      })

      request.always(function () {
        inputs.prop('disabled', false);
      });
    },
    open: function (checkboxes, uris) {
      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          open_window('projects/update/' + uris[checkbox].value);
        }
      }
    }
  };

  // Save and exit
  if (update.form != null) {
    update.form.submit(function (event) {
      event.preventDefault();

      var project = update.form.serialize();
      var url = $('#base-url').val() +
                'index.php/firefolio/projects';

      update.attempt(url);
    });

    var title = {
      original: $('input[name=title]').val(),
      current: $('input[name=title]').val()
    };

    $('input[name=title]').on('input', function () {
      title.current = $(this).val();
      console.log(title);
    });
  }

  // Save and keep editing
  if (update.button.save !== null) {
    // Save the project when the button is clicked
    update.button.save.click(function (event) {
      event.preventDefault();

      if (title.current != title.original) {
        update.attempt(
          $('#base-url').val() +
          'index.php/firefolio/projects'
        );
      } else {
        update.attempt();
      }
    });

    // Override the keyboard shortcut to let them do that too
    $(window).bind('keydown', function (event) {
      if (event.ctrlKey || event.metaKey) {
        switch (String.fromCharCode(event.which).toLowerCase()) {
          case 's':
            event.preventDefault();
            update.attempt();
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
