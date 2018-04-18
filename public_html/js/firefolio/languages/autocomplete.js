$('document').ready(function () {
  var url = $('#base-url').val() + 'json/languages.json';
  $.getJSON(url, function (data) {
    // Autocomplete the languages field based on the values in languages
    $('#autocomplete').autocomplete({
      source: data
    });
  });
});
