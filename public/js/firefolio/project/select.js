// TODO: Make projects more easily selectable
projects.get_selected = function () {
  var projects = [];
  var checkboxes = $('input[name=toggle]');
  var uris = $('input[name=uri]');

  for (var checkbox = 0; checkbox < checkboxes.length; checkbox++) {
    if (checkboxes[checkbox].checked) {
      projects.push(uris[checkbox].value);
    }
  }

  return projects;
}
