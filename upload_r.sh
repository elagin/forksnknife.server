#!/bin/bash
rsync -e "ssh -p 25722" -vu *.* alpha.stormway:/var/www/html/forksnknife/
