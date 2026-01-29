<?php
/**
 * Plugin settings page template.
 *
 * Renders the admin UI for Smart Lazy Load options.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = \MozediaLazyLoad\Settings::get();
?>

<div class="wrap mll-admin">
	<h1 class="screen-reader-text">
		<?php esc_html_e( 'LazyLoad plugin by Mozedia', 'lazy-load-for-images' ); ?>
	</h1>

	<div class="mll-admin-header">
		<div class="mll-header-left">
			<h2 class="mll-title">
				<?php esc_html_e( 'Smart LazyLoad', 'lazy-load-for-images' ); ?>
			</h2>
			<span class="mll-subtitle">
				<?php esc_html_e( 'Settings', 'lazy-load-for-images' ); ?>
			</span>
		</div>

		<div class="mll-header-right">
			<p class="mll-rate-us">
				<strong>
					<?php esc_html_e( 'Do you like this plugin?', 'lazy-load-for-images' ); ?>
				</strong>
				<br>
				<?php
				printf(
					esc_html__( 'Please take a few seconds to %srate it on WordPress.org%s!', 'lazy-load-for-images' ),
					'<a href="' . esc_url( 'https://wordpress.org/support/plugin/lazy-load-for-images/reviews/?rate=5#postform' ) . '" target="_blank" rel="noopener noreferrer">',
					'</a>'
				);
				?>
				<br>
				<a class="mll-stars"
				   href="<?php echo esc_url( 'https://wordpress.org/support/plugin/lazy-load-for-images/reviews/?rate=5#postform' ); ?>"
				   target="_blank"
				   rel="noopener noreferrer">
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
					<span class="dashicons dashicons-star-filled"></span>
				</a>
			</p>
		</div>
	</div>

	<div class="mll-admin-body">

		<p class="mll-summary">
			<?php esc_html_e(
				'Smart LazyLoad plugin helps improve page speed by loading images, iframes, and videos only when they are about to appear on the viewport. This reduces unnecessary resource loading and enhances overall performance.',
				'lazy-load-for-images'
			); ?>
		</p>

		<form method="post" action="options.php" class="mll-form">
			<?php settings_fields( 'mll_settings_group' ); ?>

			<fieldset>
				<legend>
					<?php esc_html_e( 'Enable Lazy Load', 'lazy-load-for-images' ); ?>
				</legend>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-enabled"
						   name="mll_settings[enabled]"
						   value="1"
						<?php checked( $options['enabled'] ); ?>>
					<label for="mll-enabled">
						<?php esc_html_e( 'Enable Lazy Load', 'lazy-load-for-images' ); ?>
					</label>
				</div>
			</fieldset>

			<fieldset>
				<legend>
					<?php esc_html_e( 'General', 'lazy-load-for-images' ); ?>
				</legend>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-images"
						   name="mll_settings[images]"
						   value="1"
						<?php checked( $options['images'] ); ?>>
					<label for="mll-images">
						<?php esc_html_e( 'Images', 'lazy-load-for-images' ); ?>
					</label>
				</div>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-iframes"
						   name="mll_settings[iframes]"
						   value="1"
						<?php checked( $options['iframes'] ); ?>>
					<label for="mll-iframes">
						<?php esc_html_e( 'Iframes & Videos', 'lazy-load-for-images' ); ?>
					</label>
				</div>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-youtube"
						   name="mll_settings[youtube_thumbnail]"
						   value="1"
						<?php checked( $options['youtube_thumbnail'] ); ?>>
					<label for="mll-youtube">
						<?php esc_html_e( 'Replace YouTube videos by thumbnail', 'lazy-load-for-images' ); ?>
					</label>
				</div>
				
				<div class="mll-option">
					<input type="checkbox"
						   id="mll-background-image"
						   name="mll_settings[background_images]"
						   value="1"
						<?php checked( $options['background_images'] ); ?>>
					<label for="mll-background-image">
						<?php esc_html_e( 'Lazy Load background images', 'lazy-load-for-images' ); ?>
					</label>
				</div>
			</fieldset>

			<fieldset>
				<legend>
					<?php esc_html_e( 'Performance', 'lazy-load-for-images' ); ?>
				</legend>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-native"
						   name="mll_settings[use_native]"
						   value="1"
						<?php checked( $options['use_native'] ); ?>>
					<label for="mll-native">
						<?php esc_html_e( 'Use native lazy loading (if browser supported)', 'lazy-load-for-images' ); ?>
					</label>
				</div>

				<div class="mll-option-field" id="mll-threshold-wrap">
					<label for="mll-threshold">
						<?php esc_html_e( 'Threshold limit (px)', 'lazy-load-for-images' ); ?>
					</label>
					<input type="number"
						   id="mll-threshold"
						   name="mll_settings[threshold]"
						   value="<?php echo esc_attr( $options['threshold'] ); ?>"
						   min="0"
						   step="50"
						<?php disabled( $options['use_native'] ); ?>>
					<p class="description">
						<?php esc_html_e(
							'Default: 300px (recommended for better performance)',
							'lazy-load-for-images'
						); ?>
					</p>
				</div>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-skip-first"
						   name="mll_settings[skip_first]"
						   value="1"
						<?php checked( $options['skip_first'] ); ?>>
					<label for="mll-skip-first">
						<?php esc_html_e( 'Skip first image', 'lazy-load-for-images' ); ?>
					</label>
				</div>
			</fieldset>

			<fieldset>
				<legend>
					<?php esc_html_e( 'Advanced (optional)', 'lazy-load-for-images' ); ?>
				</legend>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-inline"
						   name="mll_settings[inline_assets]"
						   value="1"
						<?php checked( $options['inline_assets'] ); ?>>
					<label for="mll-inline">
						<?php esc_html_e( 'Inline plugin style CSS and JS', 'lazy-load-for-images' ); ?>
					</label>
				</div>

				<div class="mll-option">
					<input type="checkbox"
						   id="mll-loggedin"
						   name="mll_settings[disable_loggedin]"
						   value="1"
						<?php checked( $options['disable_loggedin'] ); ?>>
					<label for="mll-loggedin">
						<?php esc_html_e( 'Disable lazy load for logged-in users', 'lazy-load-for-images' ); ?>
					</label>
				</div>
			</fieldset>

			<?php submit_button( __( 'Save Changes', 'lazy-load-for-images' ) ); ?>
		</form>
	</div>
</div>
