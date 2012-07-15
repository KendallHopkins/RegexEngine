<?php

abstract class node
{
	
	//abstract const INPUTS = (int);
	//abstract const OUTPUTS = (int);
	
	protected $_state;
	
	function __construct( array $state )
	{
		$this->_state = $state;
	}
	
	//abstract function process( /* payload $input_1, ..., payload $input_n */ );
	
	abstract function getState();
	
}

class node_source_text extends node
{
	
	const INPUTS = 0;
	const OUTPUTS = 1;
	
	private $_is_valid;
	
	function process()
	{
		try {
			$lexer = new FormalTheory_RegularExpression_Lexer();
			$fa = $lexer->lex( $this->_state["text"] )->getNFA();
			$this->_is_valid = TRUE;
		} catch( Exception $e ) {
			$this->_is_valid = FALSE;
			return array();
		}
		return array( $fa );
	}
	
	function getState()
	{
		return array(
			"is_valid" => $this->_is_valid
		);
	}
	
}

class node_union extends node
{
	
	const INPUTS = 2;
	const OUTPUTS = 1;
	
	function process( FormalTheory_FiniteAutomata $fa1, FormalTheory_FiniteAutomata $fa2 )
	{
		return array( FormalTheory_FiniteAutomata::union( $fa1, $fa2 ) );
	}
	
	function getState()
	{
		return array();
	}
	
}

class node_intersection extends node
{
	
	const INPUTS = 2;
	const OUTPUTS = 1;
	
	function process( FormalTheory_FiniteAutomata $fa1, FormalTheory_FiniteAutomata $fa2 )
	{
		return array( FormalTheory_FiniteAutomata::intersection( $fa1, $fa2 ) );
	}
	
	function getState()
	{
		return array();
	}
	
}

class node_negation extends node
{
	
	const INPUTS = 1;
	const OUTPUTS = 1;
	
	function process( FormalTheory_FiniteAutomata $fa )
	{
		return array( FormalTheory_FiniteAutomata::negate( $fa ) );
	}
	
	function getState()
	{
		return array();
	}
	
}

class node_output_text extends node
{
	
	const INPUTS = 1;
	const OUTPUTS = 0;
	
	private $_text = NULL;
	
	function process( FormalTheory_FiniteAutomata $fa )
	{
		if( ! $fa->validSolutionExists() ) {
			$this->_text = 0;
			return array();
		}
		if( ! $fa->isDeterministic() ) $fa = FormalTheory_FiniteAutomata::determinize( $fa );
		$fa->minimize();
		$regex = $fa->getRegex();
		$optimizer = new FormalTheory_RegularExpression_Optimizer();
		$optimized_regex = $optimizer->safe( $regex );
		$this->_text = (string)$optimized_regex;
		return array();
	}
	
	function getState()
	{
		return array(
			"text" => $this->_text
		);
	}
	
}

class node_output_count extends node
{
	
	const INPUTS = 1;
	const OUTPUTS = 0;
	
	private $_count = NULL;
	
	function process( FormalTheory_FiniteAutomata $fa )
	{
		if( ! $fa->isDeterministic() ) $fa = FormalTheory_FiniteAutomata::determinize( $fa );
		$count = $fa->countSolutions();
		$this->_count = is_null( $count ) ? -1 : $count;
		return array();
	}
	
	function getState()
	{
		return array(
			"count" => $this->_count
		);
	}
	
}

class node_output_graph extends node
{
	
	const INPUTS = 1;
	const OUTPUTS = 0;
	
	private $_text = NULL;
	
	function process( FormalTheory_FiniteAutomata $fa )
	{
		if( ! $fa->isDeterministic() ) $fa = FormalTheory_FiniteAutomata::determinize( $fa );
		$fa->minimize();
		$this->_text = $fa->displayAsDot();
		return array();
	}
	
	function getState()
	{
		return array(
			"text" => $this->_text
		);
	}
	
}


?>