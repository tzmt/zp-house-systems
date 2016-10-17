<?php
class Test_House_Positions extends WP_UnitTestCase {

	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	}
	
	/**
	 * Test house position numbers of planets/points excluding ASC & MC in all house systems
	 */
	public function test_house_position_numbers_regular() {

		$person	= ZP_HS_Helper::person_0( 'birthreport' );// Steve Jobs
		$chart	= ZP_HS_Helper::get_chart( $person );

		// Expected house positions for Steve Jobs
		$expected_h_pos = array(
				'B' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 5,
					'4' => 8,
					'5' => 11,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 12,
					'14' => 6,
					),
				'C' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 5,
					'4' => 8,
					'5' => 10,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'E' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'K' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'X' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 5,
					'4' => 8,
					'5' => 11,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 12,
					'14' => 6,
					),
				'M' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 3,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'O' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 2,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'R' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 3,
					'7' => 10,
					'8' => 2,
					'9' => 11,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'T' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 3,
					'7' => 10,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6,
					),
				'V' => array(
					'0' => 6,
					'1' => 8,
					'2' => 6,
					'3' => 5,
					'4' => 8,
					'5' => 11,
					'6' => 3,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 12,
					'14' => 6,
					),
				'W' => array(
					'0' => 7,
					'1' => 8,
					'2' => 6,
					'3' => 5,
					'4' => 8,
					'5' => 11,
					'6' => 3,
					'7' => 11,
					'8' => 2,
					'9' => 12,
					'10' => 6,
					'11' => 3,
					'12' => 5,
					'13' => 12,
					'14' => 7,
					),
				'P' => array(
					'0' => 6,
					'1' => 7,
					'2' => 5,
					'3' => 4,
					'4' => 8,
					'5' => 10,
					'6' => 3,
					'7' => 10,
					'8' => 2,
					'9' => 12,
					'10' => 5,
					'11' => 3,
					'12' => 4,
					'13' => 11,
					'14' => 6
				)
		);
		
		// Get house positions

		$zp_hs = zp_house_systems();
		$zp_hs->setup_house_properties( $chart );			
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'planets_house_num' );
		$calculated_h_pos = $property->getValue( $zp_hs );
		
		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Test the planets
			for ( $i = 0; $i <= 14; $i++ ) {
				$actual	= $calculated_h_pos[ $h_sys ][ $i ];
				$expected = $expected_h_pos[ $h_sys ][ $i ];
				$this->assertEquals( $expected, $actual, $h_sys . ' houses, planet ' . $i );

			}
		}
	}

	/**
	 * Test house position numbers of ASC & MC in house systems that do not align with them
	 */
	public function test_house_position_numbers_asc_mc() {

		$person	= ZP_HS_Helper::person_1( 'house_systems' );// Michael Jackson
		$chart	= ZP_HS_Helper::get_chart( $person );

		$expected_h_pos = array(
				'X' => array(
					'15' => 12
					),
				'M' => array(
					'15' => 12,
					'16' => 10
					),
				'V' => array(
					'15' => 1,
					'16' => 10
					),
				'W' => array(
					'15' => 1,
					'16' => 10
					),									
				'E' => array(
					'16' => 10
					)
				);

		// Get house positions

		$zp_hs = zp_house_systems();
		$zp_hs->setup_house_properties( $chart );			
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'planets_house_num' );
		$calculated_h_pos = $property->getValue( $zp_hs );

		// Test that house positions are only set for house systems that do not align with ASC and/or MC

		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Check for ASC
			$h_sys_for_asc = array( 'X', 'M', 'V', 'W' );
			if ( in_array( $h_sys, $h_sys_for_asc ) ) {
				// ASC [15] should be set
				$expected	= $expected_h_pos[ $h_sys ][15];
				$actual		= $calculated_h_pos[ $h_sys ][15];

				$this->assertEquals( $expected, $actual, 'Wrong or missing ASCENDANT for ' . $label . ' houses' );
			}

			// Check for MC
			$h_sys_for_mc =  array( 'E', 'M', 'V', 'W' );
			if ( in_array( $h_sys, $h_sys_for_mc ) ) {

				// MC [16] should be set
				$expected	= $expected_h_pos[ $h_sys ][16];
				$actual		= $calculated_h_pos[ $h_sys ][16];

				$this->assertEquals( $expected, $actual, 'Wrong or missing MIDHEAVEN for ' . $label . ' houses' );
			}

		}
	}

	/**
	 * Test that house systems that align with ASC and MC do not give house position numbers of ASC & MC.
	 */
	public function test_house_position_numbers_no_asc_mc() {
	
		$person	= ZP_HS_Helper::person_1( 'house_systems' );// Michael Jackson
		$chart	= ZP_HS_Helper::get_chart( $person );

		// Get house positions

		$zp_hs = zp_house_systems();
		$zp_hs->setup_house_properties( $chart );			
		$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'planets_house_num' );
		$calculated_h_pos = $property->getValue( $zp_hs );

		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Check for ASC
			$h_sys_for_asc = array( 'X', 'M', 'V', 'W' );
			if ( ! in_array( $h_sys, $h_sys_for_asc ) ) {

				// ASC [15] should not be set
				$this->assertArrayNotHasKey( 15, $calculated_h_pos[ $h_sys ], 'Ascendant position should not be set for ' . $label . ' houses.' );


			}

			// Check for MC
			$h_sys_for_mc =  array( 'E', 'M', 'V', 'W' );
			if ( ! in_array( $h_sys, $h_sys_for_mc ) ) {

				// MC [16] should not be set
				$this->assertArrayNotHasKey( 16, $calculated_h_pos[ $h_sys ], 'MIDHEAVEN position should not be set for ' . $label . ' houses.' );
			
			}
		}
	}
}