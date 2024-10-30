<?php

/**
 * Plugin Name: Lazy Load for Images
 * Plugin URI:  https://www.mozedia.com/lazy-load-images-in-wordpress/
 * Description: Lazyload WordPress Images with a small javascript without jQuery or others libraries.
 * Author:      Jumedeen khan
 * Author URI:  https://www.mozedia.com/
 * Text Domain: lazy-load-for-images
 * Version:     1.5
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;


// Glossary
class LazyLoad_Images {
	
	// Constructor.
	function __construct() {
		
		// Lazy Load for Images
		add_action( 'init', array( $this, 'mozedia_lazy_load_filters' ) );
	}
	
	public function mozedia_lazy_load_filters() {
	
		// The following filters would be merged into core.
	    $filters = array(
			'the_content',
			'get_avatar',
			'widget_text',
			'widget_text_content',
			'widget_block_content',
			'post_thumbnail_html',
		);
		
		foreach ( $filters as $filter ) {
			add_filter( $filter, array( $this, 'enable_lazy_load_for_images' ), 999 );

			// Add lazy load script in footer inline HTML
			add_action( 'wp_footer', array( $this, 'lazy_load_for_images_script' ), 99999 );
		}
	}
	
	// start function for lazy load images
	public function enable_lazy_load_for_images( $content ) {
		$original_content = $content;
		
		// Don't lazyLoad if the thumbnail is in
		if( is_admin() || is_feed() || is_preview() ) {
			return $content;
		}
	
		// Don't lazyLoad empty content
		if( empty( $content ) ) {
			return $content;
		}

		// Stop LalyLoad process with this hook
		if ( ! apply_filters( 'lazy_load_for_images', true ) ) {
			return $content;
		}

		// Don't lazy load if no images
		if ( false === strpos( $content, '<img' ) ) {
			return $content;
		}
	
		// Let's run lazy load
		$matches = array();
		preg_match_all( '/<img[\s\r\n]+(.*?)>/is', $content, $matches );
		/* preg_match_all( '/<img[\s\r\n]+.*?>/is', $content, $matches ); */
	
		$search  = array();
		$replace = array();
	
		$width  = 0;
		$height = 0;
	
		foreach ( $matches[0] as $img_html ) {
			
			// Don't replacement if image have data-src
			if ( strpos( $img_html, 'data-src') !== false || strpos( $img_html, 'data-srcset') !== false ) {
				continue;
			}
		
			// CSS classes to exclude
			if ( strpos( $img_html, 'no-lazyload') !== false ) {
			continue;
			}
		
			// Image width and Height
			$imageSizes = $this->getImageSizes($img_html);
			$width = $imageSizes[0];
            $height = $imageSizes[1];
			
			if ($width && $height) {
                $tempSrc = 'data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20' . $width . '%20' . $height . '%22%3E%3C/svg%3E';
                $widthHtml = ' width="' . $width . '" ';
            } else {
                $tempSrc = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
                $widthHtml = ' ';
            }

			// Replace src attribute to data-src and remove srcset attribute
            $output = preg_replace('/<img(.*?)src=/is', '<img $1' . $widthHtml . 'src="' . $tempSrc . '" data-src=', $img_html);
            $output = preg_replace('/<img(.*?)srcset=/is', '<img$1data-srcset=',  $output);
			
			// Add lazyload class in images
            $class = 'lazyload';
			if ( preg_match('/class=["\']/i', $output) ) {
				 $output = preg_replace('/class=(["\'])(.*?)["\']/is', 'class=$1$2 ' . $class . '$1', $output);
            } else {
                 $output = preg_replace('/<img/is', '<img class="' . $class . '"', $output);
            }
			
			// Add noscript tag for none script browser
			$output .= '<noscript>' . $img_html . '</noscript>';

            array_push($search, $img_html);
            array_push($replace, $output);
		}
		
        $search = array_unique($search);
        $replace = array_unique($replace);
        $content = str_replace($search, $replace, $content);
		
		if ( ! empty( $content ) ) {
			return $content;
		}
		
		return $original_content;
	}

    public function getImageSizes( $img_html ) {
        $width = array();
        $height = array();
        $imageSizes = array();

        preg_match('/width=["\']([0-9]{2,})["\']/i', $img_html, $width);
        preg_match('/height=["\']([0-9]{2,})["\']/i', $img_html, $height);


        if ( !empty($width) && ! empty( $height ) ) {
            $imageSizes[0] = $width[1];
            $imageSizes[1] = $height[1];
            return $imageSizes;

        } else {

            $widthSizes = array();
            preg_match('/sizes=\"\(max-width: ([0-9]{2,})px/i', $img_html, $widthSizes);

            if (!empty($widthSizes)) {
                preg_match('/-([0-9]{2,})x/i', $img_html, $width);
                preg_match('/[0-9]{2,}x([0-9]{2,})\./i', $img_html, $height);

                if (!empty($width) && !empty($height)) {

                    $ratio = $width[1] / $height[1];

                    $imageSizes[0] = $widthSizes[1];
                    $imageSizes[1] = $widthSizes[1] / $ratio;

                    return $imageSizes;
                } else {
                    $imageSizes[0] = '';
                    $imageSizes[1] = '';
                    return $imageSizes;
                }
            }

            preg_match('/-([0-9]{2,})x/i', $img_html, $width);
            preg_match('/[0-9]{2,}x([0-9]{2,})\./i', $img_html, $height);
            if (!empty($width) && !empty($height)) {
                $imageSizes[0] = $width[1];
                $imageSizes[1] = $height[1];
                return $imageSizes;
            } else {
                $imageSizes[0] = '';
                $imageSizes[1] = '';
                return $imageSizes;
            }
        }

    }
	
	public function lazy_load_for_images_script() {
		if ( ! apply_filters( 'lazy_load_for_images', true ) ) {
			return;
		} ?>

<script type="text/javascript">(function(a,e){function f(){var d=0;if(e.body&&e.body.offsetWidth){d=e.body.offsetHeight}if(e.compatMode=="CSS1Compat"&&e.documentElement&&e.documentElement.offsetWidth){d=e.documentElement.offsetHeight}if(a.innerWidth&&a.innerHeight){d=a.innerHeight}return d}function b(g){var d=ot=0;if(g.offsetParent){do{d+=g.offsetLeft;ot+=g.offsetTop}while(g=g.offsetParent)}return{left:d,top:ot}}function c(){var l=e.querySelectorAll(".lazyload[data-src]");var j=a.pageYOffset||e.documentElement.scrollTop||e.body.scrollTop;var d=f();for(var k=0;k<l.length;k++){var h=l[k];var g=b(h).top;if(g<(d+j)){h.src=h.getAttribute("data-src");h.removeAttribute("data-src");h.classList.remove(".lazyload")}}}if(a.addEventListener){a.addEventListener("DOMContentLoaded",c,false);a.addEventListener("scroll",c,false)}else{a.attachEvent("onload",c);a.attachEvent("onscroll",c)}})(window,document);</script>
	  <?php	
	}

}

// Do magic
new LazyLoad_Images();
