$('document').ready(function () {
  var update = {
    url: $('#base-url').val() + 'index.php/firefolio/profile/update',
    form: $('#form'),
    attempt: function () {
      var data = update.form.serialize();
      var request = $.post(
        update.url,
        data,
        'JSON'
      );

      console.log(data);

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        $('#csrf').val(response.hash);

        if (response.success) {

        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.log(message);
      });
    }
  };

  update.form.submit(function (event) {
    event.preventDefault();

    update.attempt();
  });
});
