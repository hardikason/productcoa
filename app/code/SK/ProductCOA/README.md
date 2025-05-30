# Product's Certification of Authentication Module

This module allows Magento 2 store administrators to upload, manage, and associate Certificate of Authenticity (COA) documents with individual products. The COA is then available to customers orders at the frontend.

# Features

    - Adds new product attribute or field for uploading COA
    - Allows uploading image as proof of authenticity from product add/edit
    - Backend UI integration for COA image upload and display 
    - ViewModel used for frontend data binding
    - Uses Magento UI components and admin system configuration

# Installation Steps

1. Download and place the zip folder in app/code/
2. Run the following commands:

   ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:s:d -f
    php bin/magento cache:flush

3. Confirm the module is enabled:

    ```bash
    php bin/magento module:status SK_ProductCOA

# Admin Configuration

Located in etc/adminhtml/system.xml, the module adds a section under

Stores > Settings > Configuration > Catalog Tab > Catalog > Product Certificate Of Authentication

Config added for below : 

    a. Enabling/Disabling Module - This will allow admin to disable module if not required
    b. Product's COA images upload folder (Folder will available in pub/media) - Admin can choose/change folder to save files, if in case folder gets heavily loaded.

# Code Quality Checks

    ```bash
    vendor/bin/phpcs --standard=vendor/magento/magento-coding-standard/Magento2 app/code/SK/ProductCOA/ --extensions=php --warning-severity=max
    vendor/bin/phpmd app/code/SK/ProductCOA/ ansi dev/tests/static/testsuite/Magento/Test/Php/_files/phpmd/ruleset.xml 
    vendor/bin/phpstan analyse app/code/SK/ProductCOA --level=max --memory-limit=1G

# Screenshots

Admin Configuration

![Admin Configuration](<.Screenshots/ProductCOA Admin Configuration.png>)

Attribute Display At Admin

![Product Attribute Display At Admin](<.Screenshots/ProductCOA Product Attribute Display At Admin.png>)

My Orders Page

![My Orders Page](<.Screenshots/ProductCOA My Orders Page.png>) 

Order Details Page

![Order Details Page](<.Screenshots/ProductCOA Order Details Page.png>) 

Authentication Display Page

![Authentication Display Page](<.Screenshots/ProductCOA Authentication Display Page.png>) 

Authentication Image Display

![Authentication Image Display](<.Screenshots/ProductCOA Authentication Image Display.png>)