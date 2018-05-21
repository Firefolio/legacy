$('document').ready(function () {
  // Allow the list of screenshots to be saved
  // When the save button is clicked
  $('#save').click(function () {
    save_screenshots();
  });

  // When the user has finished editing

  $(window).bind('keydown', function (event) {
    if (event.ctrlKey || event.metaKey) {
      switch (String.fromCharCode(event.which).toLowerCase()) {
        case 's':
          event.preventDefault();

          save_screenshots();
          break;
      }
    }
  });
});

function save_screenshots() {
  var screenshots = [];
  var url = $('#base-url').val() + $('#index-page').val() + '/backend/screenshots/update';

  // Iterate over each screenshot and add their data to the array
  $.each($('#screenshots').children(), function (index, value) {
    screenshots.push({
      'id': $(this).data('id'),
      'path': $(this).find('input[name=path]').val()
    });
  });

  var data = {
    screenshots: JSON.stringify(screenshots)
  }

  ajax.request.data(data, url);
}
