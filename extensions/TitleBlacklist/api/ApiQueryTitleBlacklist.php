<?php
/**
 * TitleBlacklist extension API
 *
 * Copyright © 2011 Wikimedia Foundation and Ian Baker <ian@wikimedia.org>
 * Based on code by Victor Vasiliev, Bryan Tong Minh, Roan Kattouw, and Alex Z.
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
 */

/**
 * Query module check a title against the blacklist
 *
 * @ingroup API
 * @ingroup Extensions
 */


class ApiQueryTitleBlacklist extends ApiQueryBase {
		
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'tb' );
	}

	public function execute() {
		global $wgTitleBlacklist; // When in Rome...

		# get the current user.
		$context = $this->createContext();
		$user = $context->getUser();
		
		$params = $this->extractRequestParams();
		$action = $params['action'];

		// check the blacklist, the same way tbhooks does it.
		//
		// Some places check createpage, while others check create.
		// As it stands, upload does createpage, but normalize both
		// to the same action, to stop future similar bugs.
		if( $action === 'createpage' || $action === 'createtalk' ) {
			$action = 'create';
		}
		
		// possible actions at the moment: create, edit, upload
		efInitTitleBlacklist();

		$blacklisted = $wgTitleBlacklist->userCannot( $params['title'], $user, $action );
		if( $blacklisted instanceof TitleBlacklistEntry ) {
			// this title is blacklisted.
			$result = array(
				htmlspecialchars( $blacklisted->getRaw() ),
				htmlspecialchars( $params['title'] ),
			);
			
			$this->getResult()->addValue( 'titleblacklist', 'result', 'blacklisted' );
			$this->getResult()->addValue( 'titleblacklist', 'reason', wfMsg($blacklisted->getErrorMessage('edit'), $result) );
		} else {
			// not blacklisted
			$this->getResult()->addValue( 'titleblacklist', 'result', 'ok' );
		}

	}

	public function getAllowedParams() {
		return array(
			'title' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'action' => array(
				ApiBase::PARAM_DFLT => 'edit',
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => array(
					'create', 'edit', 'upload', 'createtalk', 'createpage',
				),
			)
		);
	}

	public function getParamDescription() {
		return array(
			'title' => 'The string to validate against the blacklist',
			'lang' => 'The current language',
			'action' => 'The thing you\'re trying to do',
		);
	}

	public function getDescription() {
		return 'Validate an article title, filename, or username against the TitleBlacklist.';
	}

	protected function getExamples() {
		return array(
			'api.php?action=titleblacklist&tbtitle=Foo',
			'api.php?action=titleblacklist&tbtitle=Bar&tbaction=create',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}
}
