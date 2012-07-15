<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Regex Engine</title>
		<link rel="stylesheet" href="//current.bootstrapcdn.com/bootstrap-v204/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="vendor/fancyBox/source/jquery.fancybox.css"/>
<? if( array_key_exists( "debug", $_GET ) ) { ?>
		<link rel="stylesheet/less" href="main.less">
<? } else { ?>
		<link rel="stylesheet" href="main.css"/>
<? } ?>
		<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js'></script>
		<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js'></script>
		<script type='text/javascript' src='//current.bootstrapcdn.com/bootstrap-v204/js/bootstrap.min.js'></script>
		<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.js"></script>
		<script type='text/javascript' src='vendor/jsPlumb/build/1.3.9/js/jquery.jsPlumb-1.3.9-all-min.js'></script>
		<script type='text/javascript' src='vendor/fancyBox/source/jquery.fancybox.js'></script>
<? if( array_key_exists( "debug", $_GET ) ) { ?>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>
		<script type="text/coffeescript" src="main.coffee"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/coffee-script/1.3.1/coffee-script.min.js"></script>
<? } else { ?>
		<script type='text/javascript' src='main.js'></script>
<? } ?>
	</head>
	<body onunload="jsPlumb.unload();">	
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">Regex Engine</a>
				</div>
			</div>
		</div>
		<div id="toolbar_container">
			<div id="toolbar" class="btn-toolbar">
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">Source <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="javascript:void(0);" onclick="new Node.TextSource;">Basic</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">Operation <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="javascript:void(0);" onclick="new Node.Union;">Union</a></li>
						<li><a href="javascript:void(0);" onclick="new Node.Intersection;">Intersection</a></li>
						<li><a href="javascript:void(0);" onclick="new Node.Negation;">Negation</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">Output <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="javascript:void(0);" onclick="new Node.TextOutput;">Text</a></li>
						<li><a href="javascript:void(0);" onclick="new Node.CountOutput;">Count</a></li>
						<li><a href="javascript:void(0);" onclick="new Node.GraphOutput;">Graph</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div style="position:relative;" id="main">
		</div>
		<div class="prototype window well node node_source_text">
			<div class="input-prepend input-append">
				<span class="add-on">^</span><input type="text" /><span class="add-on">$</span><span class="add-on"><i class="icon-ok"></i></span>
			</div>
		</div>
		<div class="prototype window well node node_union">
			<span>⋃</span>
		</div>
		<div class="prototype window well node node_intersection">
			<span>⋂</span>
		</div>
		<div class="prototype window well node node_negation">
			<span>¬</span>
		</div>
		<div class="prototype window well node node_output_text">
			<span class="type_normal" style="display: none;"></span>
			<span class="type_empty" style="display: none;">∅</span>
			<span class="type_no_input">No Input</span>
		</div>
		<div class="prototype window well node node_output_count">
			<span class="type_normal" style="display: none;">0</span>
			<span class="type_infinity" style="display: none;">∞</span>
			<span class="type_error">Error</span>
		</div>
		<div class="prototype window well node node_output_graph">
			<div class="type_normal" style="display: none;"><a href="" title=""><img src="" alt=""/></a></div>
			<div class="type_no_input"><span>No Input</span></div>
			<div class="type_error" style="display: none;"><span>Error	</span></div>
		</div>
	</body>
</html>
