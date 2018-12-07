mequil
======

You need to add "wunderground_api_key" and it's value to the parameters.yml file before everything will work as intended. 

generate tables & columns: php bin/console doctrine:schema:update --force
get weather data: php bin/console weather:get
