<?php
/**
 * Class ZP_HS_Helper
 *
 * Helper class for ZP House Systems UnitTests
 */
class ZP_HS_Helper extends WP_UnitTestCase {

	/**
	 * Get an array of test charts.
	 */
	public static function create_charts( $report_var ) {

		if ( empty( $report_var ) ) {
			return false;
		}

		$persons = array(
			array(
				'name'					=> 'Steve Jobs',
				'month'					=> '2',
				'day'					=> '24',
				'year'					=> '1955',
				'hour'					=> '19',
				'minute'				=> '15',
				'city'					=> 'San Francisco',
				'geo_timezone_id'		=> 'America/Los_Angeles',
				'place'					=> 'San Francisco, California, United States',
				'zp_lat_decimal'		=> '37.77493',
				'zp_long_decimal'		=> '-122.41942',
				'zp_offset_geo'			=> '-8',
				'action'				=> 'zp_birthreport',
				'zp-report-variation'	=> $report_var,
				'unknown_time'			=> '',
				'sidereal'				=> false
			),
			array(
				'name'					=> 'Michael Jackson',
				'month'					=> '8',
				'day'					=> '29',
				'year'					=> '1958',
				'hour'					=> '19',
				'minute'				=> '33',
				'city'					=> 'Gary',
				'geo_timezone_id'		=> 'America/Chicago',
				'place'					=> 'Gary, Indiana, United States',
				'zp_lat_decimal'		=> '41.59337',
				'zp_long_decimal'		=> '-87.34643',
				'zp_offset_geo'			=> '-5',
				'action'				=> 'zp_birthreport',
				'zp-report-variation'	=> $report_var,
				'unknown_time'			=> '',
				'sidereal'				=> false
				)
		);

		foreach ( $persons as $v ) {
			$charts[] = self::get_chart( $v );
		}
		return $charts;
	}
	/**
	 * Get a single chart. 
	 */
	public static function get_chart( $person ) {
		return ZP_Chart::get_instance( $person );
	}

	/**
	 * Get a Birth Report object
	 */
	public static function get_report( $report ) {

		$person = array(
				'name'					=> 'Michael Jackson',
				'month'					=> '8',
				'day'					=> '29',
				'year'					=> '1958',
				'hour'					=> '19',
				'minute'				=> '33',
				'city'					=> 'Gary',
				'geo_timezone_id'		=> 'America/Chicago',
				'place'					=> 'Gary, Indiana, United States',
				'zp_lat_decimal'		=> '41.59337',
				'zp_long_decimal'		=> '-87.34643',
				'zp_offset_geo'			=> '-5',
				'action'				=> 'zp_birthreport',
				'zp-report-variation'	=> $report,
				'unknown_time'			=> '',
				'sidereal'				=> false
			);
		$charts = self::create_charts( $report );
		$report_obj	= new ZP_Birth_Report( $charts[0], $person );
		return $report_obj->get_report( $report );
	}

	/**
	 * Get a Birth Report with unknown birth time
	 */
	public static function get_report_unknown_birth_time( $report ) {

		$person_unknown_birth_time = array(
				'name'					=> 'Michael Jackson',
				'month'					=> '8',
				'day'					=> '29',
				'year'					=> '1958',
				'hour'					=> '19',
				'minute'				=> '33',
				'city'					=> 'Gary',
				'geo_timezone_id'		=> 'America/Chicago',
				'place'					=> 'Gary, Indiana, United States',
				'zp_lat_decimal'		=> '41.59337',
				'zp_long_decimal'		=> '-87.34643',
				'zp_offset_geo'			=> '-5',
				'action'				=> 'zp_birthreport',
				'zp-report-variation'	=> $report,
				'unknown_time'			=> 'on',
				'sidereal'				=> false
		);

		$report_ojb	= new ZP_Birth_Report( self::get_chart( $person_unknown_birth_time ), $person_unknown_birth_time );

		return $report_ojb->get_report( $report );
	}

	/**
	 * Get all the available house systems
	 */
	public static function get_house_systems() {

		$zp_hs = zp_house_systems();
		$property = self::get_private_property( 'ZP_House_Systems', 'house_systems' );
		$h_systems = $property->getValue( $zp_hs );

		return $h_systems;
	}


	/**
 	 * get_private_property
 	 */
	public static function get_private_property( $class_name, $property_name ) {
		$reflector = new ReflectionClass( $class_name );
		$property = $reflector->getProperty( $property_name );
		$property->setAccessible( true );
 
		return $property;
	}

}
