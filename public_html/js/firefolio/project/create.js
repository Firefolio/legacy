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

  $('#description').on('input', debounce(function () {
    ajax.request.html(
      $('#description').val(),
      '#description-preview',
      $('#base-url').val() + 'index.php/markdown/parse'
    );
  }, 128));
});
