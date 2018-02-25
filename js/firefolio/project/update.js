$('document').ready(function () {
  var update = {
    form: $('#form'),
    button: $('#update'),
    url: $('#base-url').val() +
      'index.php/firefolio/projects/update/' +
      $('#uri').val() +
      '/submit',
    submit: function () {
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

        if (response.success) {
          window.location.replace(
            'http://localhost/firefolio/index.php/firefolio/projects'
          );
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

      update.submit();
    });
  }

  // Opening multiple tabs for updating projects
  if (update.button != null) {
    update.button.click(function (event) {
      event.preventDefault();

      var checkboxes = $('input[name=toggle]');
      var uris = $('input[name=uri]');

      console.log(uris);

      update.open(checkboxes, uris);
    });
  }
});
