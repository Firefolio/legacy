$('document').ready(function () {
  $('#form').submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $(this),
      $(this).attr('action'),
      $(this).attr('method'),
      $('#redirect-url').val()
    );
  });

  $('[name=create]').click(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#form'),
      $('#form').attr('action'),
      $('#form').attr('method'),
      $('#redirect-url').val()
    );
  });
});
