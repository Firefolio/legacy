<?php

?>

<!doctype html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Firefolio Installer</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
  </head>

  <body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser.
      Please <a href="https://browsehappy.com/">upgrade your browser</a>
      to improve your experience and security.</p>
    <![endif]-->

    <!-- Scripts -->
    <!-- JQuery -->
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <div class="container">
      <div id="slideshow">
        <section data-step="1" class="slide">
          <h1>Firefolio Installer</h1>
        </section>
      </div>
      <div>
        <a id="previous">Previous</a>
        <a id="continue">Continue</a>
      </div>
    </div>

    <script type="text/javascript">
      $('document').ready(function () {
        var slides = $('#slideshow').children('.slide');

        $('#continue').click(function (event) {
          event.preventDefault();
        });
      });
    </script>
  </body>
</html>
