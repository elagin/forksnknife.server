#!/bin/bash
rsync -e "ssh -p 25722" -vu *.* alpha.stormway:/var/www/html/forksnknife/
rsync -e "ssh -p 25722" -vu class/*.* alpha.stormway:/var/www/html/forksnknife/class/
