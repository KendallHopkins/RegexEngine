#!/bin/bash
cd "`dirname "$0"`"

{
	cat vendor/fancyBox/source/jquery.fancybox.css;
	cat vendor/jQuery-contextMenu/src/jquery.contextMenu.css;
	lessc main.less;
} | sed 's/\/\*\!/\/\*/g' | cleancss -o ./build.css

{
	cat vendor/jsPlumb/build/1.3.9/js/jquery.jsPlumb-1.3.9-all-min.js;
	cat vendor/fancyBox/source/jquery.fancybox.js;
	cat vendor/jQuery-contextMenu/src/jquery.contextMenu.js;
	coffee -p -c ./main.coffee;
} | uglifyjs -o ./build.js