$('document').ready(function () {
  $('#search').on('input', debounce(search, 128));

  // Clear inputs if they were previously changed
  $('#search').val('');
});

function search() {
  var url = $('#base-url').val() + $('#index-page').val() + '/search';
  var data = {
    query: $('#search').val()
  }

  console.log('URL', url);
  console.log('Data:', data);

  ajax.request.data(url, data, function () {
    console.log('moo');
  });
}
