// If JQuery cannot be found, then write all CDN Javascript libraries
// into the document, along with their dependancies
window.jQuery || document.write(
  // JQuery
  '<script src="' +
    document.getElementById('base-url').value +
    'js/vendor/jquery-3.2.1.min.js"><\/script>',
  // JQuery UI
  // Scripts
  '<script src="' +
    document.getElementById('base-url').value +
    'js/vendor/jquery-ui-1.12.1/jquery-ui.min.js"><\/script>',
  // Stylesheets
  '<link rel="stylesheet" href="' +
    document.getElementById('base-url').value +
    'js/vendor/jquery-ui-1.12.1/jquery-ui.min.css"><\/link>',
  '<link rel="stylesheet" href="' +
    document.getElementById('base-url').value +
    'js/vendor/jquery-ui-1.12.1/jquery-ui.structure.min.css"><\/link>',
  '<link rel="stylesheet" href="' +
    document.getElementById('base-url').value +
    'js/vendor/jquery-ui-1.12.1/jquery-ui.structure.min.css"><\/link>'
);
