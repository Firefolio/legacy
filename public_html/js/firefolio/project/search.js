$('document').ready(function () {
  var url = $('#base-url').val() +
            'index.php/firefolio/projects/search';
  
  $('#search').on('input', function () {
    ajax.request.html(
      $('#search').val(),
      '#projects',
      url
    );
  });
});
