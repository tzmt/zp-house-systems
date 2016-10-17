<?php
/**
 * Test that planets in conjunction to the next house cusp are calculated correctly
 */
class Test_HS_Chart extends WP_UnitTestCase {

	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	
	}

	/**
	 * Test the ephemeris output for special points for all house systems
	 */
	public function test_ephemeris_special_points() {

		include dirname( __FILE__ ) . '/helper-expected-chart.php';
		
		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Set the default house system
			global $zodiacpress_options;
			$zodiacpress_options = get_option( 'zodiacpress_settings' );
			$zodiacpress_options['house_system'] = $h_sys;
			update_option('zodiacpress_settings', $zodiacpress_options);

			// get the charts with this house system
			$charts = ZP_HS_Helper::create_charts( 'birthreport' );

			foreach ( $charts as $person => $chart ) {

				// Test the Vertex
				$expected_v	= round( $this->expected_planets_longitude[ $person ][28], 5 );
				$actual_v	= round( $chart->planets_longitude[14], 5 );
				$this->assertEquals( $expected_v, $actual_v, 'Wrong Vertex for Person ' . $person . ', House system ' . $h_sys );

				// Test the Ascendant
				$expected_a	= round( $this->expected_planets_longitude[ $person ][25], 5 );
				$actual_a	= round( $chart->planets_longitude[15], 5 );
				$this->assertEquals( $expected_a, $actual_a, 'Wrong Ascendant for Person ' . $person . ', House system ' . $h_sys );

				// Test the MC
				$expected_mc	= round( $this->expected_planets_longitude[ $person ][26], 5 );
				$actual_mc		= round( $chart->planets_longitude[16], 5 );
				$this->assertEquals( $expected_mc, $actual_mc, 'Wrong MC for Person ' . $person . ', House system ' . $h_sys );
			}
		}

	}

	/**
	 * Test the Part of Fortune calculation for all house systems
	 */
	public function test_pof() {

		$sec = chr(34);

		$expected_pof = array(
			'20&#176; <span class="zp-icon-leo"> </span> 17\' 37' . $sec,// Steve Jobs
			'&#160;1&#176; <span class="zp-icon-virgo"> </span> 20\' 46' . $sec,// Michael Jackson
		);

		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Set the default house system
			global $zodiacpress_options;
			$zodiacpress_options = get_option( 'zodiacpress_settings' );
			$zodiacpress_options['house_system'] = $h_sys;
			update_option('zodiacpress_settings', $zodiacpress_options);

			// get the charts with this house system
			$charts = ZP_HS_Helper::create_charts( 'birthreport' );

			foreach ( $charts as $person => $chart ) {
				$actual = zp_get_zodiac_sign_dms( $chart->planets_longitude[13] );
				$this->assertEquals( $expected_pof[ $person ], $actual, 'Wrong Part of Fortune for Person ' . $person . ', House system ' . $h_sys );
			}
		}

	}
}
