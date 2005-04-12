<?php
/**
 * Contain the blockcache class
 * @package MediaWiki
 * @package Cache
 */

/**
 * Object for fast lookup of IP blocks
 * Represents a memcached value, and in some sense, the entire ipblocks table
 * @package MediaWiki
 */
class BlockCache
{
	var $mData = false, $mMemcKey;

	/**
	 * Constructor
	 * Create a new BlockCache object
	 *
	 * @param Boolean $deferLoad   specifies whether to immediately load the data from memcached.
	 * @param String $dbName       specifies the memcached dbName prefix to be used. Defaults to $wgDBname.
	 */
	function BlockCache( $deferLoad = false, $dbName = '' ) {
		global $wgDBname;

		if ( $dbName == '' ) {
			$dbName = $wgDBname;
		}

		$this->mMemcKey = $dbName.':ipblocks';

		if ( !$deferLoad ) {
			$this->load();
		}
	}

	/**
	 * Load the blocks from the database and save them to memcached
	 *  @param bool $bFromSlave Whether to load data from slaves or master
	 */
	function loadFromDB( $bFromSlave = false ) {
		global $wgUseMemCached, $wgMemc;
		$this->mData = array();
		# Selecting FOR UPDATE is a convenient way to serialise the memcached and DB operations,
		# which is necessary even though we don't update the DB
		if ( !$bFromSlave ) {
			Block::enumBlocks( 'wfBlockCacheInsert', '', EB_FOR_UPDATE );
			#$wgMemc->set( $this->mMemcKey, $this->mData, 0 );
		} else {
			Block::enumBlocks( 'wfBlockCacheInsert', '' );
		}
	}
		
	/**
	 * Load the cache from memcached or, if that's not possible, from the DB
	 */
	function load( $bFromSlave ) {
		global $wgUseMemCached, $wgMemc;

		if ( $this->mData === false) {
			$this->loadFromDB( $bFromSlave );
/*
		// Memcache disabled for performance issues.
			# Try memcached
			if ( $wgUseMemCached ) {
				$this->mData = $wgMemc->get( $this->mMemcKey );
			}

			if ( !is_array( $this->mData ) ) {
				$this->loadFromDB( $bFromSlave );
			}*/
		}
	}

	/**
	 * Add a block to the cache
	 *
	 * @param Object &$block   Reference to a "Block" object.
	 */
	function insert( &$block ) {
		if ( $block->mUser == 0 ) {
			$nb = $block->getNetworkBits();
			$ipint = $block->getIntegerAddr();
			$index = $ipint >> ( 32 - $nb );

			if ( !array_key_exists( $nb, $this->mData ) ) {
				$this->mData[$nb] = array();
			}
		
			$this->mData[$nb][$index] = 1;
		}
	}
	
	/**
	 * Find out if a given IP address is blocked
	 *
	 * @param String $ip   IP address
	 * @param bool $bFromSlave True means to load check against slave, else check against master.
	 */
	function get( $ip, $bFromSlave ) {
		$this->load( $bFromSlave );
		$ipint = ip2long( $ip );
		$blocked = false;

		foreach ( $this->mData as $networkBits => $blockInts ) {
			if ( array_key_exists( $ipint >> ( 32 - $networkBits ), $blockInts ) ) {
				$blocked = true;
				break;
			}
		}
		if ( $blocked ) {
			# Clear low order bits
			if ( $networkBits != 32 ) {
				$ip .= '/'.$networkBits;
				$ip = Block::normaliseRange( $ip );
			}
			$block = new Block();
			$block->forUpdate( $bFromSlave );
			$block->load( $ip );
		} else {
			$block = false;
		}

		return $block;
	}

	/**
	 * Clear the local cache
	 * There was once a clear() to clear memcached too, but I deleted it
	 */
	function clearLocal() {
		$this->mData = false;
	}
}

/**
 * Add a block to the global $wgBlockCache
 *
 * @param Object $block  A "Block"-object
 * @param Any    $tag    unused
 */
function wfBlockCacheInsert( $block, $tag ) {
	global $wgBlockCache;
	$wgBlockCache->insert( $block );
}
