<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: FILE WRITER
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.91
 */
if ( ! class_exists( 'Prime2gFileWriter' ) ) {

class Prime2gFileWriter {
private	$file_dir_path,
		$file_name,
		$path_to_file,
		$timestamp;
public	$response;


function __construct( string $file_dir_path, string $full_file_name ) {
	$this->file_dir_path	=	trailingslashit( $file_dir_path );
	$this->file_name		=	$full_file_name;
	$this->path_to_file		=	$this->file_dir_path . $this->file_name;
	# $this->timestamp		=	json_encode( date_create( 'now' ) );
}


function read( string $full_path_to_file = '' ) {
	$file	=	$full_path_to_file ?: $this->path_to_file;
	return file_get_contents( $file );
}


function write( string $content, array $options = [] ) {
	// $entry_time	=	json_decode( $this->timestamp )->date;	// not used yet
	$find_text		=	'#	ToongeePrime Theme Caching';
	$allow_repeat	=	false;
	$admin_only		=	true;

	extract( $options );

	if ( $admin_only && ! current_user_can( 'update_core' ) ) {
		$this->response	=	__( 'Illegal action', PRIME2G_TEXTDOM );
		return;
	}

	if ( ! $allow_repeat ) {
		$file_contents	=	$this->read();
		if ( str_contains( $file_contents, $find_text ) ) {
			$this->response	=	__( 'Content exists in file already', PRIME2G_TEXTDOM );
			return;
		}
	}

	$f	=	fopen( $this->file_name, "a" );
	if ( ! $f ) {
		$this->response	=	__( 'Cannot open file', PRIME2G_TEXTDOM );
		return;
	}
	if ( false === fwrite( $f, $content ) ) {
		$this->response	=	__( 'Cannot write to file', PRIME2G_TEXTDOM );
		return;
	}
	fclose( $f );
	$this->response	=	__( 'Successfully wrote to file', PRIME2G_TEXTDOM );
}


function delete( string $delete_content, array $options = [] ) {
	$delete_all	=	false;
	$admin_only	=	true;

	extract( $options );

	if ( $admin_only && ! current_user_can( 'update_core' ) ) {
		$this->response	=	__( 'Illegal action', PRIME2G_TEXTDOM );
		return;
	}

	$initial_contents	=	$this->read();	// Hold initial file contents

	$f	=	$delete_all ? fopen( $this->file_name, 'w' ) : fopen( $this->file_name, "a+" );
	if ( ! $f ) {
		$this->response	=	__( 'Cannot open file', PRIME2G_TEXTDOM );
		return;
	}

	if ( $delete_all ) {
		if ( empty( $initial_contents ) ) $this->response	=	__( 'File already empty', PRIME2G_TEXTDOM );
		else $this->response	=	__( 'File completely emptied', PRIME2G_TEXTDOM );
		fclose( $f ); return;
	}

	if ( ! str_contains( $initial_contents, $delete_content ) ) {
		$this->response	=	__( 'Specified file contents not found to delete', PRIME2G_TEXTDOM );
		return;
	}

	$new_contents	=	str_replace( $delete_content,  '', $initial_contents );
	fopen( $this->file_name, 'w' );	// empty file before adding new contents
	
	if ( false === fwrite( $f, $new_contents ) ) {
		$this->response	=	__( 'Cannot write to file', PRIME2G_TEXTDOM );
		return;
	}
	fclose( $f );
	$this->response	=	__( 'Successfully deleted specified file contents', PRIME2G_TEXTDOM );
}


static function siterootpath( string $append = '' ) {
	if ( ! current_user_can( 'update_core' ) ) return null;
	require_once ABSPATH . 'wp-admin/includes/file.php';
	return get_home_path() . $append;
}

}

}

