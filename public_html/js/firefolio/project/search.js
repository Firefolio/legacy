$('document').ready(function () {
  var url = $('#base-url').val() +
            'index.php/backend/projects/search';
  var limit = 64; // Milliseconds

  $('#search').on('input', debounce(function () {
    ajax.request.html(
      $('#search').val(),
      '#projects',
      url
    );
  }, limit));
});
