<?php
class Test_Sidereal extends WP_UnitTestCase {

	protected $expected_sidereal_fagan_cusps = array();
	protected $expected_sidereal_lahiri_cusps = array();

	public function setUp() {
		// Expected Sidereal Fagan/Bradley house cusp longitudes for Steve Jobs
		$this->expected_sidereal_fagan_cusps = array(
			// Placidus
			'P' => array(
				148.1722231,
				174.1238029,
				204.2341549,
				237.1960811,
				270.3549344,
				301.0900105,
				328.1722231,
				354.1238029,
				24.2341549,
				57.1960811,
				90.3549344,
				121.0900105
			),
			// Whole Sign Houses
			'W' => array(
				120.0000000,
				150.0000000,
				180.0000000,
				210.0000000,
				240.0000000,
				270.0000000,
				300.0000000,
				330.0000000,
				0.0000000,
				30.0000000,
				60.0000000,
				90.0000000
			)				
		);
		// Expected Sidereal Hindu/Lahiri house cusp longitudes for Steve Jobs
		$this->expected_sidereal_lahiri_cusps = array(
			'P' => array(
					149.0555808,
					175.0071606,
					205.1175126,
					238.0794388,
					271.2382921,
					301.9733682,
					329.0555808,
					355.0071606,
					25.1175126,
					58.0794388,
					91.2382921,
					121.9733682
				)
		);
	}

	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	}

	public function test_sidereal_fagan_placidus_cusps() {
		// Get calculated house cusps
		$zp_hs = zp_house_systems();
 		$person	= ZP_HS_Helper::person_0( 'house_systems', 'fagan/bradley' );
 		$chart	= ZP_HS_Helper::get_chart( $person );
		$zp_hs->setup_house_properties( $chart );
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
		$calculated_cusps = $property->getValue( $zp_hs );
		for ( $i = 1; $i <= 12; $i++ ) {
			$actual		= round( (int) $calculated_cusps['P'][ $i ] );
			$expected	= round( (int) $this->expected_sidereal_fagan_cusps['P'][ $i - 1 ] );
			$this->assertEquals( $expected, $actual, 'wrong cusp ' . $i );
		}

	}

	public function test_sidereal_fagan_whole_sign_cusps() {

		// Get calculated house cusps
		$zp_hs = zp_house_systems();
 		$person	= ZP_HS_Helper::person_0( 'house_systems', 'fagan/bradley' );
 		$chart	= ZP_HS_Helper::get_chart( $person );
		$zp_hs->setup_house_properties( $chart );
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
		$calculated_cusps = $property->getValue( $zp_hs );
		for ( $i = 1; $i <= 12; $i++ ) {
			$actual		= round( (int) $calculated_cusps['W'][ $i ] );
			$expected	= round( (int) $this->expected_sidereal_fagan_cusps['W'][ $i - 1 ] );
			$this->assertEquals( $expected, $actual, 'wrong cusp ' . $i );
		}
	}

	public function test_sidereal_lahiri_placidus_cusps() {
		// Get calculated house cusps
		$zp_hs = zp_house_systems();
 		$person	= ZP_HS_Helper::person_0( 'house_systems', 'lahiri' );
 		$chart	= ZP_HS_Helper::get_chart( $person );
		$zp_hs->setup_house_properties( $chart );
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
		$calculated_cusps = $property->getValue( $zp_hs );
		for ( $i = 1; $i <= 12; $i++ ) {
			$actual		= round( (int) $calculated_cusps['P'][ $i ] );
			$expected	= round( (int) $this->expected_sidereal_lahiri_cusps['P'][ $i - 1 ] );
			$this->assertEquals( $expected, $actual, 'wrong cusp ' . $i );
		}
	}
}