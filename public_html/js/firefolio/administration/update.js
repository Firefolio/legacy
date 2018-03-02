$('document').ready(function () {
  var update = {
    url: $('#base_url'),
    attempt: {
      username: function () {
        console.log('username');
      },
      password: function () {
        console.log('password');
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
