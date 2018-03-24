$('document').ready(function () {
  $('#datepicker').datepicker({
    showOn: 'focus',
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd' // Format text in a way that MySQL can understand
 });
});
