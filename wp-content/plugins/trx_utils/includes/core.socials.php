<?php
/**
 * InsuranceAncora Framework: social networks
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('insurance_ancora_socials_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_socials_theme_setup', 1 );
	function insurance_ancora_socials_theme_setup() {

		if ( !is_admin() ) {
			// Add og:image meta tag for facebook
			add_action( 'wp_head', 'insurance_ancora_facebook_og_tags', 5 );
		}

        if (!function_exists('insurance_ancora_socials_theme_setup1')) {
            add_action('insurance_ancora_action_before_init_theme', 'insurance_ancora_socials_theme_setup1');
            function insurance_ancora_socials_theme_setup1()
            {

                // List of social networks for site sharing and user profiles
                insurance_ancora_storage_set('share_links', array(
                        'blogger' => insurance_ancora_get_protocol() . '://www.blogger.com/blog_this.pyra?t&u={link}&n={title}',
                        'bobrdobr' => insurance_ancora_get_protocol() . '://bobrdobr.ru/add.html?url={link}&title={title}&desc={descr}',
                        'delicious' => insurance_ancora_get_protocol() . '://delicious.com/save?url={link}&title={title}&note={descr}',
                        'designbump' => insurance_ancora_get_protocol() . '://designbump.com/node/add/drigg/?url={link}&title={title}',
                        'designfloat' => insurance_ancora_get_protocol() . '://www.designfloat.com/submit.php?url={link}',
                        'digg' => insurance_ancora_get_protocol() . '://digg.com/submit?url={link}',
                        'evernote' => 'https://www.evernote.com/clip.action?url={link}&title={title}',
                        'facebook' => insurance_ancora_get_protocol() . '://www.facebook.com/sharer.php?u={link}',
                        'friendfeed' => insurance_ancora_get_protocol() . '://www.friendfeed.com/share?title={title} - {link}',
                        'google' => insurance_ancora_get_protocol() . '://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk={link}&title={title}&annotation={descr}',
                        'gplus' => 'https://plus.google.com/share?url={link}',
                        'identi' => insurance_ancora_get_protocol() . '://identi.ca/notice/new?status_textarea={title} - {link}',
                        'juick' => insurance_ancora_get_protocol() . '://www.juick.com/post?body={title} - {link}',
                        'linkedin' => insurance_ancora_get_protocol() . '://www.linkedin.com/shareArticle?mini=true&url={link}&title={title}',
                        'liveinternet' => insurance_ancora_get_protocol() . '://www.liveinternet.ru/journal_post.php?action=n_add&cnurl={link}&cntitle={title}',
                        'livejournal' => insurance_ancora_get_protocol() . '://www.livejournal.com/update.bml?event={link}&subject={title}',
                        'mail' => insurance_ancora_get_protocol() . '://connect.mail.ru/share?url={link}&title={title}&description={descr}&imageurl={image}',
                        'memori' => insurance_ancora_get_protocol() . '://memori.ru/link/?sm=1&u_data[url]={link}&u_data[name]={title}',
                        'mister-wong' => insurance_ancora_get_protocol() . '://www.mister-wong.ru/index.php?action=addurl&bm_url={link}&bm_description={title}',
                        'mixx' => insurance_ancora_get_protocol() . '://chime.in/chimebutton/compose/?utm_source=bookmarklet&utm_medium=compose&utm_campaign=chime&chime[url]={link}&chime[title]={title}&chime[body]={descr}',
                        'moykrug' => insurance_ancora_get_protocol() . '://share.yandex.ru/go.xml?service=moikrug&url={link}&title={title}&description={descr}',
                        'myspace' => insurance_ancora_get_protocol() . '://www.myspace.com/Modules/PostTo/Pages/?u={link}&t={title}&c={descr}',
                        'newsvine' => insurance_ancora_get_protocol() . '://www.newsvine.com/_tools/seed&save?u={link}&h={title}',
                        'odnoklassniki' => insurance_ancora_get_protocol() . '://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl={link}&title={title}',
                        'pikabu' => insurance_ancora_get_protocol() . '://pikabu.ru/add_story.php?story_url={link}',
                        'pinterest' => 'json:{"link": "http://pinterest.com/pin/create/button/", "script": "//assets.pinterest.com/js/pinit.js", "style": "", "attributes": {"data-pin-do": "buttonPin", "data-pin-media": "{image}", "data-pin-url": "{link}", "data-pin-description": "{title}", "data-pin-custom": "true","nopopup": "true"}}',
                        'posterous' => insurance_ancora_get_protocol() . '://posterous.com/share?linkto={link}&title={title}',
                        'postila' => insurance_ancora_get_protocol() . '://postila.ru/publish/?url={link}&agregator=insurance_ancora',
                        'reddit' => insurance_ancora_get_protocol() . '://reddit.com/submit?url={link}&title={title}',
                        'rutvit' => insurance_ancora_get_protocol() . '://rutvit.ru/tools/widgets/share/popup?url={link}&title={title}',
                        'stumbleupon' => insurance_ancora_get_protocol() . '://www.stumbleupon.com/submit?url={link}&title={title}',
                        'surfingbird' => insurance_ancora_get_protocol() . '://surfingbird.ru/share?url={link}',
                        'technorati' => insurance_ancora_get_protocol() . '://technorati.com/faves?add={link}&title={title}',
                        'tumblr' => insurance_ancora_get_protocol() . '://www.tumblr.com/share?v=3&u={link}&t={title}&s={descr}',
                        'twitter' => 'https://twitter.com/intent/tweet?text={title}&url={link}',
                        'vk' => insurance_ancora_get_protocol() . '://vk.com/share.php?url={link}&title={title}&description={descr}',
                        'vk2' => insurance_ancora_get_protocol() . '://vk.com/share.php?url={link}&title={title}&description={descr}',
                        'webdiscover' => insurance_ancora_get_protocol() . '://webdiscover.ru/share.php?url={link}',
                        'yahoo' => insurance_ancora_get_protocol() . '://bookmarks.yahoo.com/toolbar/savebm?u={link}&t={title}&d={descr}',
                        'yandex' => insurance_ancora_get_protocol() . '://zakladki.yandex.ru/newlink.xml?url={link}&name={title}&descr={descr}',
                        'ya' => insurance_ancora_get_protocol() . '://my.ya.ru/posts_add_link.xml?URL={link}&title={title}&body={descr}',
                        'yosmi' => insurance_ancora_get_protocol() . '://yosmi.ru/index.php?do=share&url={link}'
                    )
                );
            }
        }
	}
}


/* Social Share and Profile links
-------------------------------------------------------------------------------- */

// Add social network
// Example: 1) add_share_link('pinterest', 'url');
//			2) add_share_link(array('pinterest'=>'url', 'dribble'=>'url'));
if (!function_exists('insurance_ancora_add_share_link')) {
	function insurance_ancora_add_share_link($soc, $url='') {
		if (!is_array($soc)) $soc = array($soc => $url);
		insurance_ancora_storage_set('share_links', array_merge( insurance_ancora_storage_get('share_links'), $soc ) );
	}
}

// Return (and show) share social links
if (!function_exists('insurance_ancora_show_share_links')) {
	function insurance_ancora_show_share_links($args) {
		if ( insurance_ancora_get_custom_option('show_share')=='hide' ) return '';

		$args = array_merge(array(
			'post_id' => 0,						// post ID
			'post_link' => '',					// post link
			'post_title' => '',					// post title
			'post_descr' => '',					// post descr
			'post_thumb' => '',					// post featured image
			'size' => 'small',					// icons size: tiny|small|big
			'style' => insurance_ancora_get_theme_setting('socials_type')=='images' ? 'bg' : 'icons',	// style for show icons: icons|images|bg
			'type' => 'block',					// share block type: list|block|drop
			'popup' => true,					// open share url in new window or in popup window
			'counters' => insurance_ancora_get_custom_option('show_share_counters')=='yes',	// show share counters
			'direction' => insurance_ancora_get_custom_option('show_share'),				// share block direction
			'caption' => insurance_ancora_get_custom_option('share_caption'),				// share block caption
			'share' => insurance_ancora_get_theme_option('share_buttons'),					// list of allowed socials
			'echo' => true						// if true - show on page, else - only return as string
			), $args);

		if (count($args['share'])==0) return '';
		$empty = false;
		foreach ($args['share'] as $k=>$v) {
			if (!is_array($v) || implode('', $v)=='') 
				$empty = true;
			break;
		}
		if ($empty) return '';
		
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];

		$output = '<div class="sc_socials sc_socials_size_'.esc_attr($args['size']).' sc_socials_share' . ($args['type']=='drop' ? ' sc_socials_drop' : ' sc_socials_dir_' . esc_attr($args['direction'])) . '">'
			. ($args['caption']!='' ? '<span class="share_caption">'.($args['caption']).'</span>' : '');

		if (is_array($args['share']) && count($args['share']) > 0) {
			foreach ($args['share'] as $soc) {
				$icon = $args['style']=='icons' || insurance_ancora_strpos($soc['icon'], $upload_url)!==false ? $soc['icon'] : insurance_ancora_get_socials_url(basename($soc['icon']));
				if ($args['style'] == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $parts[0];
				} else {
					$sn = basename($soc['icon']);
					$sn = insurance_ancora_substr($sn, 0, insurance_ancora_strrpos($sn, '.'));
					if (($pos=insurance_ancora_strrpos($sn, '_'))!==false)
						$sn = insurance_ancora_substr($sn, 0, $pos);
				}
				$url = $soc['url'];

                if (substr($url, 0, 5) == 'json:') {
                    $url = json_decode(substr($url, 5), true);
                    if (is_null($url))
                        continue;
                } else {
                    $url = array('link' => $url);
                }

                if (!isset($url['attributes']))
                    $url['attributes'] = array();
                $url['attributes']['href'] = $url['link'];
                $email = strpos($url['link'], 'mailto:')!==false;
                $popup = !empty($args['popup']) && !$email && empty($url['attributes']['nopopup']);
                if (!empty($popup))
                    $url['attributes']['data-link'] = esc_url($url['link']);
                else
                    $url['attributes']['target'] = '_blank';
                if ($args['counters'])
                    $url['attributes']['data-count'] = $sn;

				if (empty($url)) $url = insurance_ancora_storage_get_array('share_links', $sn);
			
				$link = str_replace(
					array('{id}', '{link}', '{title}', '{descr}', '{image}'),
					array(
						urlencode($args['post_id']),
						urlencode($args['post_link']),
						urlencode(strip_tags($args['post_title'])),
						urlencode(strip_tags($args['post_descr'])),
						urlencode($args['post_thumb'])
						),
                    is_array($url) ? $url['link'] : $url);
				$output .= '<div class="sc_socials_item' . (!empty($args['popup']) ? ' social_item_popup' : '') . '">'
						. '<a href="'.esc_url($soc['url']).'"'
						. ' class="social_icons social_'.esc_attr($sn).'"'
						. ($args['style']=='bg' ? ' style="background-image: url('.esc_url($icon).');"' : '')
						. ($args['popup'] ? ' data-link="' . esc_url($link) .'"' : ' target="_blank"')
						. ($args['counters'] ? ' data-count="'.esc_attr($sn).'"' : '') ;
                if ( is_array($url)) {
                    foreach($url['attributes'] as $k=>$v) {
                        $v = str_replace(
                            array('{id}', '{link}', '{title}', '{descr}', '{image}'),
                            array(
                                $k=='href' ? urlencode($args['post_id']) : $args['post_id'],
                                $k=='href' ? urlencode($args['post_link']) : $args['post_link'],
                                $k=='href' && !$email ? urlencode(strip_tags($args['post_title'])) : strip_tags($args['post_title']),
                                $k=='href' && !$email ? urlencode(strip_tags($args['post_descr'])) : strip_tags($args['post_descr']),
                                $k=='href' ? urlencode($args['post_thumb']) : $args['post_thumb']
                            ),
                            $v);
                        $output .= " {$k}=\"" . ($k=='href' ? esc_url($v) : esc_attr($v)) . '"';
                    }
                }

                $output .= '>'

					. ($args['style']=='icons' 
						? '<span class="' . esc_attr($soc['icon']) . '"></span>' 
						: ($args['style']=='images' 
							? '<img src="'.esc_url($icon).'" alt="'.esc_attr($sn).'" />' 
							: '<span class="sc_socials_hover" style="background-image: url('.esc_url($icon).');"></span>'
							)
						)
					. '</a>'
					. ($args['type']=='drop' ? '<i>' . trim(insurance_ancora_strtoproper($sn)) . '</i>' : '')
					. '</div>';


                if (!empty($url['script']))
                    wp_enqueue_script( "trx_addons_share_{$sn}", $url['script'], array(), null, true );


        }
		}
		$output .= '</div>';
		if ($args['echo']) insurance_ancora_show_layout($output);
		return $output;
	}
}


// Return social icons links
if (!function_exists('insurance_ancora_prepare_socials')) {
	function insurance_ancora_prepare_socials($list, $style='') {
		if (empty($style)) $style = insurance_ancora_get_theme_setting('socials_type')=='images' ? 'bg' : 'icons';
		$output = '';
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $soc) {
				if (empty($soc['url'])) continue;
				$icon = $style=='icons' || insurance_ancora_strpos($soc['icon'], $upload_url)!==false ? $soc['icon'] : insurance_ancora_get_socials_url(basename($soc['icon']));
				if ($style == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $parts[0];
				} else {
					$sn = basename($soc['icon']);
					$sn = insurance_ancora_substr($sn, 0, insurance_ancora_strrpos($sn, '.'));
					if (($pos=insurance_ancora_strrpos($sn, '_'))!==false)
						$sn = insurance_ancora_substr($sn, 0, $pos);
				}
				$output .= '<div class="sc_socials_item">'
						. '<a href="'.esc_url($soc['url']).'" target="_blank" class="social_icons social_'.esc_attr($sn).'"'
						. ($style=='bg' ? ' style="background-image: url('.esc_url($icon).');"' : '')
						. '>'
						. ($style=='icons' 
							? '<span class="icon-' . esc_attr($sn) . '"></span>' 
							: ($style=='images' 
								? '<img src="'.esc_url($icon).'" alt="" />' 
								: '<span class="sc_socials_hover" style="background-image: url('.esc_url($icon).');"></span>'))
						. '</a>'
						. '</div>';
			}
		}
		return $output;
	}
}
	
	
/* Twitter
-------------------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_get_twitter_data')) {
	function insurance_ancora_get_twitter_data($cfg) {
		return function_exists('trx_utils_twitter_acquire_data') 
				? trx_utils_twitter_acquire_data(array(
						'mode'            => 'user_timeline',
						'consumer_key'    => $cfg['consumer_key'],
						'consumer_secret' => $cfg['consumer_secret'],
						'token'           => $cfg['token'],
						'secret'          => $cfg['secret']
					))
				: '';
	}
}

if (!function_exists('insurance_ancora_prepare_twitter_text')) {
	function insurance_ancora_prepare_twitter_text($tweet) {
		$text = $tweet['text'];
		if (!empty($tweet['entities']['urls']) && count($tweet['entities']['urls']) > 0) {
			foreach ($tweet['entities']['urls'] as $url) {
				$text = str_replace($url['url'], '<a href="'.esc_url($url['expanded_url']).'" target="_blank">' . ($url['display_url']) . '</a>', $text);
			}
		}
		if (!empty($tweet['entities']['media']) && count($tweet['entities']['media']) > 0) {
			foreach ($tweet['entities']['media'] as $url) {
				$text = str_replace($url['url'], '<a href="'.esc_url($url['expanded_url']).'" target="_blank">' . ($url['display_url']) . '</a>', $text);
			}
		}
		return $text;
	}
}

// Return Twitter followers count
if (!function_exists('insurance_ancora_get_twitter_followers')) {
	function insurance_ancora_get_twitter_followers($cfg) {
		$data = insurance_ancora_get_twitter_data($cfg); 
		return $data && isset($data[0]['user']['followers_count']) ? $data[0]['user']['followers_count'] : 0;
	}
}



/* Facebook
-------------------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_get_facebook_likes')) {
	function insurance_ancora_get_facebook_likes($account) {
		$fb = get_transient("facebooklikes");
		if ($fb !== false) return $fb;
		$fb = '?';
		$url = esc_url(insurance_ancora_get_protocol().'://graph.facebook.com/'.($account));
		$headers = get_headers($url);
		if (insurance_ancora_strpos($headers[0], '200')) {
			$json = insurance_ancora_fgc($url);
			$rez = json_decode($json, true);
			if (isset($rez['likes']) ) {
				$fb = $rez['likes'];
				set_transient("facebooklikes", $fb, 60*60);
			}
		}
		return $fb;
	}
}


// Add facebook meta tags for post/page sharing
if (!function_exists('insurance_ancora_facebook_og_tags')) {
	function insurance_ancora_facebook_og_tags() {
		global $post;
		if ( !is_singular() || insurance_ancora_storage_get('blog_streampage')) return;
		if (has_post_thumbnail( $post->ID )) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>' . "\n";
		}
	}
}


/* Feedburner
-------------------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_get_feedburner_counter')) {
	function insurance_ancora_get_feedburner_counter($account) {
		$rss = get_transient("feedburnercounter");
		if ($rss !== false) return $rss;
		$rss = '?';
		$url = esc_url(insurance_ancora_get_protocol().'://feedburner.google.com/api/awareness/1.0/GetFeedData?uri='.($account));
		$headers = get_headers($url);
		if (insurance_ancora_strpos($headers[0], '200')) {
			$xml = insurance_ancora_fgc($url);
			preg_match('/circulation="(\d+)"/', $xml, $match);
			if ($match[1] != 0) {
				$rss = $match[1];
				set_transient("feedburnercounter", $rss, 60*60);
			}
		}
		return $rss;
	}
}
?>