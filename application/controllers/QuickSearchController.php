<?php

/**
 * Quick Search API Controller
 *
 * Provides autocomplete search for mailboxes and aliases.
 */

class QuickSearchController extends ViMbAdmin_Controller_Action
{
    /**
     * Ensure user is logged in.
     */
    public function preDispatch()
    {
        $this->authorise();
    }

    /**
     * Quick search autocomplete endpoint.
     *
     * Searches mailboxes and aliases by email/address.
     * Expects a 'q' GET parameter with the search query.
     * Returns JSON array of matching results.
     */
    public function searchAction()
    {
        Zend_Controller_Action_HelperBroker::removeHelper( 'viewRenderer' );

        $query = $this->_getParam('q', '');

        if (strlen($query) < 2) {
            echo json_encode([]);
            return;
        }

        $admin = $this->getAdmin();

        $results = $this->getD2EM()
            ->getRepository('\\Entities\\Mailbox')
            ->searchForQuickSearch($query, $admin);

        echo json_encode($results);
    }
}
