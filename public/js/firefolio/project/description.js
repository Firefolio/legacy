$('document').ready(function () {
  var url = $('#base-url').val() + $('#index-page').val() + '/markdown/parse';
  var limit = 128; // Milliseconds

  $('#description').on('input', debounce(function () {
    var data = {
      description: $('#description').val()
    }

    ajax.request.html(
      data, // Input markdown
      $('#description-preview'), // Output node
      url // Request destination
    );
  }, limit));
});
