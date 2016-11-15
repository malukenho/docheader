#!/usr/bin/env bash
set -x
if [ "$TRAVIS_PHP_VERSION" = '5.6' ] ; then
    ./vendor/bin/phpunit --disallow-test-output --report-useless-tests --coverage-clover ./clover.xml
    wget https://scrutinizer-ci.com/ocular.phar
    php ocular.phar code-coverage:upload --format=php-clover ./clover.xml
fi
