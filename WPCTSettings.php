<?php
/**
 * The settings class which allows us to configure the WP-CodeTest plugin
 * from WordPress' menus.
 *
 * PHP version 7
 * 
 * @author Kieran McGuire <kieran.r.mcguire@gmail.com>
 */ 

class WPCTSettings {
    private $options;

    /**
     * Constructor to set things up for Wordpress
     *
     * @return WPCTSettings
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'addMenu'));
	add_action('admin_init', array($this, 'initSettings'));
    }

    /**
     * Add the settings page to the menu
     *
     * @return void
     */
    public function addMenu() {
	add_options_page(
	    'WordPress Code Test Settings',
	    'WPCT Settings',
	    'manage_options',
	    'WPCTSettingsM',
	    array($this, 'createForm')
        );
    }

    /**
     * Register the setting and set things up
     *
     * @return void
     */
    public function initSettings() {
	register_setting('WPCT-options-group', 'wpct-api-key', array($this, 'sanitizer'));

	add_settings_section(
	    'wpct-settings-section',
	    'WordPress Code Test Settings',
	    array($this, 'generateSettingsHTML'),
	    'wpct-settings'
        );

	add_settings_field(
	    'api-key',
	    'API Key',
	    array($this, 'generateAPIKeyHTML'),
	    'wpct-settings',
	    'wpct-settings-section'
	);
	

    }

    /**
     * Just a wrapper for WordPress' sanitize_text_field
     *
     * @param string $input The string to sanitize
     *
     * @return string
     */
    public function sanitizer($input) {
	return sanitize_text_field($input);
    }

    /**
     * Generate the settings form
     *
     * @return void
     */
    public function createForm() {
        ?>
        <h1>WPCT Settings</h1>
        <form method="post" action="options.php">
        <?php
	    settings_fields('WPCT-options-group');
	    do_settings_sections('wpct-settings');
	    submit_button();
        ?>
        </form>
        <?php
    }

    public function generateSettingsHTML() {
	print "The API Key for WPCT can be set here:";    
    }

    public function generateAPIKeyHTML() {
	$option = get_option("wpct-api-key");
	printf(
	    "<input type='text' name='wpct-api-key' value='%s' />",
	    isset($option) ? esc_attr($option) : ''
        );
	 
    }

}

?>
