#!/bin/sh
for f in `find . -name '*.php'`; do php -l $f | grep Errors; done
