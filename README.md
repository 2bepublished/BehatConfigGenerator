BehatConfigGenerator
===============================
- Brought to you by [2bePUBLISHED]
- Developed by [Christoph Rosse](http://gries.tv)

[![Build Status](https://secure.travis-ci.org/2bepublished/BehatConfigGenerator.png)](http://travis-ci.org/2bepublished/BehatConfigGenerator)

About
-----
A command-line tool that lets you generate `behat.yml` configs.
It's main purpose is to ease the use of browserstack in combination with multiple devices.
BehatConfigGenerator lets you define which features should be executed on which devices when running the tests. 

Installation
------------

BehatConfigGenerator can be installed via composer

    composer require "2bepublished/behat-config-generator"
    
Examples
--------
Please have a look at the [examples section.](examples/) to see a config + the output that is generated.

Usage
-----

**Step 1: Create your devices list as `.csv`**

The csv uses the following fields:

* device_name 
* mink_session_name
* browserstack_device
* browserstack_user
* browserstack_password
* browserstack_os
* browserstack_browser
* browserstack_version
* browserstack_os_version
```csv
"iphone","iphone_5_ios7","iPhone 5S","my-username","my-password","ios","iPhone","","7"
"firefox","firefox_35_win","ANY","my-username","my-password","WINDOWS","firefox","35",""
```

**Step 2: Create your feature / device mappings per module.**
If you have a behat setup with feature-files like this:
```
features/
    order/*.features
    cart/*.features
```
You have to create a: `order.features.csv` and a `cart.features.csv`

The csv uses the following fields:
feature,device1,device2,device3
```csv
feature,firefox,iphone
search,true,true
show,true,false
```

**Step 3: Generate the `behat.yml` by using the following command:**
```
php vendor/bin/behat-config-generator pub:generate-behat-config ./data/devices.csv ./data/feature_list/ ./output-directory/
```


Customize the templates
-----------------------
To customize the generated behat.yml you can easily change the templates that are used.
Create a folder containing a `device.yml.twig` and a `module.yml.twig` and pass the folder via. a command option like so:
```
php vendor/bin/behat-config-generator pub:generate-behat-config --template-path="/my/templates/" ...
```

Features
--------
- Customize templates
- Generate a big number of Configurations

LICENSE
-------
See `LICENSE` file.
