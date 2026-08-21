<?php
namespace Add_Chat_App_Button\Includes\Style_Templates;

use Add_Chat_App_Button\Plugin;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Frontend {

	/**
	 * Print Styles
	 *
	 * Prints the Frontend CSS based on the plugin settings array.
	 *
	 * @since 2.0.0
	 */
	public static function print_styles() {
		$settings = Plugin::$instance->get_plugin_options();

		$breakpoint = !empty( $settings['breakpoint'] ) && is_numeric( $settings['breakpoint'] ) ? $settings['breakpoint'] : '600';
		$breakpoint_direction = ! empty( $settings['breakpoint_direction'] ) ? $settings['breakpoint_direction'] : 'hide_above';
		$distance_from_bottom = isset( $settings['distance_from_bottom'] ) && is_numeric( $settings['distance_from_bottom'] ) ? $settings['distance_from_bottom'] : '10';
		$distance_from_bottom_mu = isset( $settings['distance_from_bottom_mu'] ) ? $settings['distance_from_bottom_mu'] : '%'; 
		$button_bg_color = !empty( $settings['button_bg_color'] ) ? $settings['button_bg_color'] : '#20B038';
		$button_text_color = !empty( $settings['button_text_color'] ) ? $settings['button_text_color'] : '#ffffff';
		$button_location = isset( $settings['button_location'] ) ? $settings['button_location'] : 'right';
		$wp_text_direction = is_rtl() ? 'rtl' : 'ltr';
		$show_close_button = isset( $settings['enable_hide_button'] ) ? 'flex' : 'none';;
		$close_button_location = (isset( $settings['button_location'] ) && $settings['button_location'] == 'left') ? 'right' : 'left';;
		$close_button_ilh = ( isset( $settings['enable_hide_button'] ) && $settings['hide_button'] == 'full' ) ? '1' : '1.2'; //inner line height
		$icon_size = ! empty( $settings['icon_size'] ) ? sanitize_text_field( $settings['icon_size'] ) : '80';
		$icon_size_mu = ! empty( $settings['icon_size_mu'] ) ? $settings['icon_size_mu'] : 'px';

		$rect_width      = ! empty( $settings['rect_width'] ) && is_numeric( $settings['rect_width'] ) ? intval( $settings['rect_width'] ) : '';
		$rect_width_mu   = ! empty( $settings['rect_width_mu'] ) ? $settings['rect_width_mu'] : 'px';
		$rect_height     = ! empty( $settings['rect_height'] ) && is_numeric( $settings['rect_height'] ) ? intval( $settings['rect_height'] ) : '';
		$rect_height_mu  = ! empty( $settings['rect_height_mu'] ) ? $settings['rect_height_mu'] : 'px';
		$rect_padding    = ! empty( $settings['rect_padding'] ) && is_numeric( $settings['rect_padding'] ) ? intval( $settings['rect_padding'] ) : '';
		$rect_padding_mu = ! empty( $settings['rect_padding_mu'] ) ? $settings['rect_padding_mu'] : 'px';
		$rect_font_size  = ! empty( $settings['rect_font_size'] ) && is_numeric( $settings['rect_font_size'] ) ? intval( $settings['rect_font_size'] ) : '';
		$rect_font_size_mu = ! empty( $settings['rect_font_size_mu'] ) ? $settings['rect_font_size_mu'] : 'px';

		$icon_label_enable     = ! empty( $settings['icon_label_enable'] );
		$icon_label_position   = ! empty( $settings['icon_label_position'] ) ? $settings['icon_label_position'] : 'left';
		$icon_label_gap        = ! empty( $settings['icon_label_gap'] ) ? intval( $settings['icon_label_gap'] ) : 8;
		$icon_label_gap_mu     = ! empty( $settings['icon_label_gap_mu'] ) ? $settings['icon_label_gap_mu'] : 'px';
		$icon_label_font_size  = ! empty( $settings['icon_label_font_size'] ) ? intval( $settings['icon_label_font_size'] ) : 14;
		$icon_label_font_size_mu = ! empty( $settings['icon_label_font_size_mu'] ) ? $settings['icon_label_font_size_mu'] : 'px';
		$icon_label_bg_color   = ! empty( $settings['icon_label_bg_color'] ) ? $settings['icon_label_bg_color'] : '';
		$icon_label_padding    = ! empty( $settings['icon_label_padding'] ) ? intval( $settings['icon_label_padding'] ) : 8;
		$icon_label_padding_mu = ! empty( $settings['icon_label_padding_mu'] ) ? $settings['icon_label_padding_mu'] : 'px';
		$icon_label_radius     = ! empty( $settings['icon_label_radius'] ) ? intval( $settings['icon_label_radius'] ) : 4;
		$icon_label_radius_mu  = ! empty( $settings['icon_label_radius_mu'] ) ? $settings['icon_label_radius_mu'] : 'px';
		$icon_wrapper_bg_color  = ! empty( $settings['icon_wrapper_bg_color'] ) ? $settings['icon_wrapper_bg_color'] : '';
		$icon_wrapper_padding   = ! empty( $settings['icon_wrapper_padding'] ) ? intval( $settings['icon_wrapper_padding'] ) : 0;
		$icon_wrapper_padding_mu = ! empty( $settings['icon_wrapper_padding_mu'] ) ? $settings['icon_wrapper_padding_mu'] : 'px';
		$icon_wrapper_radius    = ! empty( $settings['icon_wrapper_radius'] ) ? intval( $settings['icon_wrapper_radius'] ) : 0;
		$icon_wrapper_radius_mu = ! empty( $settings['icon_wrapper_radius_mu'] ) ? $settings['icon_wrapper_radius_mu'] : 'px';
		$icon_wrapper_align     = ! empty( $settings['icon_wrapper_align'] ) ? $settings['icon_wrapper_align'] : 'center';

		if ( 'above' === $icon_label_position ) {
			$label_flex_direction = 'column-reverse';
		} elseif ( 'below' === $icon_label_position ) {
			$label_flex_direction = 'column';
		} elseif ( 'right' === $icon_label_position ) {
			$label_flex_direction = is_rtl() ? 'row-reverse' : 'row';
		} else {
			// 'left' (default) — also catches any legacy 'start'/'end' values
			$label_flex_direction = is_rtl() ? 'row' : 'row-reverse';
		}

		ob_start();
		?>
		<style type="text/css">
			<?php if ( isset( $settings['enable_breakpoint'] ) ) { ?>
				<?php $media_condition = ( 'hide_below' === $breakpoint_direction ) ? 'max-width' : 'min-width'; ?>
				@media only screen and (<?php echo $media_condition; ?>: <?php echo $breakpoint . 'px'; ?>) {
					.wab-cont {
						display: none;
					}
				}
			<?php } ?>

			img.wab-chevron {
				height: 12px;
			}

			img.wab-chevron.wab-right {
				margin-left: 1px;
			}

			img.wab-chevron.wab-left {
				margin-right: 2px;
			}

			/**
			 * Side Rectangle
			 */ 
			.wab-side-rectangle.wab-pull-right {
				right: 0;
				left: initial !important;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-side-rectangle.wab-pull-left {
				left: 0;
				right: initial !important;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-side-rectangle.wab-cont {
				position: fixed;
				bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
				z-index: 99997;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
			
			.wab-side-rectangle.wab-cont .wab-pull-right {
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-side-rectangle #whatsAppButton {
				display: block;
				position: relative;
				direction: <?php echo $wp_text_direction; ?>;
				z-index: 9999;
				cursor: pointer;
				min-width: 50px;
				max-width: 236px;
				color: <?php echo $button_text_color; ?>;
				text-align: center;
				text-decoration: none;
				padding: 10px 14px;
				margin: 0 auto 0 auto;
				background: <?php echo $button_bg_color; ?>;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
			
			.wab-side-rectangle #whatsAppButton:after {
				margin-left: 5px;
				margin-right: 5px;
				/* content: url(/wp-content/themes/html5blanknew/img/whatsapp-logo2.svg); */
				max-width: 20px;
				max-height: 20px;
				fill: currentColor;
			}

			.wab-side-rectangle #whatsAppButton svg path {
				fill: #fff;
			}

			.wab-side-rectangle #wab_close {
				display: <?php echo $show_close_button; ?>;
				align-items: center;
    			justify-content: center;
				position: absolute;
				top: -10px;
				<?php echo $close_button_location; ?>: -9px;
				z-index: 999999;
				background-color: #fff;
				font-weight: bold;
				font-size: 14px;
				border: 2px solid;
				border-radius: 12px;
				height: 20px;
				width: 20px;
				line-height: <?php echo $close_button_ilh ?>;
				text-align: center;
				cursor: pointer;
			}

			.wab-x {
				position: absolute;
    			top: 1px;
		    	font-size: 15px;
			}
			
			#wab_cont.wab-side-rectangle.wab-hidden {
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			/**
			 * Bottom Rectangle
			 */
			.wab-bottom-rectangle.wab-cont {
				position: fixed;
				bottom: 0;
				z-index: 99999;
				width: 100%;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
		
			.wab-bottom-rectangle #whatsAppButton {
				display: block;
				/* position: relative; */
				position: absolute;
				bottom: 0;
				width: 100%;
				direction: <?php echo $wp_text_direction; ?>;
				z-index: 9999;
				cursor: pointer;
				color: <?php echo $button_text_color; ?>;
				text-align: center;
				text-decoration: none;
				padding: 10px;
				margin: 0 auto 0 auto;
				background: <?php echo $button_bg_color; ?>;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-bottom-rectangle #wab_close {
				display: <?php echo $show_close_button; ?>;
				align-items: center;
    			justify-content: center;
				position: absolute;
				bottom: 38px;
				<?php echo $close_button_location; ?>: 10px;
				z-index: 999999;
				background-color: #fff;
				font-weight: bold;
				font-size: 14px;
				border: 2px solid;
				border-radius: 10px;
				height: 20px;
				width: 20px;
				line-height: <?php echo $close_button_ilh ?>;
				text-align: center;
				cursor: pointer;
			}
			
			.wab-bottom-rectangle img.wab-chevron.wab-down {
				max-width: 64%;
				position: absolute;
				top: 20%;
				left: 18%;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
			
			.wab-bottom-rectangle img.wab-chevron.wab-up {
				max-width: 64%;
				position: absolute;
				top: 12%;
				left: 18%;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
			
			#wab_cont.wab-bottom-rectangle.wab-hidden {
				/* bottom: -36px; */
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}
			
			/* Icon */
			
			.wab-icon-plain.wab-cont {
				position: fixed;
				<?php echo $button_location; ?>: 10px;
				bottom: <?php echo $distance_from_bottom; echo $distance_from_bottom_mu; ?>;
				z-index: 99999;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-icon-plain #whatsAppButton {
				display: block;
				width: <?php echo $icon_size . $icon_size_mu; ?>;
				height: <?php echo $icon_size . $icon_size_mu; ?>;
				background-position: center center;
				background-size: cover;
				background-color: none;
				background-image: url(<?php echo plugins_url( '../../img/wa-icon-original.png', __FILE__ ); ?>);
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.wab-icon-plain.wab-cont.wab-pull-left {
				left: 10px;
			}

			.wab-icon-plain.wab-cont.wab-pull-right {
				right: 10px;
			}

			.wab-icon-plain #wab_close {
				display: <?php echo $show_close_button; ?>;
				align-items: center;
    			justify-content: center;
				position: absolute;
				top: -2px;
				<?php echo $close_button_location; ?>: -5px;
				z-index: 999999;
				background-color: #fff;
				font-weight: bold;
				font-size: 14px;
				border: 2px solid;
				border-radius: 10px;
				height: 20px;
				width: 20px;
				line-height: <?php echo $close_button_ilh ?>;
				text-align: center;
				cursor: pointer;
			}
			
			#wab_cont.wab-icon-plain.wab-hidden {
				<?php echo $button_location ?>: -64px;
				-webkit-transition: All 0.5s ease;
				-moz-transition: All 0.5s ease;
				-o-transition: All 0.5s ease;
				-ms-transition: All 0.5s ease;
				transition: All 0.5s ease;
			}

			.awb-hide {
				display: none;
			}

			/* Draggable */
			#wab_drag {
				position: absolute;
				z-index: 99998;
				background-color: #20B038;
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: grab;
			}

			.wab-side-rectangle #wab_drag {
				top: 38px;
				padding: 5px;
			}

			.wab-icon-plain #wab_drag {
				top: 68px;
				right: -7px;
				padding: 9px 5px;
				border: 3px solid white;
				border-radius: 50%;
			}

			.wab-side-rectangle #wab_drag img {
				height: 6px;
			}

			.wab-icon-plain #wab_drag img {
				height: 4px;
			}

			<?php if ( $rect_width !== '' || $rect_height !== '' || $rect_padding !== '' || $rect_font_size !== '' ) : ?>

			.wab-side-rectangle #whatsAppButton,
			.wab-bottom-rectangle #whatsAppButton {
				<?php if ( $rect_width !== '' ) : ?>width: <?php echo esc_attr( $rect_width . $rect_width_mu ); ?>;<?php endif; ?>
				<?php if ( $rect_height !== '' ) : ?>height: <?php echo esc_attr( $rect_height . $rect_height_mu ); ?>;<?php endif; ?>
				<?php if ( $rect_padding !== '' ) : ?>padding: <?php echo esc_attr( $rect_padding . $rect_padding_mu ); ?>;<?php endif; ?>
				<?php if ( $rect_font_size !== '' ) : ?>font-size: <?php echo esc_attr( $rect_font_size . $rect_font_size_mu ); ?>;<?php endif; ?>
			}

			<?php endif; ?>

			<?php if ( $icon_label_enable ) : ?>

			.wab-icon-plain .wab-icon-label-wrapper {
				display: flex;
				flex-direction: <?php echo esc_attr( $label_flex_direction ); ?>;
				gap: <?php echo esc_attr( $icon_label_gap . $icon_label_gap_mu ); ?>;
				align-items: <?php echo esc_attr( $icon_wrapper_align ); ?>;
				<?php if ( $icon_wrapper_bg_color ) : ?>background-color: <?php echo esc_attr( $icon_wrapper_bg_color ); ?>;<?php endif; ?>
				<?php if ( $icon_wrapper_padding > 0 ) : ?>padding: <?php echo esc_attr( $icon_wrapper_padding . $icon_wrapper_padding_mu ); ?>;<?php endif; ?>
				<?php if ( $icon_wrapper_radius > 0 ) : ?>border-radius: <?php echo esc_attr( $icon_wrapper_radius . $icon_wrapper_radius_mu ); ?>;<?php endif; ?>
				<?php if ( ! empty( $settings['icon_wrapper_shadow'] ) ) : ?>box-shadow: 0 2px 8px rgba(0,0,0,0.3);<?php endif; ?>
			}

			.wab-icon-plain .wab-icon-label-wrapper #whatsAppButton {
				flex-shrink: 0;
			}

			.wab-icon-plain .wab-icon-label {
				font-size: <?php echo esc_attr( $icon_label_font_size . $icon_label_font_size_mu ); ?>;
				color: <?php echo esc_attr( $button_text_color ); ?>;
				white-space: nowrap;
				<?php if ( $icon_label_bg_color ) : ?>background-color: <?php echo esc_attr( $icon_label_bg_color ); ?>;<?php endif; ?>
				<?php if ( $icon_label_padding > 0 ) : ?>padding: <?php echo esc_attr( $icon_label_padding . $icon_label_padding_mu ); ?>;<?php endif; ?>
				<?php if ( $icon_label_radius > 0 ) : ?>border-radius: <?php echo esc_attr( $icon_label_radius . $icon_label_radius_mu ); ?>;<?php endif; ?>
				<?php if ( ! empty( $settings['icon_label_shadow'] ) ) : ?>box-shadow: 0 2px 8px rgba(0,0,0,0.3);<?php endif; ?>
			}

			.wab-icon-plain #wab_close {
				z-index: 9999999;
			}

			<?php endif; ?>
		</style>

		<?php
		echo ob_get_clean();
	}
}