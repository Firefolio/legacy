$('document').ready(function () {
  // Enable each of the inputs
  $('#search').prop('disabled', false);
  $('#like').prop('disabled', false);
  $('#by').prop('disabled', false);
  $('#order').prop('disabled', false);

  $('#search').on('input', debounce(search, 128));
  $('#like').on('input', debounce(search, 128));
  $('#by').on('input', debounce(search, 128));
  $('#order').on('input', debounce(search, 128));

  // Clear inputs if they were previously changed
  $('#search').val('');
});

function search() {
  var url = $('#base-url').val() + $('#index-page').val() + '/search';
  var data = {
    search: $('#search').val(),
    like: $('#like').val(),
    by: $('#by').val(),
    order: $('#order').val()
  }

  ajax.request.html(data, $('#projects'), url);
}
