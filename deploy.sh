#!/bin/bash
cd /home/www-data/openadm.com
targetDir=`pwd`

if [ ! -d "$targetDir/git-src" ];then
    mkdir "$targetDir/git-src"
fi
if [ ! -d "$targetDir/src" ];then
    mkdir "$targetDir/src"
fi

tar -xzf ./deploy/package.tgz  -C ./git-src

mv ./git-src/open* ./git-src/src

cp -r ./git-src/src/* ./src/

rm -rf ./git-src/src

cd src

php init --env=Production  --overwrite=y

cd ../

if [ ! -f "./composer.json" ];then

    cd src
    #认为是第一次执行部署
    composer global require "fxp/composer-asset-plugin:^1.2.0"
    composer -vvv update
    #执行数据导入操作
    ./yii migrate/up --interactive=0
    cp composer.json ../
    cd ..
else
   echo "diff composer.json  src/composer.json ..."
   rs=`diff composer.json  src/composer.json`
   if [ "$rs" ];then
       #认为composer.json有变动需要 update
       echo "must composer update"
       cd src
       composer -vvv update
       cp composer.json ../
       cd ..
   else
       echo "not need to composer"
   fi
fi

echo "deploy completely!!! "