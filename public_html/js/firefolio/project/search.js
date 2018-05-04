$('document').ready(function () {
  var url = $('#base-url').val() + $('#index-page').val() + '/backend/projects/search';
  var limit = 64; // Milliseconds

  // Make sure that the search bar is ready
  $('#search').removeAttr('disabled');

  $('#search').on('input', debounce(function () {
    ajax.request.html(
      $('#search').val(),
      '#projects',
      url
    );
  }, limit));
});
