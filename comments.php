<?php defined( 'ABSPATH' ) || exit;

/**
 *	COMMENTS TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( post_password_required() ) { return; }

$comment_count = get_comments_number();
?>

<div id="comments" class="comments-area clear">

	<?php if ( have_comments() ) { ?>
		<h2 class="comments-title">
			<?php if ( '1' === $comment_count ) { ?>
				<?php esc_html_e( '1 comment', PRIME2G_TEXTDOM ); ?>
			<?php
			}
			else {
				?>
				<?php
				printf(
					/* translators: %s: Comment count number. */
					esc_html( _nx( '%s comment', '%s comments', $comment_count, 'Comments title', PRIME2G_TEXTDOM ) ),
					esc_html( number_format_i18n( $comment_count ) )
				);
			}
			?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'avatar_size' => 60,
					'style'       => 'ol',
					'short_ping'  => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_pagination(); ?>

		<?php
		if ( ! comments_open() ) { ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', PRIME2G_TEXTDOM ); ?></p>
		<?php
		}
	}

	comment_form(); ?>

</div><!-- #comments -->

