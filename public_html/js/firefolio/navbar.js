$('document').ready(function () {
  $('#open-navbar').click(function (event) {
    event.preventDefault();

    $('#navbar').toggleClass('active');
  })
});
