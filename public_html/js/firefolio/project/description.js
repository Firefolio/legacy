$('document').ready(function () {
  $('#description').on('input', function (event) {
    ajax.request.html(
      $(this).val(),
      $('#description-preview'),
      $('#base-url').val() + 'firefolio/project/description'
    );
  });
});
