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

  $('#description').removeAttr('disabled');

  $('#description').on('input', debounce(function () {
    ajax.request.html(
      $('#description').val(),
      '#description-preview',
      $('#base-url').val() + $('#index-page').val() + '/markdown/parse'
    );
  }, 128));
});
