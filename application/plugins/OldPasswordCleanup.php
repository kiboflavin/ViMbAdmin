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
        $controller->getD2EM()->getConnection()->executeStatement(
            'DELETE FROM old_password WHERE username = ?',
            [ $controller->getMailbox()->getUsername() ]
        );
    }
}
