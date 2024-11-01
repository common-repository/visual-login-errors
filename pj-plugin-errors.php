<?php
	/*
	Plugin Name: Visual Login Errors
	Description: This plugin is no longer supported as this functionality belongs in core.
	Version: 1.1
	Author: Abandoned Plugins
	*/

	if (!class_exists('pj_visual_login_errors')) {
		class pj_visual_login_errors {
			
			// Constructor
			function pj_visual_login_errors () {
				$this->init();
			}
			
			function init() {
				// Hook into WordPress
				add_action('login_head', array(&$this, 'header_code'));
				
				// admin pages
				add_action('activate_spamshiv/pj-plugin-errors.php',  array(&$this, 'activate'));
				add_action('admin_menu', array(&$this, 'ap_hook'));
				
				if ( ! defined( 'WP_CONTENT_URL' ) )
			      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
				if ( ! defined( 'WP_CONTENT_DIR' ) )
				      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
				if ( ! defined( 'WP_PLUGIN_URL' ) )
				      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
				if ( ! defined( 'WP_PLUGIN_DIR' ) )
				      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
			}
			
			function activate () {
				$this->getAdminOptions();
			}
			
			///////////////////////////////// / / / / / / / / / / / / / /
			//
			// ADMIN RELATED FUNCTIONS
			//
			///////////////////////////////// / / / / / / / / / / / / / /
			
			function admin_page () {
                    $options = $this->getAdminOptions();
                                       
                    if (isset($_POST['update_settings'])) {
                        if (isset($_POST['feedback_type'])) {
                            $options['feedback_type'] = apply_filters('content_save_pre', $_POST['feedback_type']);
						}
						update_option($this->admin_option_name, $options);
                       
				?>
<div class="updated"><p><strong><?php _e("Settings Updated.", "Visual Login");?></strong></p></div>
				<?php } ?>
<div class="wrap">
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2>Visual Login</h2>
		<h3>Choose which kind of feedback you'd like to see.</h3>
		<p>
			<label for="feedback_type_shake">
				<input type="radio" id="feedback_type_shake" name="feedback_type" value="shake" <?php if ($options['feedback_type'] == "shake") { _e('checked="checked"', "Visual Login"); }?> /> Shake
			</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<label for="feedback_type_javascript">
				<input type="radio" id="feedback_type_drop" name="feedback_type" value="drop" <?php if ($options['feedback_type'] == "drop") { _e('checked="checked"', "Visual Login"); }?>/> Drop
			</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<label for="feedback_type_rewrite">
				<input type="radio" id="feedback_type_pulse" name="feedback_type" value="pulse" <?php if ($options['feedback_type'] == "pulse") { _e('checked="checked"', "Visual Login"); }?>/> Pulse
			</label>
		</p>
		
		<div class="submit"><input type="submit" name="update_settings" value="<?php _e('Update Settings', 'Visual Login') ?>" /></div>
	</form>
</div>
					<?php
			}
			
			function ap_hook() {
				add_options_page('Visual Login', 'Visual Login', 9, basename(__FILE__), array(&$this, 'admin_page'));
			}  
			
			//Returns an array of admin options
			function getAdminOptions() {
				$admin_options = array(
					'feedback_type' => 'shake'
				);
				$options = get_option($this->admin_option_name);
				if (!empty($options)) {
					foreach ($options as $key => $opt) {
						$admin_options[$key] = $opt;
					}
				}            
				update_option($this->admin_option_name, $admin_options);
				return $admin_options;
			}
			
			function header_code () {
				$options = $this->getAdminOptions();
				echo '<script language="javascript" src="'.WP_PLUGIN_URL.'/visual-login-errors/js/jquery-1.3.2.min.js"></script>';
				echo '<script language="javascript" src="'.WP_PLUGIN_URL.'/visual-login-errors/js/jquery.easing.1.3.js"></script>';
				echo '<script language="javascript" src="'.WP_PLUGIN_URL.'/visual-login-errors/js/'.$options['feedback_type'].'.js"></script>';
				if (isset($_POST['log']) && isset($_POST['pwd'])) {
					echo '<script language="javascript">$(document).ready(function () {';
						if ($options['feedback_type'] == 'shake')
							echo "$('div#login').shake(3,20,500);";
						else if ($options['feedback_type'] == 'drop')
							echo "$('div#login').drop(2,10,400);";
						else if ($options['feedback_type'] == 'pulse')
							echo "$('form#loginform').pulse(3,10,400);";
					echo '});</script>';
				}
			}
		}
		
		// Pull the string and let her rip!
		$vl &= new pj_visual_login_errors();
	}
?>
