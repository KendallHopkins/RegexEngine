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
		<script type='text/javascript' defer="defer" src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
		<script type='text/javascript' defer="defer" src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>
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
					<ul class="nav">
						<li class="active"><a class="tab_link" data-tab="main" href="javascript:void(0);">Home</a></li>
						<li><a class="tab_link" data-tab="help" href="javascript:void(0);">Help</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="google_ads_container">
			<div>
				<script type="text/javascript"><!--
					google_ad_client = "ca-pub-0523377891461555";
					/* RegexEngine */
					google_ad_slot = "4315264425";
					google_ad_width = 120;
					google_ad_height = 600;
					//-->
				</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
			</div>
		</div>
		<div id="tab_container">
			<div id="tab_main">
				<? require( "main.html" ); ?>
			</div>
			<div id="tab_help" style="display: none;">
				<? require( "help.html" ); ?>
			</div>
		</div>
	</body>
</html>
