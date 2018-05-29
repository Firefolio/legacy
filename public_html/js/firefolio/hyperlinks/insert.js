$('document').ready(function () {
  var limit = 128;

  $('#insert-hyperlink').click(debounce(function () {
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/backend/hyperlinks/insert/project';
    var data = {
      project: $('#id').val()
    }

    ajax.request.html(
      data,
      $('#hyperlinks'),
      url,
      true // Append HTML to DOM
    );
  }, limit));
});
