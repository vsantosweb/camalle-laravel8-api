#!/bin/bash

COMMANDS=("queue:work websockets:serve")
PWD="/var/www/disc/camalle/backend"

for command in $COMMANDS; do

   PROCESS_COUNT=$(ps -ef | grep -i $command | wc -l)

   if [ $PROCESS_COUNT -gt 1 ]; then
      echo $command "job already running, nothing to do"  >> /dev/null &
   else
      EXEC=$(php $PWD/artisan $command) >> /dev/null &
   fi

done
