<?php
class Test_HS_Report extends WP_UnitTestCase {

	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	}
	
	/**
	 * When setting to 'Add Houses Comparison Tables to Birth Report' setting is disabled, Houses data tables should still display on the Compare House Systems Report, but not on the Birth Report.
	 */
	public function test_show_tables_when_disabled() {

		global $zodiacpress_options;
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		unset( $zodiacpress_options['zphs_add_to_report'] );
		update_option('zodiacpress_settings', $zodiacpress_options );

		$str = 'House Positions By House System';

		$report = ZP_HS_Helper::get_report( 'house_systems');
		$this->assertContains($str, $report, 'Compare House Systems report is missing house tables.' );

		$report = ZP_HS_Helper::get_report('birthreport');
		$this->assertFalse( strpos( $report, $str ), 'Birth report shows house data tables even though this is disabled in settings.' );

		// Repeat test with unknown birth time

		$report = ZP_HS_Helper::get_report_unknown_birth_time('birthreport');
		$this->assertFalse( strpos( $report, $str ), 'Birth report shows house data tables with UNKNOWN birth time, and even though Adding Tables is disabled.' );

	}

	/**
	 * Test that the house data tables are shown on the Birth Report when the setting to 'Add Houses Tables to Birth Report' setting is enabled.
	 */
	public function test_show_tables_when_enabled() {

		// Enable the setting
		global $zodiacpress_options;
		$zodiacpress_options = get_option( 'zodiacpress_settings' );
		$zodiacpress_options['zphs_add_to_report'] = 1;
		update_option('zodiacpress_settings', $zodiacpress_options);

		$str = 'House Positions By House System';

		$report = ZP_HS_Helper::get_report('birthreport');
		$this->assertContains( $str, $report, 'Birth report is missing house data tables even though this is ENABLED in settings.' );

		$report = ZP_HS_Helper::get_report( 'house_systems');
		$this->assertContains($str, $report, 'House systems report is missing the house tables.' );

		// Repeat tests with unknown birth time

		$report = ZP_HS_Helper::get_report_unknown_birth_time('birthreport');
		$this->assertFalse( strpos( $report, $str ), 'Birth report shows house data tables with UNKNOWN birth time, while the setting to Add House Tables to birth report is ENABLED.' );

	}
}
