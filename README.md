#Not ready yet!!!

Still under development. Check back later.<br />
Light-weight, modular PHP / MySQL framework.

##Features
* Ready-to-use database installer
  * One-click to install a pre-made database table
  * Select optional columns as well
* Modular design
  * Most modules can be used on their own, even without the framework
  * Almost no messy dependencies that often break when upgrading
* Pure PHP
  * No learning curve. If you know PHP, you know this framework
  * Uses PDO for database interaction
  * Uses PHP tags <? ... ?> for templates
* Super light-weight core
  * Only 6 files in the core (4 of which are optional)
  * Completly modular functionality
* One-line module execution
  * Most class methods are declared static so you don't have to instantiate them
  * Use of PHP's autoload functionality so you don't even have to include the file
  * e.g. <?php echo UserRegistration::form($pdo); ?>


##How to Use
###Folder Structure
* core - These are the bare bones files required
* modules - These are the classes that provide additional functionality
* db - These files serve installation requests in your admin panel. You don't need to download anything in this folder.

##Namespace
This framework provides more of a common namespace than anything. The database tables and columns are used in the "db" folder. They can be easily installed in the install page.
