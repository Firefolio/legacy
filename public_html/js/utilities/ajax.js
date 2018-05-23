var csrf = {
  name: $('#csrf').attr('name'),
  hash: $('#csrf').val()
};
var ajax = {
  request: {
    form: function (form, url, method, redirect) {
      var inputs = form.find('input, textarea, button');
      var data = form.serialize();

      // Ensure that the current CSRF token is sent on the end of the query
      data += '&' + $('#csrf').attr('name') + '=' + $('#csrf').val();

      console.log(data);

      var request = $.ajax({
        url: url,
        data: data,
        method: method,
        dataType: 'JSON'
      });

      inputs.prop('disabled', false);

      request.done(function (response) {
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
    html: function (input, output, url, append = false) {
      var data = {
        input: input
      }
      // Ensure that the current CSRF token is sent
      data[$('#csrf').attr('name')] = $('#csrf').val();

      // Type is assumed to be POST
      var request = $.ajax({
        url: url,
        data: data,
        method: 'POST',
        dataType: 'JSON'
      });

      request.done(function (response) {
        console.log(response);

        // Always remember to set the new hash after
        // a complete request
        $('#csrf').val(response.hash);

        if (response.success) {
          if (append) {
            if (output.html() != '') {
              output.append(response.html);
            } else {
              output.html(response.html);
            }
          } else {
            $(output).html(response.html);
          }
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      });
    },
    data: function (data, url) {
      data[$('#csrf').attr('name')] = $('#csrf').val();

      // Type is assumed to be POST
      var request = $.ajax({
        url: url,
        data: data,
        method: 'POST',
        dataType: 'JSON'
      });

      request.done(function (response) {
        console.log(response);

        // Always remember to set the new hash after
        // a complete request
        $('#csrf').val(response.hash);

        if (response.success) {
          console.log(response.message);
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
