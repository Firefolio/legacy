$('document').ready(function () {
  var search = {
    bar: $('#search'),
    url: $('#base-url').val()
    attempt: function () {
      var request = $.post(
        
      );
    }
  };

  if (search.bar != null) {
    search.bar.on('input', function () {
      search.attempt();
    });
  }
});
