$('document').ready(function () {
  $('#add-screenshot').click(debounce(function () {
    ajax.request.html(
      $('#id').val(), // Input
      $('#screenshots'), // Output
      $('#base-url').val() + // URL
        $('#index-page').val() +
        '/backend/screenshots/insert/' +
        $('#id').val(),
      true // Append HTML to DOM
    );
  }), 128);
});
