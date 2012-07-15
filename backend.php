<?php

header('Content-type: application/json');
ini_set( "memory_limit", "100M" );
ini_set( "display_errors", 0 );
set_time_limit( 5 );

$did_finish_nicely = FALSE;
register_shutdown_function( function() use ( &$did_finish_nicely ) {
	if( ! $did_finish_nicely ) {
		$json_output = json_encode( array(
			"success" => FALSE,
			"message" => "timeout",
		) );
		file_put_contents( dirname( __FILE__ )."/exception.log", $json_output."\n".json_encode( $_POST )."\n", FILE_APPEND );
		print $json_output;
	}
} );

error_reporting( -1 );
set_error_handler( function( $error_flag, $error_string, $error_file, $error_line ) {
		if( ! ( ini_get('error_reporting') & $error_flag ) )
			return TRUE;
		
		throw new ErrorException( $error_string, 0, $error_flag, $error_file, $error_line );
} );
set_exception_handler( function( Exception $e ) use ( &$did_finish_nicely ) {
	$json_output = json_encode( array(
		"success" => FALSE,
		"message" => $e->getMessage(),
		"file" => $e->getFile(),
		"line" => $e->getLine()
	), TRUE );
	print $json_output;
	file_put_contents( dirname( __FILE__ )."/exception.log", $json_output."\n".json_encode( $_POST )."\n", FILE_APPEND );
	$did_finish_nicely = TRUE;
} );

require( dirname( __FILE__ )."/vendor/FormalTheory/lib/FormalTheory/Autoload.php" );
FormalTheory_Autoload::register();
require( dirname( __FILE__ )."/lib.php" );

if( ! is_array( $_POST["nodes"] ) ) {
	throw new Exception( "box key must be array" );
}

$nodes = array_map( function( $node_data ) {
	$class_name = $node_data["class"];
	unset( $node_data["class"] );
	return new $class_name( $node_data );
}, $_POST["nodes"] );

$connections_from_to = array();
if( array_key_exists( "connections", $_POST ) ) {
	foreach( $_POST["connections"] as $connection ) {
		$connections_from_to[$connection["from"]][$connection["from_offset"]][] = array(
			"to" => $connection["to"],
			"to_offset" => $connection["to_offset"],		
		);
	}
}

$inputs = array();
$unprocessed_nodes = $nodes;
do {
	$has_processed_node = FALSE;
	foreach( $unprocessed_nodes as $i => $unprocessed_node ) {
		$ready_input = array_key_exists( $i, $inputs ) ? $inputs[$i] : array();
		$ready_input_count = count( $ready_input );
		if( $unprocessed_node::INPUTS > $ready_input_count ) continue;
		$has_processed_node = TRUE;
		$outputs = call_user_func_array( array( $unprocessed_node, "process" ), $ready_input );			
		foreach( $outputs as $j => $output ) {
			if( isset( $connections_from_to[$i][$j] ) ) {
				foreach( $connections_from_to[$i][$j] as $connection_out ) {
					$inputs[$connection_out["to"]][$connection_out["to_offset"]] = $output;					
				}
			}
		}
		unset( $unprocessed_nodes[$i] );
	}
} while( $has_processed_node );

$node_states = array_map( function( node $node ) {
	return $node->getState();
}, $nodes );

print json_encode( array( "success" => TRUE, "node_states" => $node_states ), TRUE );
$did_finish_nicely = TRUE;

?>