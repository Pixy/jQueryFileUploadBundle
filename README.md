jQuery File Upload : Symfony Bundle
===

This Bundle is based on the [jQuery File Upload](http://blueimp.github.com/jQuery-File-Upload/ "jQuery File Upload") [(By Blueimp)](https://github.com/blueimp "(By Blueimp)")
---

Installation
---
### Download ###


Download files from the basic jQuery Plugin here : [https://github.com/blueimp/jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload "https://github.com/blueimp/jQuery-File-Upload") :
* **cors/**
* **css/**
* **js/**
* **img/**

And puts the files in your **/web** folder.

Download the **JQueryFileUploadBundle** and put it in your **/src** folder (**the root is /JQuery**, not UploadBundle).

### Installation ###
This Bundle is configured to be used with a Layout. In top of the **Resources/views/index.html.twig**, replace "YourPersonalLayout" by your layout, if you want to.

There are 3 blocks :
* **stylesheets** for css files calls
* **content** for the body 
* **javascripts** for js files calls

Configure this template as you need to, and check the paths of the files called.

Configuration
---
### Translations
You can change locale translations in the file **/web/js/locale.js**, and direclty in the **Resources/views/index.html.twig** of the bundle.

### Options
There are many options the the **JQuery\FileUploadBundle\Classes\UploadHandler.php** file.  

#### Change the upload directory
The default upload directory is **/web**, and **/web/thumbnails** for thumbnails. You can add a subdirectory in the initialization of the UploadHandler like this :

```php
$upload_path = '/my/sub/directory';
$upload_handler = new UploadHandler(null, $this->generateUrl('jquery_fileupload_add'), $upload_path);
```

Check the **JQuery\FileUploadBundle\Classes\UploadHandler.php** for more options.

Handle uploaded imagew with the database
===
Coming soon...


Support 
===
Please create an issue for more informations or questions, or check the [https://github.com/blueimp/jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload "https://github.com/blueimp/jQuery-File-Upload")
