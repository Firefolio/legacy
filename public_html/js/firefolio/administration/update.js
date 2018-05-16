$('document').ready(function () {
  // Update each of the forms when they are submitted
  $('#update-username').submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#update-username'),
      $('#update-username').attr('action'),
      $('#update-username').attr('method')
    );
  });

  $('#update-password').submit(function (event) {
    event.preventDefault();

    ajax.request.form(
      $('#update-password'),
      $('#update-password').attr('action'),
      $('#update-password').attr('method')
    );
  });
});
