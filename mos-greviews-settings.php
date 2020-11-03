<?php
function mos_greviews_settings_init() {
	register_setting( 'mos_greviews', 'mos_greviews_options' );
	add_settings_section('mos_greviews_section_top_nav', '', 'mos_greviews_section_top_nav_cb', 'mos_greviews');
	add_settings_section('mos_greviews_section_dash_start', '', 'mos_greviews_section_dash_start_cb', 'mos_greviews');
	add_settings_section('mos_greviews_section_dash_end', '', 'mos_greviews_section_end_cb', 'mos_greviews');
	
	add_settings_section('mos_greviews_section_scripts_start', '', 'mos_greviews_section_scripts_start_cb', 'mos_greviews');
	add_settings_field( 'field_jquery', __( 'JQuery', 'mos_greviews' ), 'mos_greviews_field_jquery_cb', 'mos_greviews', 'mos_greviews_section_scripts_start', [ 'label_for' => 'jquery', 'class' => 'mos_greviews_row', 'mos_greviews_custom_data' => 'custom', ] );
	add_settings_field( 'field_owlcarousel', __( 'Owl Carousel', 'mos_greviews' ), 'mos_greviews_field_owlcarousel_cb', 'mos_greviews', 'mos_greviews_section_scripts_start', [ 'label_for' => 'owlcarousel', 'class' => 'mos_greviews_row', 'mos_greviews_custom_data' => 'custom', ] );
	add_settings_field( 'field_css', __( 'Custom Css', 'mos_greviews' ), 'mos_greviews_field_css_cb', 'mos_greviews', 'mos_greviews_section_scripts_start', [ 'label_for' => 'mos_greviews_css' ] );
	add_settings_field( 'field_js', __( 'Custom Js', 'mos_greviews' ), 'mos_greviews_field_js_cb', 'mos_greviews', 'mos_greviews_section_scripts_start', [ 'label_for' => 'mos_greviews_js' ] );
	add_settings_section('mos_greviews_section_scripts_end', '', 'mos_greviews_section_end_cb', 'mos_greviews');

}
add_action( 'admin_init', 'mos_greviews_settings_init' );

function get_mos_greviews_active_tab () {
	$output = array(
		'option_prefix' => admin_url() . "/options-general.php?page=mos_greviews_settings&tab=",
		//'option_prefix' => "?post_type=p_file&page=mos_greviews_settings&tab=",
	);
	if (isset($_GET['tab'])) $active_tab = $_GET['tab'];
	elseif (isset($_COOKIE['plugin_active_tab'])) $active_tab = $_COOKIE['plugin_active_tab'];
	else $active_tab = 'dashboard';
	$output['active_tab'] = $active_tab;
	return $output;
}
function mos_greviews_section_top_nav_cb( $args ) {
	$data = get_mos_greviews_active_tab ();
	?>
    <ul class="nav nav-tabs">
        <li class="tab-nav <?php if($data['active_tab'] == 'dashboard') echo 'active';?>"><a data-id="dashboard" href="<?php echo $data['option_prefix'];?>dashboard">Dashboard</a></li>
        <li class="tab-nav <?php if($data['active_tab'] == 'scripts') echo 'active';?>"><a data-id="scripts" href="<?php echo $data['option_prefix'];?>scripts">Advanced CSS, JS</a></li>
    </ul>
	<?php
}
function mos_greviews_section_dash_start_cb( $args ) {
	$data = get_mos_greviews_active_tab ();
    $options = get_option( 'mos_greviews_options' );
	?>
	<div id="mos-greviews-dashboard" class="tab-con <?php if($data['active_tab'] == 'dashboard') echo 'active';?>">
		<?php // var_dump($options) ?>
		<h3>How to Find the CID Number of a Google My Business Listing</h3>
		<p>Please visit this link <a href="https://www.sterlingsky.ca/how-to-find-the-cid-number-on-google-maps/" target="_blank">https://www.sterlingsky.ca/how-to-find-the-cid-number-on-google-maps/</a></p>
	<?php
}
function mos_greviews_section_scripts_start_cb( $args ) {
	$data = get_mos_greviews_active_tab ();
	?>
	<div id="mos-greviews-scripts" class="tab-con <?php if($data['active_tab'] == 'scripts') echo 'active';?>">
	<?php
}
function mos_greviews_field_jquery_cb( $args ) {
	$options = get_option( 'mos_greviews_options' );
	?>
	<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_greviews_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to add JQuery from Plugin.', 'mos_greviews' ); ?></label>
	<?php
}
function mos_greviews_field_owlcarousel_cb( $args ) {
	$options = get_option( 'mos_greviews_options' );
	?>
	<label for="<?php echo esc_attr( $args['label_for'] ); ?>"><input name="mos_greviews_options[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>><?php esc_html_e( 'Yes I like to add Owl Caarousel from Plugin.', 'mos_greviews' ); ?></label>
	<?php
}
function mos_greviews_field_css_cb( $args ) {
	$options = get_option( 'mos_greviews_options' );
	?>
	<textarea name="mos_greviews_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>" rows="10" class="regular-text"><?php echo isset( $options[ $args['label_for'] ] ) ? esc_html_e($options[$args['label_for']]) : '';?></textarea>
	<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("mos_greviews_css"), {
      lineNumbers: true,
      mode: "text/css",
      extraKeys: {"Ctrl-Space": "autocomplete"}
    });
	</script>
	<?php
}
function mos_greviews_field_js_cb( $args ) {
	$options = get_option( 'mos_greviews_options' );
	?>
	<textarea name="mos_greviews_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>" rows="10" class="regular-text"><?php echo isset( $options[ $args['label_for'] ] ) ? esc_html_e($options[$args['label_for']]) : '';?></textarea>
	<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("mos_greviews_js"), {
      lineNumbers: true,
      mode: "text/css",
      extraKeys: {"Ctrl-Space": "autocomplete"}
    });
	</script>
	<?php
}
function mos_greviews_section_end_cb( $args ) {
	$data = get_mos_greviews_active_tab ();
	?>
	</div>
	<?php
}


function mos_greviews_options_page() {
	//add_menu_page( 'WPOrg', 'WPOrg Options', 'manage_options', 'mos_greviews', 'mos_greviews_options_page_html' );
	add_submenu_page( 'options-general.php', 'Review Settings', 'Review Settings', 'manage_options', 'mos_greviews_settings', 'mos_greviews_admin_page' );
}
add_action( 'admin_menu', 'mos_greviews_options_page' );

function mos_greviews_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'mos_greviews_messages', 'mos_greviews_message', __( 'Settings Saved', 'mos_greviews' ), 'updated' );
	}
	settings_errors( 'mos_greviews_messages' );
	?>
	<div class="wrap mos-greviews-wrapper">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
		<?php
		settings_fields( 'mos_greviews' );
		do_settings_sections( 'mos_greviews' );
		submit_button( 'Save Settings' );
		?>
		</form>
	</div>
	<?php
}