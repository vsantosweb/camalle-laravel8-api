#!/bin/bash


PROC_NAME="queue:work"
QUIZ_QUEUE_PROCESS_COUNT=$(ps -ef | grep -i $PROC_NAME | wc -l)
RUN_CMD="php /var/www/workstation/project-disc-laravel8-server/artisan schedule:run"

if [[ $QUIZ_QUEUE_PROCESS_COUNT -gt 1 ]]
then
   echo "PHP job already running, nothing to do"
else
   $($RUN_CMD) 2> /dev/null 2>&1
fi