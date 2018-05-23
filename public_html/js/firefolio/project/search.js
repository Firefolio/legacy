$('document').ready(function () {
  var url = $('#base-url').val() +
            $('#index-page').val() +
            '/backend/projects/search';
  var limit = 64; // Milliseconds

  // Make sure that the search bar is ready before allowing input
  $('#search').removeAttr('disabled');

  $('#search').on('input', debounce(function () {
    var data = {
      input: $('#search').val()
    }

    ajax.request.html(
      data, // Query
      '#projects', // Node
      url // Search URL
    );
  }, limit));
});
