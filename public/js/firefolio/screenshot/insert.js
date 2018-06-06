$('document').ready(function () {
  $('#add-screenshot').click(debounce(function () {
    var data = {
      project: $('#id').val()
    }

    ajax.request.html(
      data, // Input
      $('#screenshots'), // Output
      $('#base-url').val() + // URL
        $('#index-page').val() +
        '/backend/screenshots/insert',
      true // Append HTML to DOM
    );
  }, 128));
});
