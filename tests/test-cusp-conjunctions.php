<?php
class Test_Cusp_Conjunctions extends WP_UnitTestCase {
	
	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	
	}

	/**
 	 * Test conjunctions to the next house cusps
 	 */
	public function test_house_cusp_conjunctions() {

		$person	= ZP_HS_Helper::person_0( 'birthreport' );
 		$chart	= ZP_HS_Helper::get_chart( $person );

		// Expected conjunctions for Steve Jobs
		$expected_conjunctions = array(
			'B' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'C' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => 1,
				6 => 1,
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => 1,
				14 => '',
			),
			'E' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => 1,
				4 => '',
				5 => '',
				6 => 1,
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'K' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => 1,
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'X' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'M' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => 1,
				4 => '',
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'O' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => 1,
				4 => '',
				5 => 1,
				6 => 1,
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'R' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'T' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => 1,
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'V' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => 1,
			),
			'P' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => '',
				7 => 1,
				8 => '',
				9 => '',
				10 => '',
				11 => '',
				12 => '',
				13 => '',
				14 => '',
			),
			'W' => array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => 1,
				5 => '',
				6 => '',
				7 => '',
				8 => '',
				9 => '',
				10 => '',
				11 => 1,
				12 => '',
				13 => '',
				14 => '',
			)			
		);

		// Get conjunctions to house cusps
		$zp_hs = zp_house_systems();
		$zp_hs->setup_house_properties( $chart );			
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'conjunct_next_cusp' );
		$calculated_conjunctions = $property->getValue( $zp_hs );

		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Test the planets
			for ( $i = 0; $i <= 14; $i++ ) {
						
				$actual		= $calculated_conjunctions[ $h_sys ][ $i ];
				$expected	= $expected_conjunctions[ $h_sys ][ $i ];

				$this->assertEquals( $expected, $actual, 'Wrong for ' . $h_sys . ' houses, planet ' . $i );
			}
		}
		
	}

}