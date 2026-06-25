<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( post_password_required() ) return;
?>
<div id="comments" class="comments-area clinox-comments">

	<?php if ( have_comments() ) : ?>
	<div class="clinox-comment-list headline pera-content">
		<h3 class="comments-title">
			<?php
			printf(
				esc_html( nsp_is_arabic() ? '%1$s تعليق' : _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'newsuperprime' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h3>
		<ul class="comment-list">
			<?php
			wp_list_comments( [
				'style'      => 'ul',
				'short_ping' => true,
				'avatar_size'=> 60,
			] );
			?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments"><?php nsp_te( 'Comments are closed.', 'التعليقات مغلقة.' ); ?></p>
	<?php endif; ?>

	<?php
	$_commenter = wp_get_current_commenter();
	$_comment_user = wp_get_current_user();
	$_logged_in_as = '';
	if ( is_user_logged_in() ) {
		$_logged_in_as = sprintf(
			nsp_t( 'Logged in as %1$s. %2$s. %3$s?', 'تم تسجيل الدخول باسم %1$s. %2$s. %3$s؟' ),
			'<a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . esc_html( $_comment_user->display_name ) . '</a>',
			'<a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . esc_html( nsp_t( 'Edit your profile', 'تعديل ملفك الشخصي' ) ) . '</a>',
			'<a href="' . esc_url( wp_logout_url( get_permalink() ) ) . '">' . esc_html( nsp_t( 'Log out', 'تسجيل الخروج' ) ) . '</a>'
		);
	}

	comment_form( [
		'title_reply'          => nsp_t( 'Leave a Comment', 'اترك تعليقاً' ),
		'title_reply_before'   => '<h3 class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'class_submit'         => 'submit clinox-btn-submit',
		'label_submit'         => nsp_t( 'Post Comment', 'إرسال التعليق' ),
		'comment_notes_before' => '<p class="comment-notes">' . esc_html( nsp_t( 'Required fields are marked *', 'الحقول المطلوبة مميزة بعلامة *' ) ) . '</p>',
		'logged_in_as'         => $_logged_in_as ? '<p class="logged-in-as">' . $_logged_in_as . '</p>' : '',
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html( nsp_t( 'Comment', 'التعليق' ) ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
		'fields'               => [
			'author' => '<p class="comment-form-author"><label for="author">' . esc_html( nsp_t( 'Name', 'الاسم' ) ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr( $_commenter['comment_author'] ) . '" size="30" required="required"></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . esc_html( nsp_t( 'Email', 'البريد الإلكتروني' ) ) . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr( $_commenter['comment_author_email'] ) . '" size="30" required="required"></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . esc_html( nsp_t( 'Website', 'الموقع الإلكتروني' ) ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $_commenter['comment_author_url'] ) . '" size="30"></p>',
		],
	] );
	?>
</div>
