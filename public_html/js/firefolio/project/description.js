$('document').ready(function () {
  var url = $('#base-url').val() +
            $('#index-page') +
            '/markdown/parse';
  var limit = 128; // Milliseconds

  $('#description').on('input', debounce(function () {
    ajax.request.html(
      $('#description').val(), // Input markdown
      '#description-preview', // Output node
      url // Request destination
    );
  }, limit));
});
