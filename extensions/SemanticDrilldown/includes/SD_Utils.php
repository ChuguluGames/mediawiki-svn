<?php
/**
 * A class for static helper functions for Semantic Drilldown
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SDUtils {

	/**
	* Function to return the Property based on the xml passed from the PageSchema extension
	*/
	public static function createPageSchemasObject( $objectName, $xmlForField, &$object ) {
		$sdarray = array();
		if ( $objectName == "semanticdrilldown_Filter" ) {
			foreach ( $xmlForField->children() as $tag => $child ) {
				if ( $tag == $objectName ) {
					foreach ( $child->children() as $prop => $value) {
						if( $prop == "Values" ){
							$l_values = array();
							foreach ( $value->children() as $val_i => $val ) {
								$l_values[] = (string)$val;
							}
							$sdarray['Values'] = $l_values;
						} else {
							$sdarray[$prop] = (string)$value;
						}
					}
				}
			}
			$object['sd'] = $sdarray;
		}
		return true;
	}

	public static function getFieldHTMLForPS( $field, &$text_extensions ){
		//$property_label = wfMsg( 'sd_createfilter_property' );
		//$label_label = wfMsg( 'sd_createfilter_label' );
		// need both label and value, in case user's language is different
		// from wiki's
		//$require_filter_label = wfMsg( 'sd_createfilter_requirefilter' );

		if ( !is_null( $field ) ) {
			$sd_array = $field->getObject('semanticdrilldown_Filter');
			$filter_array = $sd_array['sd'];
		} else {
			$filter_array = array();
		}

		$html_text = '<p>' . wfMsg( 'sd_createfilter_name' ) . ' <input size="25" name="sd_filter_name_num" value="' . $filter_array['Label'] . '" ></p>';
		$html_text .= '<p><input type="radio" name="sd_values_source_num" checked value="property"> '.
				wfMsg( 'sd_createfilter_usepropertyvalues' ) . "</p>\n";
		$html_text .= "\t<p>\n";
		$fromCategoryAttrs = array();
		if ( $filter_array['ValuesFromCategory'] != null ) {
			$selectedCategory = $filter_array['ValuesFromCategory'];
			$fromCategoryAttrs['checked'] = true;
		} else {
			$selectedCategory = '';
		}
		$html_text .= Html::input( 'sd_values_source_num', 'category', 'radio', $fromCategoryAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_usecategoryvalues' ) . "\n";
		$categories = SDUtils::getTopLevelCategories();
		$option_html_text = "";
		foreach ( $categories as $category ) {
			$category = str_replace( '_', ' ', $category );
			if ( $category == $selectedCategory) {
				$option_html_text .= '	<option selected>' . $category . "</option>\n";
			} else {
				$option_html_text .= '	<option>' . $category . "</option>\n";
			}
		}
		$html_text .= "\t" . '<select id="category_dropdown" name="sd_category_name_num">' . "\n";
		$html_text .= $option_html_text;
		$html_text .= '</select></p>';

		$html_text .= "\t<p>\n";
		$dateRangesAttrs = array();
		if ( array_key_exists( 'TimePeriod', $filter_array ) ) {
			$dateRangesAttrs['checked'] = true;
		}
		$html_text .= "\t" . Html::input( 'sd_values_source_num', 'dates', 'radio', $dateRangesAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_usedatevalues' ) . "\n";
		$html_text .= '<select id="time_period_dropdown" name="sd_time_period_num">' . "\n";

		$year_value = wfMsgForContent( 'sd_filter_year' );
		$yearOptionAttrs = array( 'value' => $year_value );
		$month_value = wfMsgForContent( 'sd_filter_month' );
		$monthOptionAttrs = array( 'value' => $month_value );
		if ( $filter_array["TimePeriod"] != null ) {
			if ( $filter_array['TimePeriod'] == $year_value ) {
				$yearOptionAttrs['selected'] = true;
			} else {
				$monthOptionAttrs['selected'] = true;
			}
		}
		$html_text .= Html::element( 'option', $yearOptionAttrs, wfMsg( 'sd_filter_year' ) ) . "\n";
		$html_text .= Html::element( 'option', $monthOptionAttrs, wfMsg( 'sd_filter_month' ) ) . "\n";
		$html_text .= '</select>
			</p>
			<p>';
		$manualSourceAttrs = array();
		$filterValuesAttrs = array( 'size' => 40 );
		if ( !is_null( $filter_array['Values'] ) ) {
			$manualSourceAttrs['checked'] = true;
			$values_array = $filter_array['Values'];
			$filterValuesStr = implode( ', ', $values_array );
		}
		$html_text .= "\t" . Html::input( 'sd_values_source_num', 'manual', 'radio', $manualSourceAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_entervalues' ) . "\n";
		$html_text .= "\t" . Html::input( 'sd_filter_values_num', $filterValuesStr, 'text', $filterValuesAttrs ) . "\n";
		$html_text .= "\t</p>\n";
		$html_text .= '<p>' . wfMsg( 'sd_createfilter_inputtype' ) . '
			<select id="input_type_dropdown" name="sd_input_type_num">' . "\n";

		$input_type_val = $filter_array['InputType'];
		$combo_box_value = wfMsgForContent( 'sd_filter_combobox' );
		$date_range_value = wfMsgForContent( 'sd_filter_daterange' );
		$valuesListAttrs = array( 'value' => '' );
		$comboBoxAttrs = array( 'value' => $combo_box_value );
		$dateRangeAttrs = array( 'value' => $date_range_value );
		if ( $input_type_val == $combo_box_value ) {
			$comboBoxAttrs['selected'] = true;
		} elseif ( $input_type_val == $date_range_value ) {
			$dateRangeAttrs['selected'] = true;
		} else {
			$valuesListAttrs['selected'] = true;
		}
		$html_text .= "\t" . Html::element( 'option', $valuesListAttrs, wfMsg( 'sd_createfilter_listofvalues' ) ) . "\n";
		$html_text .= "\t" . Html::element( 'option', $comboBoxAttrs, wfMsg( 'sd_filter_combobox' ) ) . "\n";
		$html_text .= "\t" . Html::element( 'option', $dateRangeAttrs, wfMsg( 'sd_filter_daterange' ) ) . "\n";
		$html_text .= <<<END
			</select>
			</p>

END;

		$text_extensions['sd'] = array( 'Filter', '#FDD', $html_text );

		return true;
	}

	public static function getFieldXMLForPS( $request, &$xmlArray ) {
		$templateNum = -1;
		$xmlPerField = array();
		foreach ( $request->getValues() as $var => $val ) {
			if ( substr( $var, 0, 15 ) == 'sd_filter_name_' ) {
				$xml = '<semanticdrilldown_Filter>';
				$templateNum = substr( $var, 15 );
				$xml .= '<Label>'.$val.'</Label>';
			} elseif ( substr( $var, 0, 17 ) == 'sd_values_source_') {
				if ( $val == 'category' ) {
					$xml .= '<ValuesFromCategory>' . $request->getText('sd_category_name_' . $templateNum) . '</ValuesFromCategory>';
				} elseif ( $val == 'dates' ) {
					 $xml .= '<TimePeriod>' . $request->getText('sd_time_period_' . $templateNum) . '</TimePeriod>';
				} elseif ( $val == 'manual' ) {
					$filter_manual_values_str = $request->getText('sd_filter_values_'.$templateNum);
					// replace the comma substitution character that has no chance of
					// being included in the values list - namely, the ASCII beep
					$listSeparator = ',';
					$filter_manual_values_str = str_replace( "\\$listSeparator", "\a", $filter_manual_values_str );
					$filter_manual_values_array = explode( $listSeparator, $filter_manual_values_str );
					$xml .= '<Values>';
					foreach ( $filter_manual_values_array as $i => $value ) {
						// replace beep back with comma, trim
						$value = str_replace( "\a", $listSeparator, trim( $value ) );
						$xml .= '<Value>'.$value.'</Value>';
					}
					$xml .= '</Values>';
				}
			} elseif ( substr( $var, 0, 14 ) == 'sd_input_type_' ) {
				$xml .= '<InputType>' . $val . '</InputType>';
				$xml .= '</semanticdrilldown_Filter>';
				$xmlPerField[] = $xml;
			}
		}

		$xmlArray['sd'] = $xmlPerField;
		return true;
	}

	/**
	 * This function parses the Field elements in the xml of the pages. Hooks for Page Schemas extension
	 */
	public static function parseFieldElements( $field_xml, &$text_object ) {
		foreach ( $field_xml->children() as $tag => $child ) {
			if ( $tag == "semanticdrilldown_Filter" ) {
				$text = "";
				$text = PageSchemas::tableMessageRowHTML( "paramAttr", "SemanticDrillDown", (string)$tag );
				foreach ( $child->children() as $prop => $value) {
					if( $prop == "Values" ){
						$l_values = "";
						foreach ( $value->children() as $val_i => $val ) {
							$l_values .= $val.", ";
						}
						$text .= PageSchemas::tableMessageRowHTML("paramAttrMsg", $prop, $l_values );
					} else {
						$text .= PageSchemas::tableMessageRowHTML("paramAttrMsg", $prop, $value );
					}
				}
				$text_object['sd']=$text;
			}
		}
		return true;
	}


	/**
	 * Helper function to handle getPropertyValues() in both SMW 1.6
	 * and earlier versions.
	 */
	public static function getSMWPropertyValues( $store, $pageName, $pageNamespace, $propID, $requestOptions = null ) {
		// SMWDIProperty was added in SMW 1.6
		if ( class_exists( 'SMWDIProperty' ) ) {
			$pageName = str_replace( ' ', '_', $pageName );
			$page = new SMWDIWikiPage( $pageName, $pageNamespace, null );
			$property = new SMWDIProperty( $propID );
			return $store->getPropertyValues( $page, $property, $requestOptions );
		} else {
			$title = Title::makeTitleSafe( $pageNamespace, $pageName );
			$property = SMWPropertyValue::makeProperty( $propID );
			return $store->getPropertyValues( $title, $property, $requestOptions );
		}
	}

	/**
	 * Gets a list of the names of all categories in the wiki that aren't
	 * children of some other category - this list additionally includes,
	 * and excludes, categories that are manually set with
	 * 'SHOWINDRILLDOWN' and 'HIDEFROMDRILLDOWN', respectively.
	 */
	static function getTopLevelCategories() {
		$categories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'page', 'categorylinks', 'page_props' ) );
		$cat_ns = NS_CATEGORY;
		$sql = "SELECT page_title FROM $page p LEFT OUTER JOIN $categorylinks cl ON p.page_id = cl.cl_from WHERE p.page_namespace = $cat_ns AND cl.cl_to IS NULL";
		$res = $dbr->query( $sql );
		if ( $dbr->numRows( $res ) > 0 ) {
			while ( $row = $dbr->fetchRow( $res ) ) {
				$categories[] = str_replace( '_', ' ', $row[0] );
			}
		}
		$dbr->freeResult( $res );

		// get 'hide' and 'show' categories
		$hidden_cats = $shown_cats = array();
		$sql2 = "SELECT p.page_title, pp.pp_propname FROM $page p JOIN $page_props pp ON p.page_id = pp.pp_page WHERE p.page_namespace = $cat_ns AND (pp.pp_propname = 'hidefromdrilldown' OR pp.pp_propname = 'showindrilldown') AND pp.pp_value = 'y'";
		$res2 = $dbr->query( $sql2 );
		if ( $dbr->numRows( $res2 ) > 0 ) {
			while ( $row = $dbr->fetchRow( $res2 ) ) {
				if ( $row[1] == 'hidefromdrilldown' )
					$hidden_cats[] = str_replace( '_', ' ', $row[0] );
				else
					$shown_cats[] = str_replace( '_', ' ', $row[0] );
			}
		}
		$dbr->freeResult( $res2 );
		$categories = array_merge( $categories, $shown_cats );
		foreach ( $hidden_cats as $hidden_cat ) {
			foreach ( $categories as $i => $cat ) {
				if ( $cat == $hidden_cat ) {
					unset( $categories[$i] );
				}
			}
		}
		sort( $categories );
		return $categories;
	}

	/**
	 * Gets a list of the names of all properties in the wiki
	 */
	static function getSemanticProperties() {
		global $smwgContLang;
		$smw_namespace_labels = $smwgContLang->getNamespaces();
		$all_properties = array();

		$options = new SMWRequestOptions();
		$options->limit = 10000;
		$used_properties = smwfGetStore()->getPropertiesSpecial( $options );
		foreach ( $used_properties as $property ) {
			if ( $property[0] instanceof SMWDIProperty ) {
				// SMW 1.6+
				$propName = $property[0]->getKey();
				if ( $propName{0} != '_' ) {
					$all_properties[] = str_replace( '_', ' ', $propName );
				}
			} else {
				$all_properties[] = $property[0]->getWikiValue();
			}
		}
		$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial( $options );
		foreach ( $unused_properties as $property ) {
			if ( $property instanceof SMWDIProperty ) {
				// SMW 1.6+
				$all_properties[] = str_replace( '_', ' ', $property->getKey() );
			} else {
				$all_properties[] = $property->getWikiValue();
			}
		}
		// remove the special properties of Semantic Drilldown from this list...
		global $sdgContLang;
		$sd_props = $sdgContLang->getPropertyLabels();
		$sd_prop_aliases = $sdgContLang->getPropertyAliases();
		foreach ( $all_properties as $i => $prop_name ) {
			foreach ( $sd_props as $prop => $label ) {
				if ( $prop_name == $label ) {
					unset( $all_properties[$i] );
				}
			}
			foreach ( $sd_prop_aliases as $alias => $cur_prop ) {
				if ( $prop_name == $alias ) {
					unset( $all_properties[$i] );
				}
			}
		}
		sort( $all_properties );
		return $all_properties;
	}

	/**
	 * Gets the names of all the filter pages, i.e. pages in the Filter
	 * namespace
	 */
	static function getFilters() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page', 'page_title', array( 'page_namespace' => SD_NS_FILTER ) );
		$filters = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$filters[] = $row[0];
		}
		$dbr->freeResult( $res );
		return $filters;
	}

	/**
	 * Generic static function - gets all the values that a specific page
	 * points to with a specific property
	 */
	static function getValuesForProperty( $subject, $subject_namespace, $special_prop ) {
		$store = smwfGetStore();
		$res = self::getSMWPropertyValues( $store, $subject, $subject_namespace, $special_prop );
		$values = array();
		foreach ( $res as $prop_val ) {
			// depends on version of SMW
			if ( $prop_val instanceof SMWDIWikiPage ) {
				$actual_val = $prop_val->getDBkey();
			} elseif ( $prop_val instanceof SMWDIString ) {
				$actual_val = $prop_val->getString();
			} elseif ( method_exists( $prop_val, 'getValueKey' ) ) {
				$actual_val = $prop_val->getValueKey();
			} else {
				$actual_val = $prop_val->getXSDValue();
			}
			$values[] = html_entity_decode( str_replace( '_', ' ', $actual_val ) );
		}
		return $values;
	}

	/**
	 * Gets all the filters specified for a category.
	 */
	static function loadFiltersForCategory( $category ) {
		$filters = array();
		$filters_ps = array();
		$filter_names = SDUtils::getValuesForProperty( str_replace( ' ', '_', $category ), NS_CATEGORY, '_SD_F' );
		foreach ( $filter_names as $filter_name ) {
			$filters[] = SDFilter::load( $filter_name );
		}
		//Code to read from the pageSchema and return filters
		if ( class_exists( 'PSSchema' ) ) {
			$pageSchemaObj = new PSSchema( $category );
			if($pageSchemaObj->isPSDefined()){
				$filters_ps = SDFilter::loadAllFromPageSchema( $pageSchemaObj );
				$result_filters = array_merge($filters, $filters_ps);
				return $result_filters;
			}
		}
		return $filters;
	}

	/**
	 * Gets all the display parameters defined for a category
	 */
	static function getDisplayParamsForCategory( $category ) {
		$all_display_params = SDUtils::getValuesForProperty( str_replace( ' ', '_', $category ), NS_CATEGORY, '_SD_DP' );

		$return_display_params = array();
		foreach ( $all_display_params as $display_params ) {
			$return_display_params[] = explode( ';', $display_params );
		}
		return $return_display_params;
	}

	static function getCategoryChildren( $category_name, $get_categories, $levels ) {
		if ( $levels == 0 ) {
			return array();
		}
		$pages = array();
		$subcategories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'page', 'categorylinks' ) );
		$cat_ns = NS_CATEGORY;
		$query_category = str_replace( ' ', '_', $category_name );
		$query_category = str_replace( "'", "\'", $query_category );
		$sql = "SELECT p.page_title, p.page_namespace FROM $categorylinks cl
	JOIN $page p on cl.cl_from = p.page_id
	WHERE cl.cl_to = '$query_category'\n";
		if ( $get_categories )
			$sql .= "AND p.page_namespace = $cat_ns\n";
		$sql .= "ORDER BY cl.cl_sortkey";
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $get_categories ) {
				$subcategories[] = $row[0];
				$pages[] = $row[0];
			} else {
				if ( $row[1] == $cat_ns )
					$subcategories[] = $row[0];
				else
					$pages[] = $row[0];
			}
		}
		$dbr->freeResult( $res );
		foreach ( $subcategories as $subcategory ) {
			$pages = array_merge( $pages, SDUtils::getCategoryChildren( $subcategory, $get_categories, $levels - 1 ) );
		}
		return $pages;
	}

	static function monthToString( $month ) {
		if ( $month == 1 ) {
			return wfMsg( 'january' );
		} elseif ( $month == 2 ) {
			return wfMsg( 'february' );
		} elseif ( $month == 3 ) {
			return wfMsg( 'march' );
		} elseif ( $month == 4 ) {
			return wfMsg( 'april' );
		} elseif ( $month == 5 ) {
			// Needed to avoid using 3-letter abbreviation
			return wfMsg( 'may_long' );
		} elseif ( $month == 6 ) {
			return wfMsg( 'june' );
		} elseif ( $month == 7 ) {
			return wfMsg( 'july' );
		} elseif ( $month == 8 ) {
			return wfMsg( 'august' );
		} elseif ( $month == 9 ) {
			return wfMsg( 'september' );
		} elseif ( $month == 10 ) {
			return wfMsg( 'october' );
		} elseif ( $month == 11 ) {
			return wfMsg( 'november' );
		} else { // if ($month == 12) {
			return wfMsg( 'december' );
		}
	}

	static function stringToMonth( $str ) {
		if ( $str == wfMsg( 'january' ) ) {
			return 1;
		} elseif ( $str == wfMsg( 'february' ) ) {
			return 2;
		} elseif ( $str == wfMsg( 'march' ) ) {
			return 3;
		} elseif ( $str == wfMsg( 'april' ) ) {
			return 4;
		} elseif ( $str == wfMsg( 'may_long' ) ) {
			return 5;
		} elseif ( $str == wfMsg( 'june' ) ) {
			return 6;
		} elseif ( $str == wfMsg( 'july' ) ) {
			return 7;
		} elseif ( $str == wfMsg( 'august' ) ) {
			return 8;
		} elseif ( $str == wfMsg( 'september' ) ) {
			return 9;
		} elseif ( $str == wfMsg( 'october' ) ) {
			return 10;
		} elseif ( $str == wfMsg( 'november' ) ) {
			return 11;
		} else { // if ($strmonth == wfMsg('december')) {
			return 12;
		}
	}

	static function booleanToString( $bool_value ) {
		if ( function_exists( 'wfLoadExtensionMessages' ) ) {
			wfLoadExtensionMessages( 'SemanticMediaWiki' );
		}
		$words_field_name = ( $bool_value == true ) ? 'smw_true_words' : 'smw_false_words';
		$words_array = explode( ',', wfMsgForContent( $words_field_name ) );
		// go with the value in the array that tends to be "yes" or
		// "no", which is the 3rd
		$index_of_word = 2;
		// capitalize first letter of word
		if ( count( $words_array ) > $index_of_word ) {
			$string_value = ucwords( $words_array[$index_of_word] );
		} elseif ( count( $words_array ) == 0 ) {
			$string_value = $bool_value; // a safe value if no words are found
		} else {
			$string_value = ucwords( $words_array[0] );
		}
		return $string_value;
	}

	/**
	 * Prints the mini-form contained at the bottom of various pages, that
	 * allows pages to spoof a normal edit page, that can preview, save,
	 * etc.
	 */
	static function printRedirectForm( $title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this ) {
		$article = new Article( $title );
		$new_url = $title->getLocalURL( 'action=submit' );
		$starttime = wfTimestampNow();
		$edittime = $article->getTimestamp();
		global $wgUser;
		if ( $wgUser->isLoggedIn() )
			$token = htmlspecialchars( $wgUser->editToken() );
		else
			$token = EDIT_TOKEN_SUFFIX;

		if ( $is_save )
			$action = "wpSave";
		elseif ( $is_preview )
			$action = "wpPreview";
		else // $is_diff
			$action = "wpDiff";

		$text = <<<END
	<form id="editform" name="editform" method="post" action="$new_url">
	<input type="hidden" name="wpTextbox1" id="wpTextbox1" value="$page_contents" />
	<input type="hidden" name="wpSummary" value="$edit_summary" />
	<input type="hidden" name="wpStarttime" value="$starttime" />
	<input type="hidden" name="wpEdittime" value="$edittime" />
	<input type="hidden" name="wpEditToken" value="$token" />
	<input type="hidden" name="$action" />

END;
		if ( $is_minor_edit )
			$text .= '    <input type="hidden" name="wpMinoredit">' . "\n";
		if ( $watch_this )
			$text .= '    <input type="hidden" name="wpWatchthis">' . "\n";
		$text .= <<<END
	</form>
	<script type="text/javascript">
	document.editform.submit();
	</script>

END;
		return $text;
	}

	/**
	 * Register magic-word variable IDs
	 */
	static function addMagicWordVariableIDs( &$magicWordVariableIDs ) {
		$magicWordVariableIDs[] = 'MAG_HIDEFROMDRILLDOWN';
		$magicWordVariableIDs[] = 'MAG_SHOWINDRILLDOWN';
		return true;
	}

	/**
	 * Set the actual value of the magic words
	 */
	static function addMagicWordLanguage( &$magicWords, $langCode ) {
		switch( $langCode ) {
		default:
			$magicWords['MAG_HIDEFROMDRILLDOWN'] = array( 0, '__HIDEFROMDRILLDOWN__' );
			$magicWords['MAG_SHOWINDRILLDOWN'] = array( 0, '__SHOWINDRILLDOWN__' );
		}
		return true;
	}

	/**
	 * Set values in the page_props table based on the presence of the
	 * 'HIDEFROMDRILLDOWN' and 'SHOWINDRILLDOWN' magic words in a page
	 */
	static function handleShowAndHide( &$parser, &$text ) {
		global $wgOut, $wgAction;
		$mw_hide = MagicWord::get( 'MAG_HIDEFROMDRILLDOWN' );
		if ( $mw_hide->matchAndRemove( $text ) ) {
			$parser->mOutput->setProperty( 'hidefromdrilldown', 'y' );
		}
		$mw_show = MagicWord::get( 'MAG_SHOWINDRILLDOWN' );
		if ( $mw_show->matchAndRemove( $text ) ) {
			$parser->mOutput->setProperty( 'showindrilldown', 'y' );
		}
		return true;
	}

	public static function addToAdminLinks( &$admin_links_tree ) {
		$browse_search_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_browsesearch' ) );
		$sd_row = new ALRow( 'sd' );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'BrowseData' ) );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'Filters' ) );
		$sd_row->addItem( ALItem::newFromSpecialPage( 'CreateFilter' ) );
		$sd_name = wfMsg( 'specialpages-group-sd_group' );
		$sd_docu_label = wfMsg( 'adminlinks_documentation', $sd_name );
		$sd_row->addItem( AlItem::newFromExternalLink( "http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown", $sd_docu_label ) );

		$browse_search_section->addRow( $sd_row );

		return true;
	}
}
