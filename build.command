#!/bin/bash
cd "`dirname "$0"`"
coffee -c ./main.coffee
lessc main.less main.css