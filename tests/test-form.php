<?php
class Test_Form extends WP_UnitTestCase {

	/**
	 * Test form validation for the House Systems report
	 */
	public function test_form_validation() {

		// Form should not validate with blank time
		$person_blank_birth_time = array(
				'name'					=> 'Steve Jobs',
				'month'					=> '2',
				'day'					=> '24',
				'year'					=> '1955',
				'hour'					=> '',
				'minute'				=> '',
				'city'					=> 'San Francisco',
				'geo_timezone_id'		=> 'America/Los_Angeles',
				'place'					=> 'San Francisco, California, United States',
				'zp_lat_decimal'		=> '37.77493',
				'zp_long_decimal'		=> '-122.41942',
				'zp_offset_geo'			=> '-8',
				'action'				=> 'zp_birthreport',
				'zp-report-variation'	=> 'house_systems',
				'unknown_time'			=> '',
				'house_system'			=> false,
				'sidereal'				=> false
		);

		$val = zp_validate_form( $person_blank_birth_time );
		$this->assertInternalType('string', $val);

	}

	/**
	 * Unknown birth time checkbox should never appear on form for House Systems report.
	 */
	public function test_unknown_birth_time_checkbox() {

		$str = '<input type="checkbox" id="unknown_time" name="unknown_time"';

		// Make sure the setting to allow unkown birth times is disabled
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		unset( $zodiacpress_options['birthreport_allow_unknown_bt'] );
		update_option('zodiacpress_settings', $zodiacpress_options );

		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertFalse( strpos( $form, $str ), 'Error 1: House systems report form shows Unknown birth time checkbox.' );

		// Repeat test with the setting to allow unkown birth times ENABLED.
		global $zodiacpress_options;
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		$zodiacpress_options['birthreport_allow_unknown_bt'] = 1;
		update_option('zodiacpress_settings', $zodiacpress_options);

		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertFalse( strpos( $form, $str ), 'Error 2: House systems report form shows Unknown birth time checkbox.' );

	}

	/**
	  * 'Birth time required' should appear on form for House Systems report.
	  */
	public function test_birthtime_required() {

		$str = 'Birth time is required for this type of report';

		// Make sure the setting to allow unkown birth times is disabled
		global $zodiacpress_options;
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		unset( $zodiacpress_options['birthreport_allow_unknown_bt'] );
		update_option('zodiacpress_settings', $zodiacpress_options );

		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertContains( $str , $form, 'Error 3: House systems report form is missing the "Birth time is required" message.' );

		// Repeat test with the setting to allow unkown birth times ENABLED.

		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		$zodiacpress_options['birthreport_allow_unknown_bt'] = 1;
		update_option('zodiacpress_settings', $zodiacpress_options);

		// Test that the global setting was updated.
		$this->assertNotEmpty( $zodiacpress_options['birthreport_allow_unknown_bt'], 'Error 40: the birthreport_allow_unknown_bt is not enabled.' );


		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertContains( $str, $form, 'Error 4: House systems report form is missing the "Birth time is required" message.' );

	}

	/**
	  * The unkown birth time NOTE should never appear on form for House Systems report.
	  */
	public function test_unknown_birthtime_note() {

		$str = 'If birth time is unknown, the report will not include positions or aspects for the Moon';

		// Make sure the setting to allow unkown birth times is disabled
		global $zodiacpress_options;
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		unset( $zodiacpress_options['birthreport_allow_unknown_bt'] );
		update_option('zodiacpress_settings', $zodiacpress_options );

		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertFalse( strpos( $form, $str ), 'Error 5: House systems report form is showing the unkown birth time NOTE at bottom of form.' );

		// Repeat test with the setting to allow unkown birth times ENABLED.

		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		$zodiacpress_options['birthreport_allow_unknown_bt'] = 1;
		update_option('zodiacpress_settings', $zodiacpress_options);

		// Test that the global setting was updated.
		$this->assertNotEmpty( $zodiacpress_options['birthreport_allow_unknown_bt'], 'Error 60: the birthreport_allow_unknown_bt is not enabled.' );

		ob_start();
		zp_form( 'house_systems', array( 'report' => 'house_systems', 'house_system' => false, 'sidereal' => false ) );
		$form = ob_get_clean();

		$this->assertFalse( strpos( $form, $str ), 'Error 6: House systems report form is showing the unkown birth time NOTE at bottom of form.' );

	}	
}