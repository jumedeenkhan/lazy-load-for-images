<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle frontend assets for the plugin.
 */
class Assets {

	/**
	 * Register asset-related hooks.
	 *
	 * @return void
	 */
	public static function init() {

		// Frontend assets
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'mozedia_frontend_script' ], PHP_INT_MAX );

		// No-JS fallback CSS
		add_action( 'wp_head', [ __CLASS__, 'mozedia_noscript_style' ], PHP_INT_MAX );
	}

	/**
	 * Enqueue frontend lazy load scripts and styles.
	 *
	 * @return void
	 */
	public static function mozedia_frontend_script() {

		$o = Settings::get();

		if ( ! $o['enabled'] || ( $o['disable_loggedin'] && is_user_logged_in() ) ) {
			return;
		}

		$threshold  = absint( $o['threshold'] );
		$use_native = ! empty( $o['use_native'] ) ? '!0' : '!1';

		// Inline CSS
		wp_register_style( 'mozedia-lazyload', false );
		wp_enqueue_style( 'mozedia-lazyload' );
		wp_add_inline_style(
			'mozedia-lazyload',
			self::base_inline_css() . ( ! empty( $o['youtube_thumbnail'] ) ? self::youtube_inline_css() : '' )
		);

		$handle = 'mozedia-lazyload-core';

		if ( ! empty( $o['inline_assets'] ) ) {

			wp_register_script( $handle, '', [], MLL_VERSION, true );
			wp_enqueue_script( $handle );

			wp_add_inline_script(
				$handle,
				self::mozedia_inline_full_js( $threshold, $use_native )
			);

			return;
		}

		wp_enqueue_script(
			$handle,
			MLL_URL . 'assets/js/lazyload.min.js',
			[],
			MLL_VERSION,
			true
		);

		wp_add_inline_script(
			$handle,
			self::lazyload_config_js( $threshold, $use_native ),
			'before'
		);

		if ( ! empty( $o['youtube_thumbnail'] ) ) {
			wp_add_inline_script(
				$handle,
				self::youtube_helper_js(),
				'after'
			);
		}
	}

	/**
	 * Output noscript fallback styles.
	 *
	 * @return void
	 */
	public static function mozedia_noscript_style() {

		$o = Settings::get();

		if ( empty( $o['enabled'] ) ) {
			return;
		}

		if ( ! empty( $o['disable_loggedin'] ) && is_user_logged_in() ) {
			return;
		}

		echo '<noscript><style id="mozedia-lazyload-nojs-css">.mll-youtube-player,[data-src]{display:none !important;}</style></noscript>' . "\n";
	}

	/**
	 * Build full inline JavaScript payload.
	 *
	 * @param int    $threshold  Lazy load threshold.
	 * @param string $use_native Native lazy loading flag.
	 * @return string
	 */
	private static function mozedia_inline_full_js( $threshold, $use_native ) {
		$o  = Settings::get();
		$js = self::lazyload_config_js( $threshold, $use_native ) . "\n";
		$js .= LazyloadCore::js() . "\n";

		if ( ! empty( $o['youtube_thumbnail'] ) ) {
			$js .= self::youtube_helper_js();
		}

		return $js;
	}

	private static function lazyload_config_js( $threshold, $use_native ) {
		return <<<JS
window.lazyLoadOptions=[{elements_selector:"[loading=lazy],img[data-src],.mll-lazy,iframe[data-src]",class_loading:"mll-lazyloading",class_loaded:"mll-lazyloaded",threshold:{$threshold},use_native:{$use_native}},{elements_selector:".mozedia-lazyload",data_bg:"bg",class_loading: "mll-lazyloading",class_loaded: "mll-lazyloaded",threshold: {$threshold}}],window.addEventListener("LazyLoad::Initialized",(function(e){var a=e.detail.instance;window.MutationObserver&&new MutationObserver((function(e){var t=0,l=0,s=0;e.forEach((function(e){for(var a=0;a<e.addedNodes.length;a++){var n=e.addedNodes[a];if("function"==typeof n.getElementsByTagName&&"function"==typeof n.getElementsByClassName){var d=n.getElementsByTagName("img"),i=n.getElementsByTagName("iframe"),o=n.getElementsByClassName("mll-lazy");t+=d.length,l+=i.length,s+=o.length,"IMG"===n.tagName&&(t+=1),"IFRAME"===n.tagName&&(l+=1)}}})),(t>0||l>0||s>0)&&a.update()})).observe(document.body,{childList:!0,subtree:!0})}),!1);
JS;
	}

	private static function youtube_helper_js() {
		return <<<'JS'
function lazyLoadThumb(e,t,a){let r='<img loading="lazy" src="https://i.ytimg.com/vi/ID/hqdefault.jpg" alt="" width="480" height="360">',l='<button class="mll-play" aria-label="play Youtube video"></button>';return a&&(r=r.replace('data-lazy-',"").replace('loading="lazy"',"").replace(/<noscript>.*?<\/noscript>/g,"")),r=r.replace('alt=""',`alt="${t}"`),r.replace("ID",e)+l}
function lazyLoadYoutubeIframe(){const e=document.createElement("iframe");let t="ID?autoplay=1";this.parentNode.dataset.query.length!==0&&(t+="&"+this.parentNode.dataset.query),e.setAttribute("src",t.replace("ID",this.parentNode.dataset.src)),e.setAttribute("frameborder","0"),e.setAttribute("allowfullscreen","1"),e.setAttribute("allow","accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"),this.parentNode.parentNode.replaceChild(e,this.parentNode)}
document.addEventListener("DOMContentLoaded",function(){const e=[],t=document.getElementsByClassName("mll-youtube-player");for(let a=0;a<t.length;a++){const r=document.createElement("div");let l="https://i.ytimg.com/vi/ID/hqdefault.jpg";l=l.replace("ID",t[a].dataset.id);const d=e.some(e=>l.includes(e));r.setAttribute("data-id",t[a].dataset.id),r.setAttribute("data-query",t[a].dataset.query),r.setAttribute("data-src",t[a].dataset.src),r.innerHTML=lazyLoadThumb(t[a].dataset.id,t[a].dataset.alt,d),t[a].appendChild(r),r.querySelector(".mll-play").onclick=lazyLoadYoutubeIframe}})
JS;
	}

	private static function base_inline_css() {
		return '.mll-lazy{opacity:0;transition:opacity .3s}.mll-lazyloaded{opacity:1}';
	}

	private static function youtube_inline_css() {
	return '.mll-youtube-player{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;max-width:100%;background:#000}.mll-youtube-player:focus-within{outline:2px solid currentColor;outline-offset:5px}.mll-youtube-player iframe{position:absolute;top:0;left:0;width:100%;height:100%;z-index:100;border:0;background:0 0}.mll-youtube-player img{position:absolute;inset:0;margin:auto;width:100%;max-width:100%;height:auto;display:block;border:0;transition:filter .4s ease,transform .4s ease}.mll-youtube-player img:hover{filter:brightness(75%);transform:scale(1.02)}.mll-youtube-player .mll-play{position:absolute;inset:0;width:100%;height:100%;cursor:pointer;border:0;background-color:transparent!important;background-repeat:no-repeat;background-position:center;background-size:68px 48px;z-index:10}.mll-youtube-player .mll-play::before{content:"";position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:68px;height:48px;background:rgba(0,0,0,.65);border-radius:14px}.mll-youtube-player .mll-play::after{content:"";position:absolute;top:50%;left:50%;transform:translate(-40%,-50%);border-style:solid;border-width:12px 0 12px 20px;border-color:transparent transparent transparent #fff}.mll-youtube-player:hover .mll-play::before{background:rgba(255,0,0,.85)}.wp-embed-responsive .wp-has-aspect-ratio .mll-youtube-player{position:absolute;padding-bottom:0;width:100%;height:100%;inset:0}';
	}
}
