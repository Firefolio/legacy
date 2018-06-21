#########################
Installation Instructions
#########################

Manual
------

Installing Firefolio on your server manually is fairly simple:

#. Unzip the program to a temporary location on your computer
#. Open the *application/config/config.php* file with a text editor and change
   the value of the ``$config['base_url']`` variable to that of your website,
   such as *www.example.com*
#. Configure the database by opening the *application/config/database.php*
   file, and filling it with the appropriate information
#. Upload the *Firefolio-x.x.x* folder to your server
#. Configure your server's web root such that it points to the *public* folder
#. Navigate to *your.base.url/install.php* using your web browser

Note that you can't install Firefolio if there are tables in the database
already, or if you've already got a version of Firefolio installed on your
server.

Automatic
---------

Automatic installation via a script is planned, but not currently supported.

.. toctree::
  :hidden:
  :titlesonly:

  self
