$('document').ready(function () {
  var update = {
    url: $('#base-url').val() + $('#index-page') + '/backend/profile/update',
    form: $('#form')
  };

  update.form.submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#form'),
      $('#form').attr('action'),
      $('#form').attr('method')
    );
  });
});
