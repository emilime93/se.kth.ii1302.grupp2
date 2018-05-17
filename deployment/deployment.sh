#!/bin/bash

#If it's the first time
if [ ! -d ~/se.kth.ii1302.grupp2 ]; then
    echo "Creating folder"
    mkdir -p ~/se.kth.ii1302.grupp2
    cd ~/se.kth.ii1302.grupp2
    git clone https://github.com/emilime93/se.kth.ii1302.grupp2.git .
    git pull origin master
    echo "Creating folder"
else #If there's just an update
    echo "---> Updating git repo"
    cd ~/se.kth.ii1302.grupp2
    git checkout master
    git pull origin master
    echo "Replacing old site with new"
    sudo rm -r /var/www/html/*
    sudo cp -r website/* /var/www/html
    echo "Done"
fi
