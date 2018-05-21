$('document').ready(function () {
  // Trigger a modal when the user tries to navigate away from the page
  $('.modal-trigger').click(function (event) {
    event.preventDefault();

    var trigger = $(this);

    $('#modal').dialog({
      modal: true,
      buttons: {
        'Confirm': function () {
          window.location = trigger.attr('href');
        },
        'Cancel': function () {
          $(this).dialog('close');
        }
      }
    });
  });
});
