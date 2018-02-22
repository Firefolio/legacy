$('document').ready(function () {
  var login = {
    form: $('#form'),
    url: $('#base-url').val(),
    validate: function (username, password) {
      var valid = false;

      if (username.length > 0 && username.length > 0) {
        valid = true;
      } else {
        // TODO: replace with an animated DOM error
        alert('Please fill in all form fields');
      }

      return valid;
    },
    attempt: function (username, password) {
  		var success = false;
      var inputs = this.form.find('input, button');
      var data = this.form.serialize();

      inputs.prop('disabled', true);

  		request = $.post(
        this.url + 'index.php/login/attempt',
        data,
        "JSON"
      );

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          window.location.replace('http://localhost/index.php/backend/');
        } else {
          console.error(response.message);
        }
      });

      request.always(function () {
        inputs.prop('disabled', false);
      });

  		return success;
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
