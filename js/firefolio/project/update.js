$('document').ready(function () {
  var update = {
    form: $('#form'),
    submit: function (project) {

    }
  };

  update.form.submit(function (event) {
    event.preventDefault();

    var project = update.form.serialize();

    console.log(project);
  });
});
