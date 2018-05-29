var screenshots = {
  update: function () {
    var screenshots = [];
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/backend/screenshots/update';

    // Iterate over each screenshot and add their data to the array
    $.each($('#screenshots').children(), function (index, value) {
      screenshots.push({
        'id': $(this).data('id'),
        'path': $(this).find('input[name=path]').val(),
        'caption': $(this).find('input[name=caption]').val()
      });
    });

    var data = {
      screenshots: JSON.stringify(screenshots)
    }

    ajax.request.data(data, url);
  }
};
