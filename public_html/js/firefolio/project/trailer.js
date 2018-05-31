$('document').ready(function () {
  var limit = 128;

  // Update the thumbnail preview when new input is received
  $('#trailer').on('input', debounce(function () {
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/videos/get_thumbnail';
    var data = {
      url: $(this).val()
    }

    ajax.request.data(data, url, function (response) {
      $('#trailer-preview').attr('src', response.result)
    });
  }, limit));
});
