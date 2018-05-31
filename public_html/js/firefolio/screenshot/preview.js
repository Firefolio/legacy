$('document').ready(function () {
  var limit = 128;

  // When the user inputs a new screenshot path,
  // let them see the screenshot working
  $('.screenshot').find('input[name=path]').on('input', debounce(function () {
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/purifier/purify';
    var data = {
      input: $(this).val()
    }
    // Get a reference to the preview image in the DOM
    var preview = $(this).parent().siblings().find('img.screenshot-preview');

    ajax.request.data(data, url, function (response) {
      preview.attr('src', response.result);
    });
  }, limit));
});
