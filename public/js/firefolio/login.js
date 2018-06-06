var login = {
  validate: function (username, password) {
    var valid = false;

    if (username.length > 0 && username.length > 0) {
      valid = true;
    } else {
      $('#error').html('Please fill in all form fields');
      $('#error').effect('pulsate');
    }

    return valid;
  },
  attempt: function () {

  }
};

$('document').ready(function () {
  // Fade in the login form
  // Remove the attribute that hides it from the browser
  $('#form').removeAttr('hidden');
  $('#logo').removeAttr('hidden');
  // Then play the animation
  $('#form').hide();
  $('#logo').hide();
  $('#form').show('fade');
  // Make sure the logo appears after the form
  $('#logo').delay('medium').show('fade');

  $('#form').submit(function (event) {
    event.preventDefault();

  	if (login.validate($('#username').val(), $('#password').val())) {
      ajax.request.form(
        $('#form'),
        $('#form').attr('action'),
        $('#form').attr('method'),
        $('#redirect-url').val()
      );
    }
  });
});
