$('document').ready(function () {
  var create = {
    form: $('#create'),
    url: $('#base-url').val() +
         'index.php/firefolio/projects/create/submit',
    attempt: function () {
      var inputs = create.form.find('input, textarea, button');
      var data = create.form.serialize();

      inputs.prop('disabled', true);

      var request = $.post(
        create.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        $('#csrf').val(response.hash);

        if (response.success) {
          console.log(response.message);

          window.location.replace(
            $('#base-url').val() +
            'index.php/firefolio/projects'
          );
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      });

      request.always(function () {
        inputs.prop('disabled', false);
      });
    }
  };

  if (create.form != null) {
    create.form.submit(function (event) {
      event.preventDefault();

      create.attempt();
    });
  }
});
