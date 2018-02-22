$('document').ready(function () {
  var login = {
    form: $('#form'),
    request: {},
    attempt: function () {

    }
  };

  login.form.on('submit', function (event) {
    event.preventDefault();
  });
});
