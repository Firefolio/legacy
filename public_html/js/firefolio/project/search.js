$('document').ready(function () {
  var url = $('#base-url').val() +
            'index.php/firefolio/projects/search';
  var limit = 128; // Milliseconds

  $('#search').on('input', function () {
    debounce(function () {
      ajax.request.html(
        $('#search').val(),
        '#projects',
        url
      );
    }, 250);
  });
});
