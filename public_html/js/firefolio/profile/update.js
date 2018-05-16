$('document').ready(function () {
  var update = {
    url: $('#base-url').val() + $('#index-page') + '/backend/profile/update',
    form: $('#form')
    }
  };

  update.form.submit(function (event) {
    event.preventDefault();

    update.attempt();
  });
});
