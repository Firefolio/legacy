$('document').ready(function () {
  $('#add-screenshot').click(function (event) {
    event.preventDefault();

    ajax.request.html(
      $('input#id').val(), // Input
      $('#screenshots'), // Output
      $('#base-url').val() + // URL
        $('#index-page').val() +
        '/backend/screenshots/insert/' +
        $('#id').val(),
      true // Append HTML to DOM
    );
  });
});
