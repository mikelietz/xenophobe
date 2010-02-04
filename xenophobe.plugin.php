<?php

/**
 * Xenophobe Class
 *
 * This plugin disallows insertion of comments containing Unicode
 */

class Xenophobe extends Plugin
{
	/*
	 * @param Comment $comment The submitted comment object
	 * @param boolean $allow
	 * @return boolean false to discard the comment
	 */
	public function filter_comment_insert_allow( $allow, $comment )
	{
		// This plugin ignores non-comments
		if( $comment->type != Comment::COMMENT ) {
			return $allow;
		}

		$pattern = '/[\x80-\xFF]/'; // matches non-ASCII
		foreach ( array_keys( Comment::default_fields() ) as $commentfield) {
			if ( preg_match( $pattern, $comment->{$commentfield} ) ) {
				$allow = false;
			}
		}

		return $allow;
	}
	

	/**
	 * Add update beacon support
	 **/
	public function action_update_check()
	{
	 	Update::add( 'Xenophobe', 'b3ce7d21-673d-4e4d-9e2f-b63528a1d744', $this->info->version );
	}

}

?>
