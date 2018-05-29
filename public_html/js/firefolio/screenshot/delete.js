screenshots.delete = function (id) {
  var url = $('#base-url').val() +
    $('#index-page').val() +
    '/backend/screenshots/delete';
  var data = {
    id: id
  }

  ajax.request.data(data, url);
}

$('.screenshot').on('click', '.delete-screenshot', function (event) {
  event.preventDefault();

  // Remove that screenshot from the database via an AJAX request
  screenshots.delete($(this).parents('.screenshot').data('id'));
  // Remove that element from the DOM
  $(this).parents('div.screenshot').remove();
});
