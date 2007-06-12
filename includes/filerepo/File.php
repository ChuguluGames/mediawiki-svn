<?php

/**
 * Base file class. Do not instantiate.
 *
 * Implements some public methods and some protected utility functions which 
 * are required by multiple child classes. Contains stub functionality for 
 * unimplemented public methods.
 *
 * Stub functions which should be overridden are marked with STUB. Some more 
 * concrete functions are also typically overridden by child classes.
 *
 * Note that only the repo object knows what its file class is called. You should
 * never name a file class explictly outside of the repo class. Instead use the 
 * repo's factory functions to generate file objects, for example:
 *
 * RepoGroup::singleton()->getLocalRepo()->newFile($title);
 *
 * The convenience functions wfLocalFile() and wfFindFile() should be sufficient
 * in most cases.
 *
 * @addtogroup FileRepo
 */
class File {
	const DELETED_FILE = 1;
	const DELETED_COMMENT = 2;
	const DELETED_USER = 4;
	const DELETED_RESTRICTED = 8;
	const RENDER_NOW = 1;

	const DELETE_SOURCE = 1;

	/** 
	 * Some member variables can be lazy-initialised using __get(). The 
	 * initialisation function for these variables is always a function named
	 * like getVar(), where Var is the variable name with upper-case first 
	 * letter.
	 *
	 * The following variables are initialised in this way in this base class:
	 *    name, extension, handler, path, canRender, isSafeFile, 
	 *    transformScript, hashPath, pageCount, url
	 *
	 * Code within this class should generally use the accessor function 
	 * directly, since __get() isn't re-entrant and therefore causes bugs that
	 * depend on initialisation order.
	 */

	/**
	 * The following member variables are not lazy-initialised
	 */
	var $repo, $title, $lastError;

	/**
	 * Call this constructor from child classes
	 */
	function __construct( $title, $repo ) {
		$this->title = $title;
		$this->repo = $repo;
	}

	function __get( $name ) {
		$function = array( $this, 'get' . ucfirst( $name ) );
		if ( !is_callable( $function ) ) {
			return null;
		} else {
			$this->$name = call_user_func( $function );
			return $this->$name;
		}
	}

	/**
	 * Normalize a file extension to the common form, and ensure it's clean.
	 * Extensions with non-alphanumeric characters will be discarded.
	 *
	 * @param $ext string (without the .)
	 * @return string
	 */
	static function normalizeExtension( $ext ) {
		$lower = strtolower( $ext );
		$squish = array(
			'htm' => 'html',
			'jpeg' => 'jpg',
			'mpeg' => 'mpg',
			'tiff' => 'tif' );
		if( isset( $squish[$lower] ) ) {
			return $squish[$lower];
		} elseif( preg_match( '/^[0-9a-z]+$/', $lower ) ) {
			return $lower;
		} else {
			return '';
		}
	}

	/**
	 * Upgrade the database row if there is one
	 * Called by ImagePage
	 * STUB
	 */
	function upgradeRow() {}

	/**
	 * Split an internet media type into its two components; if not
	 * a two-part name, set the minor type to 'unknown'.
	 *
	 * @param $mime "text/html" etc
	 * @return array ("text", "html") etc
	 */
	static function splitMime( $mime ) {
		if( strpos( $mime, '/' ) !== false ) {
			return explode( '/', $mime, 2 );
		} else {
			return array( $mime, 'unknown' );
		}
	}
	
	/**
	 * Return the name of this file
	 * @public
	 */
	function getName() {
		if ( !isset( $this->name ) ) {
			$this->name = $this->repo->getNameFromTitle( $this->title );
		}
		return $this->name; 
	}

	/**
	 * Get the file extension, e.g. "svg"
	 */
	function getExtension() {
		if ( !isset( $this->extension ) ) {
			$n = strrpos( $this->getName(), '.' );
			$this->extension = self::normalizeExtension( 
				$n ? substr( $this->getName(), $n + 1 ) : '' );
		}
		return $this->extension;
	}

	/**
	 * Return the associated title object
	 * @public
	 */
	function getTitle() { return $this->title; }

	/**
	 * Return the URL of the file
	 * @public
	 */
	function getUrl() { 
		if ( !isset( $this->url ) ) {
			$this->url = $this->repo->getZoneUrl( 'public' ) . '/' . $this->getUrlRel();
		}
		return $this->url; 
	}

	function getViewURL() {
		if( $this->mustRender()) {
			if( $this->canRender() ) {
				return $this->createThumb( $this->getWidth() );
			}
			else {
				wfDebug(__METHOD__.': supposed to render '.$this->getName().' ('.$this->getMimeType()."), but can't!\n");
				return $this->getURL(); #hm... return NULL?
			}
		} else {
			return $this->getURL();
		}
	}

	/**
	* Return the full filesystem path to the file. Note that this does
	* not mean that a file actually exists under that location.
	*
	* This path depends on whether directory hashing is active or not,
	* i.e. whether the files are all found in the same directory,
	* or in hashed paths like /images/3/3c.
	*
	* May return false if the file is not locally accessible.
	*
	* @public
	*/
	function getPath() {
		if ( !isset( $this->path ) ) {
			$this->path = $this->repo->getZonePath('public') . '/' . $this->getRel();
		}
		return $this->path;
	}

	/**
	* Alias for getPath()
	* @public
	*/
	function getFullPath() {
		return $this->getPath();
	}

	/**
	 * Return the width of the image. Returns false if the width is unknown 
	 * or undefined.
	 *
	 * STUB
	 * Overridden by LocalFile, UnregisteredLocalFile
	 * @public
	 */
	function getWidth( $page = 1 ) { return false; }

	/**
	 * Return the height of the image. Returns false if the height is unknown 
	 * or undefined
	 *
	 * STUB
	 * Overridden by LocalFile, UnregisteredLocalFile
	 * @public
	 */
	function getHeight( $page = 1 ) { return false; }

	/**
	 * Get handler-specific metadata
	 * Overridden by LocalFile, UnregisteredLocalFile
	 * STUB
	 */
	function getMetadata() { return false; }

	/**
	 * Return the size of the image file, in bytes
	 * Overridden by LocalFile, UnregisteredLocalFile
	 * STUB
	 * @public
	 */
	function getSize() { return false; }

	/**
	 * Returns the mime type of the file.
	 * Overridden by LocalFile, UnregisteredLocalFile
	 * STUB
	 */
	function getMimeType() { return 'unknown/unknown'; }

	/**
	 * Return the type of the media in the file.
	 * Use the value returned by this function with the MEDIATYPE_xxx constants.
	 * Overridden by LocalFile,
	 * STUB
	 */
	function getMediaType() { return MEDIATYPE_UNKNOWN; }

	/**
	 * Checks if the file can be presented to the browser as a bitmap.
	 *
	 * Currently, this checks if the file is an image format
	 * that can be converted to a format
	 * supported by all browsers (namely GIF, PNG and JPEG),
	 * or if it is an SVG image and SVG conversion is enabled.
	 */
	function canRender() {
		if ( !isset( $this->canRender ) ) {
			$this->canRender = $this->getHandler() && $this->handler->canRender();
		}
		return $this->canRender;
	}

	/**
	 * Accessor for __get()
	 */
	protected function getCanRender() {
		return $this->canRender();
	}

	/**
	 * Return true if the file is of a type that can't be directly
	 * rendered by typical browsers and needs to be re-rasterized.
	 *
	 * This returns true for everything but the bitmap types
	 * supported by all browsers, i.e. JPEG; GIF and PNG. It will
	 * also return true for any non-image formats.
	 *
	 * @return bool
	 */
	function mustRender() {
		return $this->getHandler() && $this->handler->mustRender();
	}

	/**
	 * Determines if this media file may be shown inline on a page.
	 *
	 * This is currently synonymous to canRender(), but this could be
	 * extended to also allow inline display of other media,
	 * like flash animations or videos. If you do so, please keep in mind that
	 * that could be a security risk.
	 */
	function allowInlineDisplay() {
		return $this->canRender();
	}

	/**
	 * Determines if this media file is in a format that is unlikely to
	 * contain viruses or malicious content. It uses the global
	 * $wgTrustedMediaFormats list to determine if the file is safe.
	 *
	 * This is used to show a warning on the description page of non-safe files.
	 * It may also be used to disallow direct [[media:...]] links to such files.
	 *
	 * Note that this function will always return true if allowInlineDisplay()
	 * or isTrustedFile() is true for this file.
	 */
	function isSafeFile() {
		if ( !isset( $this->isSafeFile ) ) {
			$this->isSafeFile = $this->_getIsSafeFile();
		}
		return $this->isSafeFile;
	}
	
	/** Accessor for __get() */
	protected function getIsSafeFile() {
		return $this->isSafeFile();
	}

	/** Uncached accessor */
	protected function _getIsSafeFile() {
		if ($this->allowInlineDisplay()) return true;
		if ($this->isTrustedFile()) return true;

		global $wgTrustedMediaFormats;

		$type= $this->getMediaType();
		$mime= $this->getMimeType();
		#wfDebug("LocalFile::isSafeFile: type= $type, mime= $mime\n");

		if (!$type || $type===MEDIATYPE_UNKNOWN) return false; #unknown type, not trusted
		if ( in_array( $type, $wgTrustedMediaFormats) ) return true;

		if ($mime==="unknown/unknown") return false; #unknown type, not trusted
		if ( in_array( $mime, $wgTrustedMediaFormats) ) return true;

		return false;
	}

	/** Returns true if the file is flagged as trusted. Files flagged that way
	* can be linked to directly, even if that is not allowed for this type of
	* file normally.
	*
	* This is a dummy function right now and always returns false. It could be
	* implemented to extract a flag from the database. The trusted flag could be
	* set on upload, if the user has sufficient privileges, to bypass script-
	* and html-filters. It may even be coupled with cryptographics signatures
	* or such.
	*/
	function isTrustedFile() {
		#this could be implemented to check a flag in the databas,
		#look for signatures, etc
		return false;
	}

	/**
	 * Returns true if file exists in the repository.
	 *
	 * Overridden by LocalFile to avoid unnecessary stat calls.
	 * 
	 * @return boolean Whether file exists in the repository.
	 * @public
	 */
	function exists() {
		return $this->getPath() && file_exists( $this->path );
	}

	function getTransformScript() {
		if ( !isset( $this->transformScript ) ) {
			$this->transformScript = false;
			if ( $this->repo ) {
				$script = $this->repo->getThumbScriptUrl();
				if ( $script ) {
					$this->transformScript = "$script?f=" . urlencode( $this->getName() );
				}
			}
		}
		return $this->transformScript;
	}

	/**
	 * Get a ThumbnailImage which is the same size as the source
	 */
	function getUnscaledThumb( $page = false ) {
		$width = $this->getWidth( $page );
		if ( !$width ) {
			return $this->iconThumb();
		}
		if ( $page ) {
			$params = array(
				'page' => $page,
				'width' => $this->getWidth( $page )
			);
		} else {
			$params = array( 'width' => $this->getWidth() );
		}
		return $this->transform( $params );
	}

	/**
	 * Return the file name of a thumbnail with the specified parameters
	 *
	 * @param array $params Handler-specific parameters
	 * @private
	 */
	function thumbName( $params ) {
		if ( !$this->getHandler() ) {
			return null;
		}
		$extension = $this->getExtension();
		list( $thumbExt, $thumbMime ) = $this->handler->getThumbType( $extension, $this->getMimeType() );
		$thumbName = $this->handler->makeParamString( $params ) . '-' . $this->getName();
		if ( $thumbExt != $extension ) {
			$thumbName .= ".$thumbExt";
		}
		return $thumbName;
	}

	/**
	 * Create a thumbnail of the image having the specified width/height.
	 * The thumbnail will not be created if the width is larger than the
	 * image's width. Let the browser do the scaling in this case.
	 * The thumbnail is stored on disk and is only computed if the thumbnail
	 * file does not exist OR if it is older than the image.
	 * Returns the URL.
	 *
	 * Keeps aspect ratio of original image. If both width and height are
	 * specified, the generated image will be no bigger than width x height,
	 * and will also have correct aspect ratio.
	 *
	 * @param integer $width	maximum width of the generated thumbnail
	 * @param integer $height	maximum height of the image (optional)
	 * @public
	 */
	function createThumb( $width, $height = -1 ) {
		$params = array( 'width' => $width );
		if ( $height != -1 ) {
			$params['height'] = $height;
		}
		$thumb = $this->transform( $params );
		if( is_null( $thumb ) || $thumb->isError() ) return '';
		return $thumb->getUrl();
	}

	/**
	 * As createThumb, but returns a ThumbnailImage object. This can
	 * provide access to the actual file, the real size of the thumb,
	 * and can produce a convenient <img> tag for you.
	 *
	 * For non-image formats, this may return a filetype-specific icon.
	 *
	 * @param integer $width	maximum width of the generated thumbnail
	 * @param integer $height	maximum height of the image (optional)
	 * @param boolean $render	True to render the thumbnail if it doesn't exist,
	 *                       	false to just return the URL
	 *
	 * @return ThumbnailImage or null on failure
	 * @public
	 *
	 * @deprecated use transform()
	 */
	function getThumbnail( $width, $height=-1, $render = true ) {
		$params = array( 'width' => $width );
		if ( $height != -1 ) {
			$params['height'] = $height;
		}
		$flags = $render ? self::RENDER_NOW : 0;
		return $this->transform( $params, $flags );
	}

	/**
	 * Transform a media file
	 *
	 * @param array $params An associative array of handler-specific parameters. Typical 
	 *                      keys are width, height and page.
	 * @param integer $flags A bitfield, may contain self::RENDER_NOW to force rendering
	 * @return MediaTransformOutput
	 */
	function transform( $params, $flags = 0 ) {
		global $wgUseSquid, $wgIgnoreImageErrors;

		wfProfileIn( __METHOD__ );
		do {
			if ( !$this->getHandler() || !$this->handler->canRender() ) {
				// not a bitmap or renderable image, don't try.
				$thumb = $this->iconThumb();
				break;
			}

			$script = $this->getTransformScript();
			if ( $script && !($flags & self::RENDER_NOW) ) {
				// Use a script to transform on client request
				$thumb = $this->handler->getScriptedTransform( $this, $script, $params );
				break;
			}

			$normalisedParams = $params;
			$this->handler->normaliseParams( $this, $normalisedParams );
			$thumbName = $this->thumbName( $normalisedParams );	
			$thumbPath = $this->getThumbPath( $thumbName );
			$thumbUrl = $this->getThumbUrl( $thumbName );

			if ( $this->repo->canTransformVia404() && !($flags & self::RENDER_NOW ) ) {
				$thumb = $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
				break;
			}

			wfDebug( "Doing stat for $thumbPath\n" );
			$this->migrateThumbFile( $thumbName );
			if ( file_exists( $thumbPath ) ) {
				$thumb = $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
				break;
			}
			$thumb = $this->handler->doTransform( $this, $thumbPath, $thumbUrl, $params );

			// Ignore errors if requested
			if ( !$thumb ) {
				$thumb = null;
			} elseif ( $thumb->isError() ) {
				$this->lastError = $thumb->toText();
				if ( $wgIgnoreImageErrors && !($flags & self::RENDER_NOW) ) {
					$thumb = $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
				}
			}
			
			if ( $wgUseSquid ) {
				wfPurgeSquidServers( array( $thumbUrl ) );
			}
		} while (false);

		wfProfileOut( __METHOD__ );
		return $thumb;
	}

	/** 
	 * Hook into transform() to allow migration of thumbnail files
	 * STUB
	 * Overridden by LocalFile
	 */
	function migrateThumbFile() {}

	/**
	 * Get a MediaHandler instance for this file
	 */
	function getHandler() { 
		if ( !isset( $this->handler ) ) {
			$this->handler = MediaHandler::getHandler( $this->getMimeType() );
		}
		return $this->handler;
	}

	/**
	 * Get a ThumbnailImage representing a file type icon
	 * @return ThumbnailImage
	 */
	function iconThumb() {
		global $wgStylePath, $wgStyleDirectory;

		$try = array( 'fileicon-' . $this->getExtension() . '.png', 'fileicon.png' );
		foreach( $try as $icon ) {
			$path = '/common/images/icons/' . $icon;
			$filepath = $wgStyleDirectory . $path;
			if( file_exists( $filepath ) ) {
				return new ThumbnailImage( $wgStylePath . $path, 120, 120 );
			}
		}
		return null;
	}

	/**
	 * Get last thumbnailing error.
	 * Largely obsolete.
	 */
	function getLastError() {
		return $this->lastError;
	}

	/**
	 * Get all thumbnail names previously generated for this file
	 * STUB
	 * Overridden by LocalFile
	 */
	function getThumbnails() { return array(); }

	/**
	 * Purge shared caches such as thumbnails and DB data caching
	 * STUB
	 * Overridden by LocalFile
	 */
	function purgeCache( $archiveFiles = array() ) {}

	/**
	 * Purge the file description page, but don't go after
	 * pages using the file. Use when modifying file history
	 * but not the current data.
	 */
	function purgeDescription() {
		$title = $this->getTitle();
		if ( $title ) {
			$title->invalidateCache();
			$title->purgeSquid();
		}
	}
	
	/**
	 * Purge metadata and all affected pages when the file is created,
	 * deleted, or majorly updated. A set of additional URLs may be
	 * passed to purge, such as specific file files which have changed.
	 * @param $urlArray array
	 */
	function purgeEverything( $urlArr=array() ) {
		// Delete thumbnails and refresh file metadata cache
		$this->purgeCache();
		$this->purgeDescription();

		// Purge cache of all pages using this file
		$title = $this->getTitle();
		if ( $title ) {
			$update = new HTMLCacheUpdate( $title, 'imagelinks' );
			$update->doUpdate();
		}
	}

	/**
	 * Return the history of this file, line by line. Starts with current version, 
	 * then old versions. Should return an object similar to an image/oldimage 
	 * database row.
	 *
	 * @public
	 * STUB
	 * Overridden in LocalFile
	 */
	function nextHistoryLine() {
		return false;
	}

	/**
	 * Reset the history pointer to the first element of the history
	 * @public
	 * STUB
	 * Overridden in LocalFile.
	 */
	function resetHistory() {}

	/**
	 * Get the filename hash component of the directory including trailing slash,
	 * e.g. f/fa/
	 * If the repository is not hashed, returns an empty string.
	 */
	function getHashPath() {
		if ( !isset( $this->hashPath ) ) {
			$this->hashPath = $this->repo->getHashPath( $this->getName() );
		}
		return $this->hashPath;
	}

	/**
	 * Get the path of the file relative to the public zone root
	 */
	function getRel() {
		return $this->getHashPath() . $this->getName();
	}

	/**
	 * Get urlencoded relative path of the file
	 */
	function getUrlRel() {
		return $this->getHashPath() . urlencode( $this->getName() );
	}

	/** Get the path of the archive directory, or a particular file if $suffix is specified */
	function getArchivePath( $suffix = false ) {
		$path = $this->repo->getZonePath('public') . '/archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= $suffix;
		}
		return $path;
	}

	/** Get the path of the thumbnail directory, or a particular file if $suffix is specified */
	function getThumbPath( $suffix = false ) {
		$path = $this->repo->getZonePath('public') . '/thumb/' . $this->getRel();
		if ( $suffix !== false ) {
			$path .= '/' . $suffix;
		}
		return $path;
	}

	/** Get the URL of the archive directory, or a particular file if $suffix is specified */
	function getArchiveUrl( $suffix = false ) {
		$path = $this->repo->getZoneUrl('public') . '/archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= urlencode( $suffix );
		}
		return $path;
	}

	/** Get the URL of the thumbnail directory, or a particular file if $suffix is specified */
	function getThumbUrl( $suffix = false ) {
		$path = $this->repo->getZoneUrl('public') . '/thumb/' . $this->getUrlRel();
		if ( $suffix !== false ) {
			$path .= '/' . urlencode( $suffix );
		}
		return $path;
	}

	/** Get the virtual URL for an archive file or directory */
	function getArchiveVirtualUrl( $suffix = false ) {
		$path = $this->repo->getVirtualUrl() . '/public/archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= urlencode( $suffix );
		}
		return $path;
	}

	/** Get the virtual URL for a thumbnail file or directory */
	function getThumbVirtualUrl( $suffix = false ) {
		$path = $this->repo->getVirtualUrl() . '/public/thumb/' . $this->getUrlRel();
		if ( $suffix !== false ) {
			$path .= '/' . urlencode( $suffix );
		}
		return $path;
	}

	/**
	 * @return bool
	 */
	function isHashed() {
		return $this->repo->isHashed();
	}

	function readOnlyError() {
		throw new MWException( get_class($this) . ': write operations are not supported' );
	}

	/**
	 * Record a file upload in the upload log and the image table
	 * STUB
	 * Overridden by LocalFile
	 */
	function recordUpload( $oldver, $desc, $license = '', $copyStatus = '', $source = '', $watch = false ) { 
		$this->readOnlyError(); 
	}

	/**
	 * Move or copy a file to its public location. If a file exists at the  
	 * destination, move it to an archive. Returns the archive name on success 
	 * or an empty string if it was a new file, and a wikitext-formatted 
	 * WikiError object on failure. 
	 *
	 * The archive name should be passed through to recordUpload for database
	 * registration.
	 *
	 * @param string $sourcePath Local filesystem path to the source image
	 * @param integer $flags A bitwise combination of:
	 *     File::DELETE_SOURCE    Delete the source file, i.e. move 
	 *         rather than copy
	 * @return The archive name on success or an empty string if it was a new 
	 *     file, and a wikitext-formatted WikiError object on failure. 
	 *
	 * STUB
	 * Overridden by LocalFile
	 */
	function publish( $srcPath, $flags = 0 ) {
		$this->readOnlyError();
	}

	/**
	 * Get an array of Title objects which are articles which use this file
	 * Also adds their IDs to the link cache
	 *
	 * This is mostly copied from Title::getLinksTo()
	 *
	 * @deprecated Use HTMLCacheUpdate, this function uses too much memory
	 */
	function getLinksTo( $options = '' ) {
		wfProfileIn( __METHOD__ );

		// Note: use local DB not repo DB, we want to know local links
		if ( $options ) {
			$db = wfGetDB( DB_MASTER );
		} else {
			$db = wfGetDB( DB_SLAVE );
		}
		$linkCache =& LinkCache::singleton();

		list( $page, $imagelinks ) = $db->tableNamesN( 'page', 'imagelinks' );
		$encName = $db->addQuotes( $this->getName() );
		$sql = "SELECT page_namespace,page_title,page_id FROM $page,$imagelinks WHERE page_id=il_from AND il_to=$encName $options";
		$res = $db->query( $sql, __METHOD__ );

		$retVal = array();
		if ( $db->numRows( $res ) ) {
			while ( $row = $db->fetchObject( $res ) ) {
				if ( $titleObj = Title::makeTitle( $row->page_namespace, $row->page_title ) ) {
					$linkCache->addGoodLinkObj( $row->page_id, $titleObj );
					$retVal[] = $titleObj;
				}
			}
		}
		$db->freeResult( $res );
		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	function getExifData() {
		if ( !$this->getHandler() || $this->handler->getMetadataType( $this ) != 'exif' ) {
			return array();
		}
		$metadata = $this->getMetadata();
		if ( !$metadata ) {
			return array();
		}
		$exif = unserialize( $metadata );
		if ( !$exif ) {
			return array();
		}
		unset( $exif['MEDIAWIKI_EXIF_VERSION'] );
		$format = new FormatExif( $exif );

		return $format->getFormattedData();
	}

	/**
	 * Returns true if the file comes from the local file repository.
	 *
	 * @return bool
	 */
	function isLocal() { 
		return $this->repo && $this->repo->getName() == 'local'; 
	}

	/**
	 * Returns true if the image is an old version
	 * STUB
	 */
	function isOld() {
		return false;
	}

	/**
	 * Is this file a "deleted" file in a private archive?
	 * STUB
	 */
	function isDeleted( $field ) {
		return false;
	}

	/**
	 * Was this file ever deleted from the wiki?
	 *
	 * @return bool
	 */
	function wasDeleted() {
		$title = $this->getTitle();
		return $title && $title->isDeleted() > 0;
	}

	/**
	 * Delete all versions of the file.
	 *
	 * Moves the files into an archive directory (or deletes them)
	 * and removes the database rows.
	 *
	 * Cache purging is done; logging is caller's responsibility.
	 *
	 * @param $reason
	 * @return true on success, false on some kind of failure
	 * STUB
	 * Overridden by LocalFile
	 */
	function delete( $reason, $suppress=false ) {
		$this->readOnlyError();
	}

	/**
	 * Restore all or specified deleted revisions to the given file.
	 * Permissions and logging are left to the caller.
	 *
	 * May throw database exceptions on error.
	 *
	 * @param $versions set of record ids of deleted items to restore,
	 *                    or empty to restore all revisions.
	 * @return the number of file revisions restored if successful,
	 *         or false on failure
	 * STUB
	 * Overridden by LocalFile
	 */
	function restore( $versions=array(), $Unsuppress=false ) {
		$this->readOnlyError();
	}

	/**
	 * Returns 'true' if this image is a multipage document, e.g. a DJVU
	 * document.
	 *
	 * @return Bool
	 */
	function isMultipage() {
		return $this->getHandler() && $this->handler->isMultiPage();
	}

	/**
	 * Returns the number of pages of a multipage document, or NULL for
	 * documents which aren't multipage documents
	 */
	function pageCount() {
		if ( !isset( $this->pageCount ) ) {
			if ( $this->getHandler() && $this->handler->isMultiPage() ) {
				$this->pageCount = $this->handler->pageCount( $this );
			} else {
				$this->pageCount = false;
			}
		}
		return $this->pageCount;
	}

	/**
	 * Calculate the height of a thumbnail using the source and destination width
	 */
	static function scaleHeight( $srcWidth, $srcHeight, $dstWidth ) {
		// Exact integer multiply followed by division
		if ( $srcWidth == 0 ) {
			return 0;
		} else {
			return round( $srcHeight * $dstWidth / $srcWidth );
		}
	}
	
	/**
	 * Get an image size array like that returned by getimagesize(), or false if it 
	 * can't be determined.
	 *
	 * @param string $fileName The filename
	 * @return array
	 */
	function getImageSize( $fileName ) {
		if ( !$this->getHandler() ) {
			return false;
		}
		return $this->handler->getImageSize( $this, $fileName );
	}

	/**
	 * Get the URL of the image description page. May return false if it is
	 * unknown or not applicable.
	 */
	function getDescriptionUrl() {
		return $this->repo->getDescriptionUrl( $this->getName() );
	}

	/**
	 * Get the HTML text of the description page, if available
	 */
	function getDescriptionText() {
		if ( !$this->repo->fetchDescription ) {
			return false;
		}
		$renderUrl = $this->repo->getDescriptionRenderUrl( $this->getName() );
		if ( $renderUrl ) {
			wfDebug( "Fetching shared description from $renderUrl\n" );
			return Http::get( $renderUrl );
		} else {
			return false;
		}
	}

	/**
	 * Get the 14-character timestamp of the file upload, or false if 
	 */
	function getTimestmap() {
		$path = $this->getPath();
		if ( !file_exists( $path ) ) {
			return false;
		}
		return wfTimestamp( filemtime( $path ) );
	}
	
	/**
	 * Determine if the current user is allowed to view a particular
	 * field of this file, if it's marked as deleted.
	 * STUB
	 * @param int $field					
	 * @return bool
	 */
	function userCan( $field ) {
		return true;
	}
}

?>
