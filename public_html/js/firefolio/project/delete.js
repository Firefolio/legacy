$('document').ready(function () {
  // Can't use 'delete' as that's a reserved keyword in Javascript
  var del = {
    url: 'projects/delete',
    attempt: function (checkboxes, uris) {
      var projects_to_delete = [];

      for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
        if (checkboxes[checkbox].checked) {
          projects_to_delete.push(uris[checkbox].value);
        }
      }

      var data = {
        'projects': JSON.stringify(projects_to_delete)
      };
      data[$('#csrf').attr('name')] = $('#csrf').val();

      console.log(data);

      request = $.post(
        del.url,
        data,
        'JSON'
      );

      request.done(function (response) {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);

        // Get a new anti-CSRF hash from the response
        $('#csrf').val(response.hash);

        if (response.success) {
          // Hide deleted inputs
          for (var project = 0; project < projects_to_delete.length; project++) {
            $('input[value=' +
              projects_to_delete[project] +
              ']').parent().hide();
          }
        } else {
          console.error(response.message);
        }
      });

      request.fail(function (message) {
        console.error(message);
      });
    }
  };

  $('#delete').click(function (event) {
    var checkboxes = $('input[name=toggle]');
    var uris = $('input[name=uri]');

    if (checkboxes.length > 0) {
      $('#delete-modal').dialog({
        modal: true,
        show: {
          effect: 'bounce'
        },
        buttons: {
          'Confirm': function () {
            del.attempt(checkboxes, uris);
          },
          'Cancel': function () {
            $(this).dialog('close');
          }
        }
      });
    } else {
      // Tell the user to select something first
    }
  });
});
