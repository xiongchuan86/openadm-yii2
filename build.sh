#!/bin/sh

act=$1


#init
if  [ "$act"x == "init"x ] || [ "$act"x == "all"x ] ; then
echo "###init "

mkdir ~/tmp
ls
git config --global github.accesstoken 33a8c956cbe0a17c6b0de4f848b44d7784817f47
git config --list

echo "###composer version 1 "
composer --version

#china mirror
composer config -g repo.packagist composer https://packagist.phpcomposer.com

sudo composer selfupdate

echo "###composer version 2 "
composer --version


composer global require "fxp/composer-asset-plugin:^1.2.0"
#composer install
composer -vvv install   --prefer-dist --optimize-autoloader

fi

#gen assets
if [ "$act"x == "assets"x ] || [ "$act"x == "all"x ]; then

echo "###gen assets"


#env
php init --env=Production  --overwrite=y

#update apt
sudo apt-get update
sudo apt-get install -y openjdk-7-jre-headless
#gen assets
./yii asset assets.php app/config/assets-prod.php

fi

echo "build completely!!! "
