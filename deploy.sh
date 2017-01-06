#!/bin/bash
targetDir=`pwd`
cd $targetDir

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
    composer -vvv update
    cp composer.json ../
    cd ..
else
   echo "diff composer.json  src/composer.json ..."
   rs=`diff composer.json  src/composer.json`
   echo "rs=$rs"
   if [ "$rs" ];then
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