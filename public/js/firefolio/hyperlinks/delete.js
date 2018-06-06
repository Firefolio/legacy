hyperlinks.delete = function (id) {
  var url = $('#base-url').val() +
    $('#index-page').val() +
    '/backend/hyperlinks/delete';
  var data = {
    id: id
  }

  ajax.request.data(data, url);
}

$('.delete-hyperlink').click(function (event) {
  event.preventDefault();

  // Remove that screenshot from the database via an AJAX request
  hyperlinks.delete($(this).parents('.hyperlink').data('id'));
  // Remove that element from the DOM
  $(this).parents('div.hyperlink').remove();
});
