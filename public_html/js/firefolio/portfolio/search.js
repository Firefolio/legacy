$('document').ready(function () {
  $('#search').on('input', debounce(search, 128));
  $('#like').on('input', debounce(search, 128));
  $('#by').on('input', debounce(search, 128));
  $('#order').on('input', debounce(search, 128));

  // Clear inputs if they were previously changed
  $('#search').val('');
  $('#like').val('title');
});

function search() {
  var url = $('#base-url').val() + $('#index-page').val() + '/search';
  var data = {
    search: $('#search').val(),
    like: $('#like').val(),
    by: $('#by').val(),
    order: $('#order').val()
  }

  console.log('URL', url);
  console.log('Data:', data);

  ajax.request.html(data, $('#projects'), url);
}
