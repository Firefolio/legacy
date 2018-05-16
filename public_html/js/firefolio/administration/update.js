$('document').ready(function () {
  $('#update-username').submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#update-username'),
      $('#update-username').attr('action'),
      $('#update-username').attr('method')
    );
  });
});
