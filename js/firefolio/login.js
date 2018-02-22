$('document').ready(function () {
  var login = {
    form: $('#form'),
    url: $('#base-url').val(),
    validate: function (username, password) {

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

  	login.attempt(username, password);
  });
});
