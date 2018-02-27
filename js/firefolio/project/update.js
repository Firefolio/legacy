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
    attempt: function () {
      var inputs = this.form.find('input, textarea, button');
      var data = this.form.serialize();

      console.log(data);
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

        update.csrf.hash = response.hash;

        if (response.success) {
          return true;
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

      return false;
    },
    open: function (checkboxes, uris) {
      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          open_window('projects/update/' + uris[checkbox].value);
        }
      }
    }
  };

  console.log(update.csrf);

  // Save and exit
  if (update.form != null) {
    update.form.submit(function (event) {
      event.preventDefault();

      var project = update.form.serialize();

      if (update.attempt()) {
        window.location.replace(
          $('#base-url').val() +
          'index.php/firefolio/projects'
        );
      }
    });
  }

  // Save and keep editing
  if (update.button.save !== null) {
    // Save the project when the button is clicked
    update.button.save.click(function (event) {
      event.preventDefault();

      if (update.attempt()) {
        alert('Saved!');
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
