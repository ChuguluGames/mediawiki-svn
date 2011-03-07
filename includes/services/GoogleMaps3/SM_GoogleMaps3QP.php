<?php
/**
 * A query printer for maps using the Google Maps API v3.
 *
 * @file SM_GoogleMaps3QP.php
 * @ingroup SMGoogleMaps3
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMGoogleMaps3QP extends SMMapPrinter {
	
	/**
	 * @see SMMapPrinter::getServiceName
	 */	
	protected function getServiceName() {
		return 'googlemaps3';
	}
	
}
