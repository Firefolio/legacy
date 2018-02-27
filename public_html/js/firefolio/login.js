$('document').ready(function () {
  var login = {
    form: $('#form'),
    url: $('#base-url').val() + 'index.php/login/attempt',
    validate: function (username, password) {
      var valid = false;

      if (username.length > 0 && username.length > 0) {
        valid = true;
      } else {
        $('#error').html('Please fill in all form fields');
      }

      return valid;
    },
    attempt: function (username, password) {
      var inputs = this.form.find('input, button');
      var data = this.form.serialize();

      inputs.prop('disabled', true);

  		request = $.post(
        login.url,
        data,
        "JSON"
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
          login.form.effect('shake');
        }
      });

      request.fail(function (message) {
        console.error(message);
      })

      request.always(function () {
        inputs.prop('disabled', false);
      });
    }
  };

  login.form.submit(function (event) {
    event.preventDefault();

  	var username = $('#username').val();
  	var password = $('#password').val();

  	if (login.validate(username, password)) {
      login.attempt(username, password);
    }
  });
});
