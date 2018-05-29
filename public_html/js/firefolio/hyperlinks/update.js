var hyperlinks = {
  update: function () {
    var hyperlinks = [];
    var url = $('#base-url').val() +
      $('#index-page').val() +
      '/backend/hyperlinks/update';

    $.each($('#hyperlinks').children(), function (index, value) {
      // Add the current screenshots data and add its data to the array
      hyperlinks.push({
        'id': $(this).data('id'),
        'header': $(this).find('input[name=header]').val(),
        'url': $(this).find('input[name=header]').val()
      });
    });

    var data = {
      hyperlinks: JSON.stringify(hyperlinks)
    }

    ajax.request.data(data, url);
  }
}
