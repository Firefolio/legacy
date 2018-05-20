$('document').ready(function () {
  $('#save').click(function () {
    save_screenshots();
  });
});

function save_screenshots() {
  var screenshots = [];
  var url = $('#base-url') + $('#index-page') + '/backend/screenshots/update';

  // Iterate over each screenshot and add their data to the array
  $.each($('#screenshots').children(), function (index, value) {
    screenshots.push({
      id: $(this).data('id'),
      path: $(this).find('input[name=path]').val()
    });
  });

  var data = {
    screenshots: JSON.stringify(screenshots)
  }

  console.log('Data:', data);

  ajax.request.data(data, url);
}
