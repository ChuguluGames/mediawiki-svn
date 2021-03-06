<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * A base class for parsing, checking ans visualisation of _mixed_ tabular questions in
 * declaration/voting mode (UI input/output)
 */
class qp_MixedQuestion extends qp_TabularQuestion {

	/**
	 * Creates question view which should be renreded and
	 * also may be altered during the poll generation
	 */
	function parseBody() {
		# Parameters used in some special cases.
		$this->mProposalPattern = '`^';
		foreach ( $this->mCategories as $catDesc ) {
			$this->mProposalPattern .= '(\[\]|\(\)|<>)';
		}
		$this->mProposalPattern .= '(.*)`u';
		$proposalId = -1;
		foreach ( $this->raws as $raw ) {
			# empty proposal text and row
			$text = null;
			$row = Array();
			if ( preg_match( $this->mProposalPattern, $raw, $matches ) ) {
				$text = array_pop( $matches ); // current proposal text
				array_shift( $matches ); // remove "at whole" match
				$last_matches = $matches;
			} else {
				if ( $proposalId >= 0 ) {
					# shortened syntax: use the pattern from the last row where it's been defined
					$text = $raw;
					$matches = $last_matches;
				}
			}
			if ( $text === null ) {
				continue;
			}
			$proposalId++;
			$this->view->initProposalView();
			$this->mProposalText[ $proposalId ] = trim( $text );
			# Determine a type ID, according to the questionType and the number of signes.
			foreach ( $this->mCategories as $catId => $catDesc ) {
				$typeId  = $matches[ $catId ];
				$row[ $catId ] = Array();
				$inp = Array( '__tag' => 'input' );
				# Determine the input's name and value.
				switch ( $typeId ) {
					case '<>':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = '';
						$inputType = 'text';
						break;
					case '[]':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = 's' . $catId;
						$inputType = 'checkbox';
						break;
					case '()':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = 's' . $catId;
						$inputType = 'radio';
						break;
				}
				# Determine if the input has to be checked.
				$input_checked = false;
				$text_answer = '';
				if ( $this->poll->mBeingCorrected && $this->mRequest->getVal( $name ) !== null ) {
					if ( $inputType == 'text' ) {
						$text_answer = trim( $this->mRequest->getText( $name ) );
						if ( strlen( $text_answer ) > qp_Setup::MAX_TEXT_ANSWER_LENGTH ) {
							$text_answer = substr( $text_answer, 0, qp_Setup::MAX_TEXT_ANSWER_LENGTH );
						}
						if ( $text_answer != '' ) {
							$input_checked = true;
						}
					} else {
						$inp[ 'checked' ] = 'checked';
						$input_checked = true;
					}
				}
				if ( ( $prev_text_answer = $this->answerExists( $inputType, $proposalId, $catId ) ) !== false ) {
					$input_checked = true;
					if ( $inputType == 'text' ) {
						$text_answer = $prev_text_answer;
					} else {
						$inp[ 'checked' ] = 'checked';
					}
				}
				if ( $input_checked === true ) {
					# add category to the list of user answers for current proposal (row)
					$this->mProposalCategoryId[ $proposalId ][] = $catId;
					$this->mProposalCategoryText[ $proposalId ][] = $text_answer;
				}
				$row[ $catId ][ 'class' ] = 'sign';
				# unique (question,proposal,category) "coordinate" for javascript
				$inp[ 'id' ] = 'mx' . $this->mQuestionId . 'p' . $proposalId . 'c' . $catId;
				$inp[ 'class' ] = 'check';
				$inp[ 'type' ] = $inputType;
				$inp[ 'name' ] = $name;
				if ( $inputType == 'text' ) {
					$inp[ 'value' ] = qp_Setup::specialchars( $text_answer );
					if ( $this->view->textInputStyle != '' ) {
						$inp[ 'style' ] = $this->view->textInputStyle;
					}
				} else {
					$inp[ 'value' ] = $value;
				}
				if ( $this->view->showResults['type'] != 0 ) {
					# there ars some stat in row (not necessarily all cells, because size of question table changes dynamically)
					$row[ $catId ][ 0 ] = $this->view->addShowResults( $inp, $proposalId, $catId );
				} else {
					$row[ $catId ][ 0 ] = $inp;
				}
			}
			try {
				# if there is only one category defined and it is not a textfield,
				# the question has a syntax error
				if ( count( $matches ) < 2 && $matches[0] != '<>' ) {
					$text = $this->view->bodyErrorMessage( wfMsg( 'qp_error_too_few_categories' ), 'error' );
					throw new Exception( 'qp_error' );
				}
				# If the proposal text is empty, the question has a syntax error.
				if ( trim( $text ) == '' ) {
					$text = $this->view->bodyErrorMessage( wfMsg( 'qp_error_proposal_text_empty' ), 'error' );
					throw new Exception( 'qp_error' );
				}
				# If the proposal was submitted but unanswered
				if ( $this->poll->mBeingCorrected && !array_key_exists( $proposalId, $this->mProposalCategoryId ) ) {
					$prev_state = $this->getState();
					$text = $this->view->bodyErrorMessage( wfMsg( 'qp_error_no_answer' ), 'NA' ) . $text;
					# if there was no previous errors, hightlight the whole row
					if ( $prev_state == '' ) {
						throw new Exception( 'qp_error' );
					}
				}
			} catch ( Exception $e ) {
				if ( $e->getMessage() == 'qp_error' ) {
					foreach ( $row as &$cell ) {
						QP_Renderer::addClass( $cell, 'error' );
					}
				} else {
					throw new MWException( $e->getMessage() );
				}
			}
			$this->view->addProposal( $proposalId, $text, $row );
		}
	}

} /* end of qp_MixedQuestion class */
