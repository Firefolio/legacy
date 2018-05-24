$('document').ready(function () {
  var url = $('#base-url').val() + $('#index-page') + '/markdown/parse';
  var limit = 128; // Milliseconds
  var data = {
    description: $('#description').val()
  }

  $('#description').on('input', debounce(function () {
    ajax.request.html(
      data, // Input markdown
      $('#description-preview'), // Output node
      url // Request destination
    );
  }, limit));
});
