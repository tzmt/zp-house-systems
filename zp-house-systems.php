<?php
/**
Plugin Name: ZodiacPress House Systems
Plugin URI:	https://cosmicplugins.com/downloads/zodiacpress-house-systems/
Description: Set a desired house system for the ZodiacPress Birth Report. Also lets you add House Comparisons to the Birth Report to compare birth planets in multiple house systems.
Version: 1.2.1.alpha12190524
Author:	Isabel Castillo
Author URI:	http://isabelcastillo.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zp-house-systems
Domain Path: languages

Copyright 2106 Isabel Castillo

ZodiacPress House Systems is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

ZodiacPress House Systems is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with ZodiacPress House Systems. If not, see <http://www.gnu.org/licenses/>.
*/

if ( class_exists( 'ZP_License' ) && is_admin() ) {
	$zp_hs_license = new ZP_License( __FILE__, 'ZodiacPress House Systems', '1.2', 'Isabel Castillo' );// @todo update v
}

class ZP_House_Systems {

	/**
	 * The chart's house cusps for all house systems.
	 *
	 * @var array
	 */
	private $cusps = array();

	/**
	 *  Planets list showing whether each planet is conjunct the next house cusp, for all house systems.
	 *
	 * @var array
	 */
	private $conjunct_next_cusp = array();

	/**
	 * The house position number of the planets and points, for all house systems.
	 *
	 * @var array
	 */
	private $planets_house_num = array();

	/**
	 * @var ZP_House_Systems The one true ZP_House_Systems
	 */
	private static $instance;

	private function __construct() {
		// do nothing if ZP is not activated
		if ( ! class_exists( 'ZodiacPress', false ) ) {
				return;
		}
		add_action( 'init', array( $this, 'languages' ) );
		add_filter( 'zp_default_house_system', array( $this, 'default_house_system' ) );
		add_filter( 'zp_settings_natal', array( $this, 'settings' ) );
		add_action( 'zp_setup_chart', array( $this, 'setup_house_properties' ) );
		add_filter( 'zp_report_aspects', array( $this, 'insert_tables' ), 10, 3 );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'zp_shortcode_default_form_title', array( $this, 'form_title' ), 10, 2 );
		add_filter( 'zp_reports_require_birthtime', array( $this, 'require_birth_time' ) );
		add_filter( 'zp_report_header_houses', array( $this, 'omit_houses_on_h_sys_report' ), 10, 2 );
		add_filter( 'zp_house_systems_report', array( $this, 'get_house_data_tables' ), 20, 3 );
	}

   /**
	 * Main ZP_House_Systems Instance
	 *
	 * Insures that only one instance of ZP_House_Systems exists in memory at any one
	 * time.
	 *
	 * @static
	 * @staticvar array $instance
	 */
	public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ZP_House_Systems ) ) {
					self::$instance = new ZP_House_Systems;
			}
			return self::$instance;
	}

	/**
	 * Load plugin language files
	 *
	 * @access public
	 * @return void
	 */
	public function languages() {
		load_plugin_textdomain( 'zp-house-systems', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Set the default house system for the Birth Report
	 */
	public function default_house_system( $h_sys ) {
		$zp_options = get_option( 'zodiacpress_settings' );
		$h_sys = ( ! empty( $zp_options['house_system'] ) ) ? $zp_options['house_system'] : 'P';
		return $h_sys;
	}

	/**
	 * Get the Compare House System data tables.
	 */
	public function get_house_data_tables( $default, $form, $chart ) {
		if ( empty( $form['unknown_time'] ) ) {

			$out = '';
		
			// Section title only for birth report, not House Comparison report
			if ( 'birthreport' == $form['zp-report-variation'] ) {
				$out .= '<h3 class="zp-report-section-title">' . apply_filters( 'zphs_house_tables_section_title', __( 'Compare House Systems', 'zp-house-systems' ) ) . '</h3>';

			}
			
			$out .= wp_kses_post( $this->house_positions_table( $form ) );
			$out .= wp_kses_post( $this->cusps_table( $form ) );
			return $out;
		}

		return false;
	}

	/**
	 * Insert data tables after the Aspects section of Birth Report, if enabled.
	 */
	public function insert_tables( $default, $form, $chart ) {
		$zp_options = get_option( 'zodiacpress_settings' );

		if ( $form['unknown_time'] || empty( $zp_options['zphs_add_to_report'] ) ) {
			return $default;
		}

		return $default . $this->get_house_data_tables( $default, $form, $chart );
	}

	/**
	 * Set all the properties for all house systems.
	 */
	public function setup_house_properties( $chart ) {
		if ( empty( $chart ) ) {
			return;
		}
		// Args for the ephemeris query
		$args = array(
			'format'		=> 'l',
			'latitude'		=> $chart->latitude,
			'longitude'		=> $chart->longitude,
			'ut_date'		=> $chart->ut_date,
			'ut_time'		=> $chart->ut_time
		);

		// If they want sidereal, set the sidereal flag for the ephemeris query
		if ( $chart->sidereal ) {
			$args['options'] = '-sid' . zp_get_sidereal_methods()[ $chart->sidereal ]['id'];
		}

		$planets = zp_get_planets( true );// planets that support house positions

		// Get cusps for each house system
		foreach ( zp_get_house_systems() as $h_sys => $label ) {

			// Don't query ephemeris for Whole Sign houses since it gives wrong calculations.
			// Grab the ASC and manually calculate these.

			if ( 'W' == $h_sys ) {
				$ascendant			= $chart->planets_longitude[15];
				$whole_sign_house_1	= floor( $ascendant / 30 ) * 30;

			} else {

				if ( class_exists( 'ZP_Ephemeris' ) ) {
					$args['house_system'] = $h_sys;
					$ephemeris = new ZP_Ephemeris( $args );
					$data = $ephemeris->query();
				}
				// @todo Deprecated. Will be removed in an upcoming version.
				else {
					$data = $chart->query_ephemeris( '', 'l', $h_sys );
				}
				
			}
			
			// Capture the house cusps, which ephemeris outputs at index 0-11
			for ( $x = 0; $x <= 11; $x++ ) {

				// Do Whole Sign cusps by hand because Swiss Eph gives wrong Whole Sign house calculations.
				if ( 'W' == $h_sys ) {
					$this_house = $whole_sign_house_1 + ( 30 * $x );
					$this->cusps[ $h_sys ][ $x + 1 ] = ( $this_house >= 360 ) ? ( $this_house - 360 ) : $this_house;
				} else {
					$this->cusps[ $h_sys ][ $x + 1 ] = trim( $data[ $x ] );
				}
			}

			// Set up the planets_house_num property

			foreach ( $planets as $key => $planet ) {

				$this->planets_house_num[ $h_sys ][ $key ] = zp_get_planet_house_num( $chart->planets_longitude[ $key ], $this->cusps[ $h_sys ] );

				if ( $this->planets_house_num[ $h_sys ][ $key ] ) {
					// Set up the conjunct_next_cusp property
					$this->conjunct_next_cusp[ $h_sys ][ $key ] = zp_conjunct_next_cusp( $key, $chart->planets_longitude[ $key ], $this->planets_house_num[ $h_sys ][ $key ], $this->cusps[ $h_sys ] );

				}

			}

			// Include ASC [15] house numbers for Meridian, Morinus, Vehlow, and Whole houses.
			$h_sys_for_asc = array( 'X', 'M', 'V', 'W' );
			if ( in_array( $h_sys, $h_sys_for_asc ) ) {
				$this->planets_house_num[ $h_sys ][15] = zp_get_planet_house_num( $chart->planets_longitude[15], $this->cusps[ $h_sys ] );

					if ( $this->planets_house_num[ $h_sys ][15] ) {
						// Set up the conjunct_next_cusp property
						$this->conjunct_next_cusp[ $h_sys ][15] = zp_conjunct_next_cusp(15, $chart->planets_longitude[15], $this->planets_house_num[ $h_sys ][15], $this->cusps[ $h_sys ] );
				}

			}

			// Include MC [16] house numbers for Equal, Morinus, Vehlow, and Whole houses.
			$h_sys_for_mc =  array( 'E', 'M', 'V', 'W' );
			if ( in_array( $h_sys, $h_sys_for_mc ) ) {
				$this->planets_house_num[ $h_sys ][16] = zp_get_planet_house_num( $chart->planets_longitude[16], $this->cusps[ $h_sys ] );

					if ( $this->planets_house_num[ $h_sys ][16] ) {
						// Set up the conjunct_next_cusp property
						$this->conjunct_next_cusp[ $h_sys ][16] = zp_conjunct_next_cusp(16, $chart->planets_longitude[16], $this->planets_house_num[ $h_sys ][16], $this->cusps[ $h_sys ] );
				}

			}

		}

	}

	/**
	 * Get the Planet House Positions By House System data table.
	 *
	 * Lists house number positions of planets and points in all our house systems.
	 */
	private function house_positions_table( $form ) {
		if ( empty( $form ) || empty( $this->planets_house_num ) ) {
			return false;
		}

		$sidereal = empty( $form['sidereal'] ) ? '' : __( ', Sidereal Zodiac', 'zp-house-systems' );

		// Allow house systems to be removed
		$house_systems = zp_get_house_systems();
		$omit = apply_filters( 'zphs_house_pos_table_omit_house_sys', array() );
		foreach( $omit as $h ) {
			unset( $house_systems[ $h ] );
		}

		$planets = zp_get_planets();

		$table	= '<table id="zp-natal-planets-table" class="zp-data-table">';
		$table .= '<caption class="zp-report-caption">' .
				sprintf( __( '%1$s\'s Planets\' and Points\' House Positions By House System%2$s', 'zp-house-systems' ),
					$form['name'],
					$sidereal ) . '</caption>';

		// Table head
		$table .= '<thead><tr>' .
					'<th>' . __( 'House System', 'zp-house-systems' ) . ' </th>';

		// A column header for each planet/point
		foreach ( $planets as $i => $p ) {
			$table .= '<th>' . $p['label'] . '</th>';
		}
		$table .= '</tr></thead>';

		// Table body
		$table .= '<tbody>';

		// A row for each house system
		foreach ( $house_systems as $h_sys => $label ) {
			$table .= '<tr><td>' . $label . '</td>';
			
			// A column for each planet/point
			foreach ( $planets as $i => $p ) {

				$table .= '<td>';

				if ( isset( $this->planets_house_num[ $h_sys ] ) ) {
					$house_num = empty( $this->planets_house_num[ $h_sys ][ $i ] ) ? ' ' : $this->planets_house_num[ $h_sys ][ $i ];
					$column_data = $house_num;

					// if conjunct next house cusp, show dash - & next number
					if ( ! empty( $this->conjunct_next_cusp[ $h_sys ][ $i ]  ) ) {
						$next = ( 12 == $house_num ) ? '1' : ( $house_num + 1 );
						$column_data .= ' - ' . $next;
					}

				}

				$table .= $column_data . '</td>';

			}
				
			$table .= '</tr>';// End row for each house system
		}

		$table .= '</tbody></table>';

		return $table;
	}

	/**
	 * Get the natal house cusps data table.
	 *
	 * Lists house cusps for multiple house systems.
	 */
	private function cusps_table( $form ) {
		if ( empty( $form ) ) {
			return false;
		}

		$sidereal = empty( $form['sidereal'] ) ? '' : __( ', Sidereal Zodiac', 'zp-house-systems' );

		// Allow house systems to be removed
		$house_systems = zp_get_house_systems();
		$omit = apply_filters( 'zphs_cusps_table_omit_house_sys', array() );
		foreach( $omit as $h ) {
			unset( $house_systems[ $h ] );
		}

		$table = '<table id="zp-natal-cusps-table" class="zp-data-table">';
		$table .= '<caption class="zp-report-caption">' .
				sprintf( __( '%1$s\'s House Cusps%2$s', 'zp-house-systems' ),
				$form['name'],
				$sidereal ) . '</caption>';

		// Table head
		$table .= '<thead><tr>' .
					'<th>' . __( 'House System', 'zp-house-systems' ) . ' </th>';

		// A column heading for each house
		for ( $i = 1; $i <= 12; $i++ ) {
			$table .= '<th>' . $i . '</th>';
		}
				
		$table .= '</tr></thead>';

		// Table body
		$table .= '<tbody>';

		// a row for each house system
		foreach ( $house_systems as $h_sys => $label ) {

			// House system column
			$table .= '<tr><td>' . $label . '</td>';

			// a column for each house
			for ( $i = 1; $i <= 12; $i++ ) {
				$table .= '<td>' . zp_get_zodiac_sign_dms( $this->cusps[ $h_sys ][ $i ] ) . '</td>';
			}

			$table .= '</tr>';
		}

		$table .= '</tbody></table>';

		return $table;
	}

	/**
	 * Add CSS for data tables to the main ZP stylsheet.
	 */
	public function styles() {

		$css = '#zp-natal-planets-table,#zp-natal-cusps-table {
			font-size: 11px;
			border-collapse: collapse;
			border-spacing:0;
			line-height: 1;
			font-family: Arial,Helvetica,sans-serif;
			border: 1px solid #dddddd;
			display: inline-block;
  			vertical-align: top;
			overflow-x: auto;
			white-space: nowrap;
			-webkit-overflow-scrolling: touch;
			}
			#zp-natal-planets-table{
				margin: 36px auto;
			}
			#zp-natal-planets-table th,#zp-natal-cusps-table th {
				text-transform: uppercase;
				text-align: center;
			}
			#zp-natal-planets-table th, #zp-natal-cusps-table th,
			#zp-natal-planets-table td, #zp-natal-cusps-table td {
				border: 1px solid #d9d7ce;
				padding: 0.3em 0.5em;
				vertical-align: bottom;
			}
			#zp-natal-planets-table th:first-child,#zp-natal-cusps-table th:first-child,
			#zp-natal-planets-table td:first-child ,#zp-natal-cusps-table td:first-child {
				text-align: left;
			}
			#zp-natal-cusps-table td {
				padding: 0.3em 0.7em;
			}
			#zp-natal-planets-table td {
				padding-left:12px
			}
			#zp-natal-planets-table thead > tr:first-child > th:first-child,
			#zp-natal-cusps-table thead > tr:first-child > th:first-child,
			#zp-natal-planets-table td:first-child,
			#zp-natal-cusps-table td:first-child {
				padding-left:6px;
				padding-right:0;
			}
			/* fixed 1st column */
			#zp-natal-planets-table thead > tr:first-child>th:first-child,
			#zp-natal-cusps-table thead > tr:first-child>th:first-child,
			#zp-natal-planets-table > tbody > tr > td:first-child,
			#zp-natal-cusps-table > tbody > tr > td:first-child {
				position: absolute;
				display: inline-block;
				font-weight:bold;
				background-color:#fff;
				width:97px;
				border-width:0 1px 0 0;
			}
			#zp-natal-planets-table > thead > tr:first-child>th:nth-child(2),
			#zp-natal-cusps-table > thead > tr:first-child>th:nth-child(2) {
				padding-left:104px !important; 
			}
			#zp-natal-planets-table > tbody > tr > td:nth-child(2),
			#zp-natal-cusps-table > tbody > tr > td:nth-child(2) {
				padding-left: 110px !important;
			}
			#zp-natal-cusps-table td {
  				white-space:nowrap;
			}
			#zp-natal-planets-table tr:nth-child(2n),
			#zp-natal-cusps-table tr:nth-child(2n),
			#zp-natal-planets-table > tbody > tr:nth-child(2n) > td:first-child,
			#zp-natal-cusps-table > tbody > tr:nth-child(2n) > td:first-child {
				background-color: #e9e9e9;
			}
			#zp-natal-planets-table caption,
			#zp-natal-cusps-table caption {
				font-size: 1.3em;
				padding: 8px 10px;
				margin: 0;
			}';
		wp_add_inline_style( 'zp', $css );
	}
	
	/**
	 * Add House Systems report to the array of reports that require birth time in order to force the form to require birth time for this report.
	 */
	public function require_birth_time( $array ) {
		$array[] = 'house_systems';
		return $array;
	}

	/**
	 * Add settings to the ZP settings Natal Report tab.
	 */
	public function settings( $settings ) {
		// Add setting to the Display section of the Natal Report tab.
		$settings['report']['zphs_add_to_report'] = array(
						'id'	=> 'zphs_add_to_report',
						'name'	=> __( 'Add House Comparison Tables', 'zp-house-systems' ),
						'type'	=> 'checkbox',
						'desc'	=> __( 'Add the House Systems Comparison data tables to the bottom of the birth report. ', 'zp-house-systems' )
		);

		// Add setting to the Technical section of the Natal Report tab.
		$settings['technical']['house_system'] = array(
						'id'		=> 'house_system',
						'name'		=> __( 'House System', 'zp-house-systems' ),
						'type'		=> 'select',
						'desc'		=> __( 'Which house system should be used to calculate house cusps for the Birth Report?', 'zp-house-systems' ),
						'options'	=> zp_get_house_systems(),
						'std'		=> 'P'
		);
		return $settings;
	}
		
	/**
	 * Set the default form title for the Compare House Systems report form.
	 */
	public function form_title( $title, $atts ) {
		if ( isset( $atts['report'] ) && 'house_systems' == $atts['report'] ) {
			$title = __( 'Compare Your Planets In Multiple House Systems', 'zp-house-systems' );
		}
		return $title;
	}

	/**
	 * Omit Houses line from report header on the Compare House Systems report.
	 */
	public function omit_houses_on_h_sys_report( $houses, $variation ) {
		return ( 'house_systems' == $variation ) ? '' : $houses;
	}

}

/**
 * The main function responsible for returning the one true ZP_House_Systems
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $zp_hs = zp_house_systems(); ?>
 *
 * @return ZP_House_Systems The one true ZP_House_Systems Instance
 */
function zp_house_systems() {
		return ZP_House_Systems::instance();
}
// Get ZP House Systems running
add_action( 'plugins_loaded', 'zp_house_systems' );
