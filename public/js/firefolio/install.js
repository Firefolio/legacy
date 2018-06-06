$('document').ready(function () {
  $('#form').submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#form'),
      $('#form').attr('action'),
      $('#form').attr('method'),
      $('#redirect-url').val()
    );
  });
});
