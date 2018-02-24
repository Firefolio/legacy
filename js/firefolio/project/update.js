$('document').ready(function () {
  var update = {
    form: $('#form'),
    url: $('#base-url').val(),
    submit: function () {
      var inputs = this.form.find('input, textarea, button');
      var data = this.form.serialize();

      console.log(data);
      inputs.prop('disabled', true);

      var request = $.post(
        update.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          window.location.replace(
            'http://localhost/firefolio/index.php/firefolio/projects'
          );
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      })

      request.always(function () {
        inputs.prop('disabled', false);
      });
    }
  };

  update.form.submit(function (event) {
    event.preventDefault();

    var project = update.form.serialize();

    update.submit();
  });
});
