<?php
/**
 * Implements Special:Log
 *
 * Copyright © 2008 Aaron Schulz
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage
 */

/**
 * A special page that lists log entries
 *
 * @ingroup SpecialPage
 */
class SpecialLog extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Log' );
	}

	public function execute( $par ) {
		global $wgRequest;

		$this->setHeaders();
		$this->outputHeader();

		$opts = new FormOptions;
		$opts->add( 'type', '' );
		$opts->add( 'user', '' );
		$opts->add( 'page', '' );
		$opts->add( 'pattern', false );
		$opts->add( 'year', null, FormOptions::INTNULL );
		$opts->add( 'month', null, FormOptions::INTNULL );
		$opts->add( 'tagfilter', '' );
		$opts->add( 'offset', '' );
		$opts->add( 'dir', '' );
		$opts->add( 'offender', '' );

		// Set values
		$opts->fetchValuesFromRequest( $wgRequest );
		if ( $par ) {
			$this->parseParams( $opts, (string)$par );
		}

		# Don't let the user get stuck with a certain date
		if ( $opts->getValue( 'offset' ) || $opts->getValue( 'dir' ) == 'prev' ) {
			$opts->setValue( 'year', '' );
			$opts->setValue( 'month', '' );
		}

		if ( !LogPage::isLogType( $opts->getValue( 'type' ) ) ) {
			$opts->setValue( 'type', '' );
		}

		# Handle type-specific inputs
		$qc = array();
		if ( $opts->getValue( 'type' ) == 'suppress' ) {
			$offender = User::newFromName( $opts->getValue( 'offender' ), false );
			if ( $offender && $offender->getId() > 0 ) {
				$qc = array( 'ls_field' => 'target_author_id', 'ls_value' => $offender->getId() );
			} elseif ( $offender && IP::isIPAddress( $offender->getName() ) ) {
				$qc = array( 'ls_field' => 'target_author_ip', 'ls_value' => $offender->getName() );
			}
		}

		$this->show( $opts, $qc );
	}

	private function parseParams( FormOptions $opts, $par ) {
		global $wgLogTypes;

		# Get parameters
		$parms = explode( '/', ($par = ( $par !== null ) ? $par : '' ) );
		$symsForAll = array( '*', 'all' );
		if ( $parms[0] != '' && ( in_array( $par, $wgLogTypes ) || in_array( $par, $symsForAll ) ) ) {
			$opts->setValue( 'type', $par );
		} elseif ( count( $parms ) == 2 ) {
			$opts->setValue( 'type', $parms[0] );
			$opts->setValue( 'user', $parms[1] );
		} elseif ( $par != '' ) {
			$opts->setValue( 'user', $par );
		}
	}

	private function show( FormOptions $opts, array $extraConds ) {
		global $wgOut;

		# Create a LogPager item to get the results and a LogEventsList item to format them...
		$loglist = new LogEventsList( $this->getSkin(), $wgOut, 0 );
		$pager = new LogPager( $loglist, $opts->getValue( 'type' ), $opts->getValue( 'user' ),
			$opts->getValue( 'page' ), $opts->getValue( 'pattern' ), $extraConds, $opts->getValue( 'year' ),
			$opts->getValue( 'month' ), $opts->getValue( 'tagfilter' ) );

		$this->addHeader( $opts->getValue( 'type' ) );

		# Set relevant user
		if ( $pager->getUser() ) {
			$this->getSkin()->setRelevantUser( User::newFromName( $pager->getUser() ) );
		}

		# Show form options
		$loglist->showOptions( $pager->getType(), $pager->getUser(), $pager->getPage(), $pager->getPattern(),
			$pager->getYear(), $pager->getMonth(), $pager->getFilterParams(), $opts->getValue( 'tagfilter' ) );

		# Insert list
		$logBody = $pager->getBody();
		if ( $logBody ) {
			$wgOut->addHTML(
				$pager->getNavigationBar() .
				$loglist->beginLogEventsList() .
				$logBody .
				$loglist->endLogEventsList() .
				$pager->getNavigationBar()
			);
		} else {
			$wgOut->addWikiMsg( 'logempty' );
		}
	}

	/**
	 * Set page title and show header for this log type
	 * @param $type string
	 * @since 1.19
	 */
	protected function addHeader( $type ) {
		$page = new LogPage( $type );
		$this->getOutput()->setPageTitle( $page->getName()->text() );
		$this->getOutput()->addHTML( $page->getDescription()->parseAsBlock() );
	}

}
