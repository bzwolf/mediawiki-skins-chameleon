<?php
/**
 * File holding the MenuFactory class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Menu;

/**
 * Class MenuFactory
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class MenuFactory {

	/**
	 * @param \Message|string|string[] $message
	 * @param bool                     $forContent
	 *
	 * @throws \MWException
	 *
	 * @return Menu
	 */
	public function getMenuFromMessage( $message, $forContent = false ) {

		if ( is_string( $message ) || is_array( $message ) ) {
			$message = \Message::newFromKey( $message );
		}

		if ( !is_a( $message, '\\Message' ) ) {
			throw new \MWException( 'String, array of strings or Message object expected. Got ' . is_object( $message ) ? get_class( $message ) : gettype( $message ) . '.' );
		}

		if ( $forContent ) {
			$message = $message->inContentLanguage();
		}

		if ( !$message->exists() ) {
			return $this->getMenuFromMessageText( '', $forContent );
		}

		return $this->getMenuFromMessageText( $message->text(), $forContent );
	}

	/**
	 * @param string $text
	 * @param bool   $forContent
	 *
	 * @return Menu
	 * @throws \MWException
	 */
	public function getMenuFromMessageText( $text, $forContent = false ) {

		if ( !is_string( $text ) ) {
			throw new \MWException( 'String expected. Got ' . is_object( $text ) ? get_class( $text ) : gettype( $text ) . '.' );
		}

		$lines = explode( "\n", trim( $text ) );

		return new MenuFromLines( $lines, $forContent );
	}
}
