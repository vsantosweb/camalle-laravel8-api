#!/bin/bash

COMMANDS=("queue:work route:clear")
PWD="/var/www/workstation/project-disc-laravel8-server"

for command in $COMMANDS; do 
   PROCESS_COUNT=$(ps -ef | grep -i $command | wc -l)
      if [[ $PROCESS_COUNT -gt 1 ]]
       then
          echo $command "job already running, nothing to do"  2> /dev/null 2>&1
      else
         $(php $PWD/artisan $command) 2> /dev/null 2>&1
      fi
done
