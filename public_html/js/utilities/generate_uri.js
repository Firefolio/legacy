// The following script is based on the
// 'Perfect Clean URL Generator'
// by Matteo Spinelli
// Source: http://cubiq.org/the-perfect-php-clean-url-generator

function generate_uri(input) {
  var output = input;
  var delimeter = '-';

  output = output.replace(/[^a-zA-Z0-9\/_|+ -]/g, '');
  output = output.toLowerCase();
  output = output.replace(/[\/_|+ -]+/g, delimeter);

  return output;
}
