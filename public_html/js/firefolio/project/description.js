$('document').ready(function () {
  var url = $('#base-url').val() +
            'index.php/markdown/parse';

  $('#description').on('input', function () {
    ajax.request.html(
      $(this).val(),
      $('#description-preview'),
      url
    );
  });
});
