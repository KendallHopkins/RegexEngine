<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Regex Engine</title>
		<link rel="stylesheet" href="//current.bootstrapcdn.com/bootstrap-v204/css/bootstrap.min.css"/>
<? if( array_key_exists( "debug", $_GET ) ) { ?>
		<link rel="stylesheet" href="vendor/fancyBox/source/jquery.fancybox.css"/>
		<link rel="stylesheet" href="vendor/jQuery-contextMenu/src/jquery.contextMenu.css"/>
		<link rel="stylesheet/less" href="main.less">
<? } else { ?>
		<link rel="stylesheet" href="build.css?_t=<? print filemtime( __DIR__."/build.css" ) ?>"/>
<? } ?>
		<script type='text/javascript' defer="defer" src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js'></script>
		<script type='text/javascript' defer="defer" src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js'></script>
		<script type='text/javascript' defer="defer" src='//current.bootstrapcdn.com/bootstrap-v204/js/bootstrap.min.js'></script>
<? if( array_key_exists( "debug", $_GET ) ) { ?>
		<script type='text/javascript' defer="defer" src='vendor/jsPlumb/build/1.3.9/js/jquery.jsPlumb-1.3.9-all-min.js'></script>
		<script type='text/javascript' defer="defer" src='vendor/fancyBox/source/jquery.fancybox.js'></script>
		<script type='text/javascript' defer="defer" src='vendor/jQuery-contextMenu/src/jquery.contextMenu.js'></script>
		<script type="text/javascript" defer="defer" src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>
		<script type="text/coffeescript" src="main.coffee"></script>
		<script type="text/javascript" defer="defer" src="//cdnjs.cloudflare.com/ajax/libs/coffee-script/1.3.1/coffee-script.min.js"></script>
<? } else { ?>
		<script type='text/javascript' defer="defer" src='build.js?_t=<? print filemtime( __DIR__."/build.js" ) ?>'></script>
<? } ?>
	</head>
	<body onunload="jsPlumb.unload();">
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="javascript:void(0);">Regex Engine</a>
				</div>
			</div>
		</div>
		<div id="tab_main" style="display: none;">
			<? require( "main.html" ); ?>
		</div>
		<div id="tab_help">
			<? require( "help.html" ); ?>
		</div>
	</body>
</html>
