<?php

/**
 * Old Password Cleanup Plugin
 *
 * Deletes rows from old_password table when a mailbox password is changed.
 */
class ViMbAdminPlugin_OldPasswordCleanup extends ViMbAdmin_Plugin implements OSS_Plugin_Observer
{

    public function __construct( OSS_Controller_Action $controller )
    {
        parent::__construct( $controller, get_class($this) );
    }

    /**
     * Deletes old password entries after a mailbox password is changed
     *
     * @param object $controller an OSS_Controller_Action instance
     * @param array $params Additional parameters
     * @return void
     */
    public function mailbox_password_postFlush( $controller, $params )
    {
        $this->_deleteOldPasswordEntries( $controller );
    }

    /**
     * Deletes old password entries after a mailbox is made inactive
     *
     * @param object $controller an OSS_Controller_Action instance
     * @param array $params Additional parameters containing 'active' status
     * @return void
     */
    public function mailbox_toggleActive_postflush( $controller, $params )
    {
        if( isset( $params['active'] ) && !$params['active'] )
        {
            $this->_deleteOldPasswordEntries( $controller );
        }
    }

    /**
     * Helper method to delete old_password entries for the current mailbox
     *
     * @param object $controller an OSS_Controller_Action instance
     * @return void
     */
    private function _deleteOldPasswordEntries( $controller )
    {
        $controller->getD2EM()->getConnection()->executeStatement(
            'DELETE FROM old_password WHERE username = ?',
            [ $controller->getMailbox()->getUsername() ]
        );
    }
}
