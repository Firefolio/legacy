screenshots.delete = function (id) {
  var url = $('#base-url').val() +
    $('#index-page').val() +
    '/backend/screenshots/delete';
  var data = {
    id: id
  }

  ajax.request.data(data, url);
}

$('document').ready(function () {
  $('.delete-screenshot').click(function (event) {
    event.preventDefault();

    // Remove that screenshot from the database via an AJAX request
    screenshots.delete($(this).data('id'));
    // Hide the input in the DOM
    console.log($(this).parents());
  });
});
