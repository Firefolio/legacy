$('document').ready(function () {
  $('#search').on('input', debounce(function () {
    ajax.request.html(
      $('#search').val(),
      '#projects',
      $('#base-url').val() + 'index.php/search'
    );
  }, 128));

  // Clear inputs if they were previously changed
  $('#search').val('');
  $('#dropdown').val('All');
});
