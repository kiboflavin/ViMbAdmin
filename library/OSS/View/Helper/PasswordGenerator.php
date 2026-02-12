<?php
/**
 * OSS Framework
 *
 * This file is part of the "OSS Framework" - a library of tools, utilities and
 * extensions to the Zend Framework V1.x used for PHP application development.
 *
 * Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * All rights reserved.
 *
 * Open Source Solutions Limited is a company registered in Dublin,
 * Ireland with the Companies Registration Office (#438231). We
 * trade as Open Solutions with registered business name (#329120).
 *
 * Contact: Barry O'Donovan - info (at) opensolutions (dot) ie
 *          http://www.opensolutions.ie/
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * It is also available through the world-wide-web at this URL:
 *     http://www.opensolutions.ie/licenses/new-bsd
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@opensolutions.ie so we can send you a copy immediately.
 *
 * @category   OSS
 * @package    OSS_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */
/**
 * Abstract class for extension
 */
require_once 'Zend/View/Helper/FormElement.php';

/**
 * Helper to render password generator button element.
 *
 * @category   OSS
 * @package    OSS_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */
class OSS_View_Helper_PasswordGenerator extends Zend_View_Helper_FormElement
{
    /**
     * Generates a password generator button.
     *
     * @param string|array $name If a string, the element name.  If an array,
     *    all other parameters are ignored, and the array elements are
     *    extracted in place of added parameters.
     * @param mixed $value The element value (not used).
     * @param array $attribs Attributes for the element tag.
     * @return string The element XHTML.
     */
    public function passwordGenerator( $name, $value = null, $attribs = null )
    {
        $info = $this->_getInfo( $name, $value, $attribs );
        extract( $info ); // name, value, attribs, options, listsep, disable, id

        // check if disabled
        $disabled = '';
        if( $disable )
            return '';

        // Get the target field (required)
        $targetField = isset( $attribs['target'] ) ? $attribs['target'] : '';
        if( empty( $targetField ) )
            return '';

        // Get password length (default 12)
        $length = isset( $attribs['length'] ) ? intval( $attribs['length'] ) : 12;

        if( $id )
            $id = ' id="' . $this->view->escape( $id ) . '"';

        // Build the onclick handler
        $onclick = ' onclick="randPasword( ' . $length . ', \'' . $this->view->escape( $targetField ) . '\' );"';

        // Get title (default "Random Password")
        $title = isset( $attribs['title'] ) ? $attribs['title'] : 'Random Password';

        // Render the button
        $xhtml = '<span' . $id . $onclick . ' title="' . $this->view->escape( $title ) . '" class="btn add-on" style="margin-left: -5px;">'
                 . '<i class="icon-refresh"></i>'
                 . '</span>';

        return $xhtml;
    }
}
