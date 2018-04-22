var csrf = {
  name: $('#csrf').attr('name'),
  hash: $('#csrf').val()
};
var ajax = {
  request: {
    form: function (form, url, method, redirect) {
      var inputs = form.find('input, textarea, button');
      var data = form.serialize();

      console.log(data);

      var request = $.ajax({
        url: url,
        data: data,
        method: method,
        type: "JSON"
      });

      inputs.prop('disabled', false);

      request.done(function (response) {
        // Parse and debug server response
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        // Update the anti-CSRF hash
        csrf.hash = response.hash;
        $('#csrf').val(response.hash);

        // Optionally redirect if the request succeeded
        if (response.success) {
          console.log(response.message);

          // Only redirect if a redirect URL was specified
          if (redirect != null) {
            window.location.replace(redirect);
          }
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
    },
    html: function (input, output, url) {
      var data = {
        input: input
      }
      input[$('#csrf')].attr('name') = $('#csrf').val();

      // Type is assumed to be POST
      var request = $.ajax({
        url: url,
        data: data,
        method: 'POST',
        type: 'JSON'
      });

      request.done(function (response) {
        response = JSON.parse(response);

        $('#csrf').val(response.hash);

        if (response.success) {
          output.html(response.html);
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      });
    }
  }
};
