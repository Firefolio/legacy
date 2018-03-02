$('document').ready(function () {
  var update = {
    attempt: {
      username: function () {
        var form = $('#update-username');
        var inputs = form.find('text, button');
        var url = $('#base-url').val() +
                  'index.php/firefolio/administration/update/username';
        var data = {
          'username': $('#new-username').val()
        }
        data[$('#csrf').attr('name')] = $('#csrf').val();

        inputs.prop('disabled', true);

        var request = $.post(
          url,
          data,
          'JSON'
        );

        request.done(function (response) {
          console.log(response);
          response = JSON.parse(response);
          console.log(response);
        });

        request.fail(function (message) {
          console.error(message);
        });

        request.always(function () {
          inputs.prop('disabled', false);
        });
      },
      password: function () {
        var form = $('#update-password');
        var inputs = form.find('text, button');
        var url = $('#base-url').val() +
                  'index.php/firefolio/administration/update/password';
        var data = {
          'username': $('#new-username').val()
        }
        data[$('#csrf').attr('name')] = $('#csrf').val();

        inputs.prop('disabled', true);

        var request = $.post(
          url,
          data,
          'JSON'
        );

        request.done(function (response) {
          console.log(response);
          response = JSON.parse(response);
          console.log(response);
        });

        request.fail(function (message) {
          console.error(message);
        });

        request.always(function () {
          inputs.prop('disabled', false);
        });
      }
    }
  };

  if ($('#update-username') != null) {
    $('#update-username').submit(function (event) {
      event.preventDefault();

      update.attempt.username();
    });
  }

  if ($('#update-password') != null) {
    $('#update-password').submit(function (event) {
      event.preventDefault();

      update.attempt.password();
    });
  }
});
