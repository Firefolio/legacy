$('document').ready(function () {
  var limit = 128;

  // Update the thumbnail preview when new input is received
  $('#thumbnail').on('input', debounce(function () {
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/purifier/purify';
    var data = {
      input: $(this).val()
    }

    ajax.request.data(data, url, function (response) {
      $('#thumbnail-preview').attr('src', response.result);
    });
  }, limit));
});
