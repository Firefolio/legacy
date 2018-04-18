$('document').ready(function () {
  var url = $('#base-url').val() +
            'json/languages.json';

  var languages = ajax.request.json(
    $('#base-url').val() +
    'json/languages.json'
  );

  console.log('languages:', languages);

  // Autocomplete the languages field based on the values in languages
  $('#autocomplete').autocomplete({
    source: languages
  });
});
