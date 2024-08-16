#!/bin/bash
ENTITY=$1
echo "Processing entity: $ENTITY"

./vendor/bin/sail artisan make:model -m -f ${ENTITY}
./vendor/bin/sail artisan make:controller Api/${ENTITY}Controller --resource --api
./vendor/bin/sail artisan make:request ${ENTITY}Request
./vendor/bin/sail artisan make:resource ${ENTITY}Resource
./vendor/bin/sail artisan make:seeder ${ENTITY}/InitDev${ENTITY}Seeder
./vendor/bin/sail artisan make:test Api${ENTITY}Test


