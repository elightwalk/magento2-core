# Elightwalk core For Magento 2
Elightwalk Core Extension.

# Descriptions 

Elightwalk_Core extension provides the basic requirements for other elightwalk modules.

# How to Install Elightwalk Core
### Installation via Composer

Go to Magento root and then below **commands**

```
 composer require elightwalk/magento2-core
 php bin/magento module:enable Elightwalk_Core
 php bin/magento setup:upgrade
 php bin/magento setup:di:compile
 php bin/magento c:f
 php bin/magento c:c

```

# Supporting Versions :

```
 2.4.6, 2.4.5
```

# Change Log :

## 1.0.4

    => Add "Secret Key" in system configuration

## 1.0.3

    => Remove restoreQuote functionality from graphql and rest api, create new separate module
    => Created new file Config.php instead of Data.php

## 1.0.2

    => Add a "Configuration" menu to maintain the configuration of other module. 

## 1.0.1

    => Restore quote api and graphql implement.
