<?php
class Test_Cusps extends WP_UnitTestCase {

	protected $charts;
	protected $expected_cusps = array();

	public function setUp() {
	
		$charts = ZP_HS_Helper::create_charts( 'house_systems' );

		unset( $charts[1] );// unset MJ
		$this->charts = $charts;		

		/**
		 * Set up expected cusps for all charts
		 */

		$sec = chr(34);

		// Expected cusps for Steve Jobs
		$this->expected_cusps[] = array(
			'B' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,// astro.com gets 39
				2 => '23&#176; <span class="zp-icon-libra"> </span> 54\' 28' . $sec,// astro gets 30
				3 => '23&#176; <span class="zp-icon-scorpio"> </span> 43\' 25' . $sec,// astro gets 26
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '19&#176; <span class="zp-icon-capricorn"> </span> 43\' 12' . $sec,// astro gets 13
				6 => '19&#176; <span class="zp-icon-aquarius"> </span> 42\' 59' . $sec,// astro gets 43'02
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '23&#176; <span class="zp-icon-aries"> </span> 54\' 28' . $sec,
				9 => '23&#176; <span class="zp-icon-taurus"> </span> 43\' 25' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '19&#176; <span class="zp-icon-cancer"> </span> 43\' 12' . $sec,
				12 => '19&#176; <span class="zp-icon-leo"> </span> 42\' 59' . $sec
				),
			'C' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,// astro.com gets 39
				2 => '22&#176; <span class="zp-icon-libra"> </span> 48\' 00' . $sec,// astro gets 10
				3 => '22&#176; <span class="zp-icon-scorpio"> </span> 18\' 17' . $sec,// astro gets 25
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '20&#176; <span class="zp-icon-capricorn"> </span> 47\' 46' . $sec,// astro gets 40
				6 => '21&#176; <span class="zp-icon-aquarius"> </span> 16\' 31' . $sec,// astro gets 28
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '22&#176; <span class="zp-icon-aries"> </span> 48\' 00' . $sec,
				9 => '22&#176; <span class="zp-icon-taurus"> </span> 18\' 17' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '20&#176; <span class="zp-icon-cancer"> </span> 47\' 46' . $sec,
				12 => '21&#176; <span class="zp-icon-leo"> </span> 16\' 31' . $sec,
				),
			'E' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '22&#176; <span class="zp-icon-libra"> </span> 17\' 34' . $sec,
				3 => '22&#176; <span class="zp-icon-scorpio"> </span> 17\' 34' . $sec,
				4 => '22&#176; <span class="zp-icon-sagittarius"> </span> 17\' 34' . $sec,
				5 => '22&#176; <span class="zp-icon-capricorn"> </span> 17\' 34' . $sec,
				6 => '22&#176; <span class="zp-icon-aquarius"> </span> 17\' 34' . $sec,
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '22&#176; <span class="zp-icon-aries"> </span> 17\' 34' . $sec,
				9 => '22&#176; <span class="zp-icon-taurus"> </span> 17\' 34' . $sec,
				10 => '22&#176; <span class="zp-icon-gemini"> </span> 17\' 34' . $sec,
				11 => '22&#176; <span class="zp-icon-cancer"> </span> 17\' 34' . $sec,
				12 => '22&#176; <span class="zp-icon-leo"> </span> 17\' 34' . $sec,
				),
			'K' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '21&#176; <span class="zp-icon-libra"> </span> 57\' 56' . $sec,
				3 => '21&#176; <span class="zp-icon-scorpio"> </span> 14\' 17' . $sec,// astro gets 15
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '23&#176; <span class="zp-icon-capricorn"> </span> 28\' 10' . $sec,// astro gets 19
				6 => '22&#176; <span class="zp-icon-aquarius"> </span> 48\' 58' . $sec,// astro gets 49' 06"
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '21&#176; <span class="zp-icon-aries"> </span> 57\' 56' . $sec,
				9 => '21&#176; <span class="zp-icon-taurus"> </span> 14\' 17' . $sec,// astro gets 15
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '23&#176; <span class="zp-icon-cancer"> </span> 28\' 10' . $sec,
				12 => '22&#176; <span class="zp-icon-leo"> </span> 48\' 58' . $sec,

				),
			'X' => array(
				1 => '19&#176; <span class="zp-icon-virgo"> </span> 43\' 01' . $sec,
				2 => '22&#176; <span class="zp-icon-libra"> </span> 13\' 32' . $sec,
				3 => '22&#176; <span class="zp-icon-scorpio"> </span> 56\' 58' . $sec,
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '18&#176; <span class="zp-icon-capricorn"> </span> 58\' 46' . $sec,
				6 => '18&#176; <span class="zp-icon-aquarius"> </span> 06\' 37' . $sec,
				7 => '19&#176; <span class="zp-icon-pisces"> </span> 43\' 01' . $sec,
				8 => '22&#176; <span class="zp-icon-aries"> </span> 13\' 32' . $sec,
				9 => '22&#176; <span class="zp-icon-taurus"> </span> 56\' 58' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '18&#176; <span class="zp-icon-cancer"> </span> 58\' 46' . $sec,
				12 => '18&#176; <span class="zp-icon-leo"> </span> 06\' 37' . $sec,
				),

			'M' => array(
				1 => '21&#176; <span class="zp-icon-virgo"> </span> 19\' 03' . $sec,
				2 => '18&#176; <span class="zp-icon-libra"> </span> 58\' 46' . $sec,
				3 => '18&#176; <span class="zp-icon-scorpio"> </span> 06\' 37' . $sec,
				4 => '19&#176; <span class="zp-icon-sagittarius"> </span> 43\' 01' . $sec,
				5 => '22&#176; <span class="zp-icon-capricorn"> </span> 13\' 32' . $sec,
				6 => '22&#176; <span class="zp-icon-aquarius"> </span> 56\' 58' . $sec,
				7 => '21&#176; <span class="zp-icon-pisces"> </span> 19\' 03' . $sec,
				8 => '18&#176; <span class="zp-icon-aries"> </span> 58\' 46' . $sec,
				9 => '18&#176; <span class="zp-icon-taurus"> </span> 06\' 37' . $sec,
				10 => '19&#176; <span class="zp-icon-gemini"> </span> 43\' 01' . $sec,
				11 => '22&#176; <span class="zp-icon-cancer"> </span> 13\' 32' . $sec,
				12 => '22&#176; <span class="zp-icon-leo"> </span> 56\' 58' . $sec,
				),
			'P' => array(

				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,// astro.com gets 39
				2 => '18&#176; <span class="zp-icon-libra"> </span> 14\' 46' . $sec,// astro.com gets 39
				3 => '18&#176; <span class="zp-icon-scorpio"> </span> 21\' 25' . $sec,// astro.com gets 16
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '24&#176; <span class="zp-icon-capricorn"> </span> 28\' 29' . $sec,
				6 => '25&#176; <span class="zp-icon-aquarius"> </span> 12\' 35' . $sec,
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '18&#176; <span class="zp-icon-aries"> </span> 14\' 46' . $sec,
				9 => '18&#176; <span class="zp-icon-taurus"> </span> 21\' 25' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '24&#176; <span class="zp-icon-cancer"> </span> 28\' 29' . $sec,
				12 => '25&#176; <span class="zp-icon-leo"> </span> 12\' 35' . $sec,

				),
			'O' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '21&#176; <span class="zp-icon-libra"> </span> 58\' 04' . $sec,// astro gets 7
				3 => '21&#176; <span class="zp-icon-scorpio"> </span> 38\' 34' . $sec,// astro gets 35
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '21&#176; <span class="zp-icon-capricorn"> </span> 38\' 34' . $sec,// astro gets 35
				6 => '21&#176; <span class="zp-icon-aquarius"> </span> 58\' 04' . $sec,// astro gets 7
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '21&#176; <span class="zp-icon-aries"> </span> 58\' 04' . $sec,
				9 => '21&#176; <span class="zp-icon-taurus"> </span> 38\' 34' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '21&#176; <span class="zp-icon-cancer"> </span> 38\' 34' . $sec,
				12 => '21&#176; <span class="zp-icon-leo"> </span> 58\' 04' . $sec,


				),
			'R' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '17&#176; <span class="zp-icon-libra"> </span> 18\' 51' . $sec,// astro gets 43
				3 => '16&#176; <span class="zp-icon-scorpio"> </span> 19\' 57' . $sec,// astro gets 44
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '26&#176; <span class="zp-icon-capricorn"> </span> 57\' 16' . $sec,// astro gets 33
				6 => '26&#176; <span class="zp-icon-aquarius"> </span> 55\' 05' . $sec,// astro gets 20
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '17&#176; <span class="zp-icon-aries"> </span> 18\' 51' . $sec,
				9 => '16&#176; <span class="zp-icon-taurus"> </span> 19\' 57' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '26&#176; <span class="zp-icon-cancer"> </span> 57\' 16' . $sec,
				12 => '26&#176; <span class="zp-icon-leo"> </span> 55\' 05' . $sec,
				),
			'T' => array(
				1 => '22&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '18&#176; <span class="zp-icon-libra"> </span> 14\' 57' . $sec,// astro gets 50
				3 => '18&#176; <span class="zp-icon-scorpio"> </span> 23\' 41' . $sec,// astro gets 32
				4 => '21&#176; <span class="zp-icon-sagittarius"> </span> 19\' 03' . $sec,
				5 => '24&#176; <span class="zp-icon-capricorn"> </span> 24\' 07' . $sec,// astro gets 18
				6 => '25&#176; <span class="zp-icon-aquarius"> </span> 11\' 28' . $sec,// astro gets 41
				7 => '22&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '18&#176; <span class="zp-icon-aries"> </span> 14\' 57' . $sec,
				9 => '18&#176; <span class="zp-icon-taurus"> </span> 23\' 41' . $sec,
				10 => '21&#176; <span class="zp-icon-gemini"> </span> 19\' 03' . $sec,
				11 => '24&#176; <span class="zp-icon-cancer"> </span> 24\' 07' . $sec,
				12 => '25&#176; <span class="zp-icon-leo"> </span> 11\' 28' . $sec,

				),
			'V' => array(
				1 => '&#160;7&#176; <span class="zp-icon-virgo"> </span> 17\' 34' . $sec,
				2 => '&#160;7&#176; <span class="zp-icon-libra"> </span> 17\' 34' . $sec,
				3 => '&#160;7&#176; <span class="zp-icon-scorpio"> </span> 17\' 34' . $sec,
				4 => '&#160;7&#176; <span class="zp-icon-sagittarius"> </span> 17\' 34' . $sec,
				5 => '&#160;7&#176; <span class="zp-icon-capricorn"> </span> 17\' 34' . $sec,
				6 => '&#160;7&#176; <span class="zp-icon-aquarius"> </span> 17\' 34' . $sec,
				7 => '&#160;7&#176; <span class="zp-icon-pisces"> </span> 17\' 34' . $sec,
				8 => '&#160;7&#176; <span class="zp-icon-aries"> </span> 17\' 34' . $sec,
				9 => '&#160;7&#176; <span class="zp-icon-taurus"> </span> 17\' 34' . $sec,
				10 => '&#160;7&#176; <span class="zp-icon-gemini"> </span> 17\' 34' . $sec,
				11 => '&#160;7&#176; <span class="zp-icon-cancer"> </span> 17\' 34' . $sec,
				12 => '&#160;7&#176; <span class="zp-icon-leo"> </span> 17\' 34' . $sec,

				),
			'W' => array(
				1 => '&#160;0&#176; <span class="zp-icon-virgo"> </span> 00\' 00' . $sec,
				2 => '&#160;0&#176; <span class="zp-icon-libra"> </span> 00\' 00' . $sec,
				3 => '&#160;0&#176; <span class="zp-icon-scorpio"> </span> 00\' 00' . $sec,
				4 => '&#160;0&#176; <span class="zp-icon-sagittarius"> </span> 00\' 00' . $sec,
				5 => '&#160;0&#176; <span class="zp-icon-capricorn"> </span> 00\' 00' . $sec,
				6 => '&#160;0&#176; <span class="zp-icon-aquarius"> </span> 00\' 00' . $sec,
				7 => '&#160;0&#176; <span class="zp-icon-pisces"> </span> 00\' 00' . $sec,
				8 => '&#160;0&#176; <span class="zp-icon-aries"> </span> 00\' 00' . $sec,
				9 => '&#160;0&#176; <span class="zp-icon-taurus"> </span> 00\' 00' . $sec,
				10 => '&#160;0&#176; <span class="zp-icon-gemini"> </span> 00\' 00' . $sec,
				11 => '&#160;0&#176; <span class="zp-icon-cancer"> </span> 00\' 00' . $sec,
				12 => '&#160;0&#176; <span class="zp-icon-leo"> </span> 00\' 00' . $sec,
				)
		);
	}

	public function test_if_exec_enabled() {
		$this->assertTrue( zp_is_func_enabled( 'exec' ) );
	
	}

	public function test_alcabitius_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual	= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['B'][ $i ] );
				$expected = $this->expected_cusps[ $user ]['B'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_campanus_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['C'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['C'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_equal_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['E'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['E'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_koch_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['K'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['K'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_meridian_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['X'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['X'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_morinus_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['M'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['M'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}

		}

	}

	public function test_placidus_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['P'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['P'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_porphyry_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['O'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['O'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}	

	public function test_regiomontanus_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['R'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['R'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}	

	public function test_topocentric_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['T'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['T'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_vehlow_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['V'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['V'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}

	public function test_whole_sign_cusps() {
		foreach ( $this->charts as $user => $chart ) {
			// Get calculated house cusps
			$zp_hs = zp_house_systems();		
			$zp_hs->setup_house_properties( $chart );			
			$property = ZP_HS_Helper::get_private_property( 'ZP_House_Systems', 'cusps' );
			$calculated_cusps[ $user ] = $property->getValue( $zp_hs );
			for ( $i = 1; $i <= 12; $i++ ) {
				$actual		= zp_get_zodiac_sign_dms( $calculated_cusps[ $user ]['W'][ $i ] );
				$expected	= $this->expected_cusps[ $user ]['W'][ $i ];
				$this->assertEquals( $expected, $actual, 'for chart ' . $user . ', cusp ' . $i );
			}
		}
	}
}