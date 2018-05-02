$('document').ready(function () {
  var login = {
    validate: function (username, password) {
      var valid = false;

      if (username.length > 0 && username.length > 0) {
        valid = true;
      } else {
        $('#error').html('Please fill in all form fields');
      }

      return valid;
    }
  };

  $('#form').submit(function (event) {
    event.preventDefault();

  	if (login.validate($('#username').val(), $('#password').val())) {
      ajax.request.form(
        $('#form'),
        $('#form').attr('action'),
        $('#form').attr('method'),
        $('#redirect-url').val()
      );
    } else {
      // Reset the password field for another attempt
      $('#password').val('');
    }
  });
});
