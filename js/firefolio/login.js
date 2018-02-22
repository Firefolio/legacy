$('document').ready(function () {
  var login = {
    form: $('#form'),
    request: {},
    attempt: function (username, password) {
		var success = false;
		
		console.log(username + password);
		
		return success;
    }
  };

  login.form.submit(function (event) {
    event.preventDefault();
	
	var username = $('#username').val();
	var password = $('#password').val();
	
	if (login.attempt(username, password) === true) {
		
	} else {
		console.error('Login attempt failed');
	}
  });
});
