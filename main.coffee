$ ->
	#document.onselectstart = -> false
	
	jsPlumb.setRenderMode jsPlumb.SVG
	jsPlumb.importDefaults
		DragOptions:
			cursor: "pointer"
			#zIndex: 2000
		#ConnectionOverlays: [ [ "Arrow", { location: 0.9 } ] ]

	connectorPaintStyle =
		lineWidth: 5
		strokeStyle: "#ddd"
		joinstyle: "round"
		outlineColor: "white"
		outlineWidth: 7

	hoverPaintStyle =
		lineWidth: 7
		strokeStyle: "#2e2aF8"
	
	connectorHoverStyle =
		lineWidth: 7
		strokeStyle: "#DC4748"

	sourceEndpoint =
		endpoint: "Dot"
		paintStyle:
			fillStyle: "#006DC7"
			radius: 11
		isSource: true
		maxConnections: -1
		connector: [ "Flowchart", { stub: 40, gap: 10 } ]
		connectorStyle: connectorPaintStyle
		connectorHoverStyle: connectorHoverStyle
		dragOptions: {}
	
	targetEndpoint =
		endpoint: "Dot"
		paintStyle:
			fillStyle: "#56B162"
			radius: 11
		maxConnections: 1
		dropOptions:
			hoverClass: "hover"
			activeClass: "active"
		isTarget: true
	
	recalculate = ->
		connections = for connection in jsPlumb.getConnections()
			[source_endpoint, target_endpoint] =  connection.endpoints
			source_object = source_endpoint.getElement().data("object")
			target_object = target_endpoint.getElement().data("object")
			{
				"from": source_object.getOffset()
				"from_offset": source_object.outputs().indexOf source_endpoint
				"to": target_object.getOffset()
				"to_offset": target_object.inputs().indexOf target_endpoint
			}
		nodes = Node.list();
		node_states = (node.getState() for node in nodes)
		
		jQuery.ajax
			type: "POST"
			url: "backend.php"
			data:
				connections: connections
				nodes: node_states
			success: (data) ->
				throw data.message if not data.success
				throw "not even node was passed back a state" if data.node_states.length isnt nodes.length
				for i in [0...nodes.length]
					nodes[i].setState data.node_states[i]
	#init = (connection) ->
	#	console.log connection
	
	jsPlumb.bind "click", (conn, originalEvent) ->
		jsPlumb.detach conn
	
	jsPlumb.bind "jsPlumbConnection", recalculate
	jsPlumb.bind "jsPlumbConnectionDetached", recalculate
	
	$.contextMenu
		selector: ".node"
		animation:
			show: "show"
			hide: "hide"
		items:
			delete:
				name: "Delete"
				callback: (key, opt) -> opt.$trigger.data("object").delete()
	
	class Node
		list = []
		@list = -> item for item in list when item instanceof @
		
		constructor: (input_count, output_count) ->
			list.push @
			throw "Node is an abstract class" if @constructor == Node
			@element = @getPrototype().clone()
			@element.data "object", @
			jsPlumb.draggable @element
			$("#main").append @element
			@element.removeClass "prototype"
			
			inputs = for i in [0...input_count]
				jsPlumb.addEndpoint @element, targetEndpoint, { anchor: [ 0, (i+1)*(1/(input_count+1)), -1, 0 ] }
			@inputs = -> $.extend [], inputs
			
			outputs = for i in [0...output_count]
				jsPlumb.addEndpoint @element, sourceEndpoint, { anchor: [ 1, (i+1)*(1/(output_count+1)), 1, 0 ] }
			@outputs = -> $.extend [], outputs
		
		getPrototype: ->
			throw "Class function must be defined" unless @class?
			$ ".prototype.#{@class()}"
		
		getOffset: ->
			Node.list().indexOf @
		
		getState: ->
			class: @class()
		
		setState: (data) ->
		
		delete: ->
			jsPlumb.removeAllEndpoints @element
			@element.remove()
	
	window.Node = Node
	
	class Node.TextSource extends Node
		constructor: (source_text) ->
			super 0, 1
			@element.find("input[type=text]").bind 'keyup change', recalculate
		class: -> "node_source_text"
		getState: ->
			data = super()
			data.text = "^" + @element.find("input[type=text]").val() + "$"
			data
		setState: (data) ->
			super data
			throw "missing is_valid" unless data.is_valid?
			@element.find(".input-append span.add-on i").removeClass( "icon-ok icon-remove" ).addClass( if data.is_valid then "icon-ok" else "icon-remove" )
	
	class Node.Union extends Node
		constructor: -> super 2, 1
		class: -> "node_union"
	
	class Node.Intersection extends Node
		constructor: -> super 2, 1
		class: -> "node_intersection"
	
	class Node.Negation extends Node
		constructor: -> super 1, 1
		class: -> "node_negation"
	
	class Node.TextOutput extends Node
		constructor: -> super 1, 0
		class: -> "node_output_text"
		setState: (data) ->
			super data
			@element.find("span").hide()
			if data.text is null
				@element.find("span.type_no_input").show()
			else if data.text is 0
				@element.find("span.type_empty").show()
			else
				@element.find("span.type_normal").show().text data.text
	
	class Node.CountOutput extends Node
		constructor: -> super 1, 0
		class: -> "node_output_count"
		setState: (data) ->
			super data
			@element.find("span").hide()
			if data.count is null
				@element.find("span.type_no_input").show()
			else if data.count is -1
				@element.find("span.type_infinity").show()
			else
				@element.find("span.type_normal").show().text data.count
				
	
	class Node.GraphOutput extends Node
		constructor: ->
			super 1, 0
			@element.find("a").fancybox
				helpers:
					title:
						type: "float"
		class: -> "node_output_graph"
		setState: (data) ->
			super data
			dot_data = data.text
			
			@element.find( "> div" ).hide()
			if not dot_data?
				@element.find(".type_no_input").show()
				return
			
			dot_data = dot_data.replace( /\n/g, "" )
			
			max_url_length = 2048
			google_url_small = "//chart.googleapis.com/chart?" + jQuery.param
				cht: "gv"
				chl: dot_data
				chs: "300x200"
			google_url_large = "//chart.googleapis.com/chart?" + jQuery.param
				cht: "gv"
				chl: dot_data
				_: ".png" #hack to make fancybox work
			
			if google_url_small.length > max_url_length or google_url_large.length > max_url_length
				@element.find(".type_error").show()
				return
			
			@element.find(".type_normal").show()
			@element.find(".type_normal a").attr "href", google_url_large
			@element.find(".type_normal img").attr "src", google_url_small
	