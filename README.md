# Installation

  1.  Extract the zip file and push to app -> code

  2.  Fire below commands

    -> php bin/magento module:enable Elightwalk_Core

    -> php bin/magento setup:upgrade

    -> php bin/magento setup:di:compile

    -> php bin/magento setup:static-content:deploy

    -> php bin/magento cache:clean
