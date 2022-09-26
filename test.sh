#!/bin/sh

artisan="php artisan"
$artisan down
$artisan cache:clear

$artisan config:clear
$artisan config:cache

$artisan event:clear
$artisan event:cache

$artisan route:clear

$artisan view:clear

$artisan up

apache2-foreground