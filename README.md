# Suggested Products for Magento

Magento has an internal URL Rewrite Management system. It can be a laborious task to add all your redirects, one by one.  The Optimise Web Redirects extension allows you to upload all your redirect data as a CSV file.king for their websites. This extension can send checkout successes and revenues as dynamic goals to GetClicky.  This extension comes with a complete configuration screen where all options can be configured.

Magento developers! Are you tired of editing layout xml files to add CSS stylesheets and JS scripts? The EasyCssJsLoader Magento extension lets you add page specific (sitewide, home page, category pages, product pages, CMS pages) CSS and JS files easily, via the Admin interface.

[![Donate](https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YNKF9CGE3V5HJ)

## 1. Installation

1. Get the Magento Connect extension key and install it through Magento Connect (recommended)
2. Download the app folder from GitHub and upload it to your Magento root folder

### PLEASE NOTE

* **Backup Magento's files and database.** It is best practice to backup the database and files, just in case something goes wrong and you need to rollback. Always try the module on a development site and deploy to a live site only after you have fully tested it.

* **Disable Compilation.** Magento's compilation feature is wonderful! However, it needs to be switched off before installing new modules. If you forget to do so, use the command line to recompile. http://www.kathirvel.com/magento-compile-clear-enable-and-disable-compilation-via-ssh/

* **Getting a 404 error.** As with the installation of all Magento modules, please clear the cache folders before and after module installation. Log out of the Admin area and log back in. Please also flush your CSS and JS caches.

This module has been tested and big fixed to the best possible extent. Let us know if you come across any problems or issues and we will endeavour to fix it in an upcoming release.

## 2. Configuration and Usage

The settings for this module can be accesses through the Admin menu - **Optimise Web >> Easy CSS and JS Loader** or through **System >> Configuration >> Optimise Web >> Easy CSS and JS Loader**.

You can load the files either from the 'js' directory in the Magento root folder or from your template's 'skin' folder.

* CSS stylesheets from the 'js' folder are loaded at the top
* CSS stylesheets from the 'skin css' folder are loaded at the bottom, just before print.css
* JS scripts from the 'js' folder are loaded at the bottom of the core Magento scripts
* JS scripts from the 'skin js' folder are loaded at the extreme bottom, just after the JS scripts from the 'js' folder

