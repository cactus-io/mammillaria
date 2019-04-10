#!/bin/bash

attempt_counter=0
max_attempts=10
sleep_length=60

rm -rf /var/www/storage/tmp/Pluf*
cd "/var/www/html"
apache2-foreground
