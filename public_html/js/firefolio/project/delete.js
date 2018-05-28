$('document').ready(function () {
  // Bring up a modal when the delete button is clicked
  $('#delete').click(function (event) {
    // Only if there have been some projects selected
    if (projects.get_selected().length > 0) {
      $('#delete-modal').dialog({
        modal: true,
        show: {
          effect: 'bounce'
        },
        buttons: {
          'Confirm': function () {
            projects.delete(projects.get_selected());
            $(this).dialog('close');
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

projects.delete = function (projects) {
  var url = $('#base-url').val() + $('#index-page').val() + '/backend/projects/delete';
  var data = {
    'projects': projects
  }

  console.log(url);

  ajax.request.data(data, url, function () {
    // Hide inputs of deleted projects
    for (var project = 0; project < projects.length; project++) {
      $(
        'input[value=' +
        projects[project] +
        ']'
      ).parents().hide();
    }
  });
}
