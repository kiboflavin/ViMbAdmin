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

        error_log("QuickSearch: ALL PARAMS = " . print_r($_GET, true));
        error_log("QuickSearch: ALL REQUEST = " . print_r($_REQUEST, true));

        $query = $this->_getParam('q', '');
        $query2 = isset($_GET['q']) ? $_GET['q'] : 'NOT SET';

        error_log("QuickSearch: query='$query' (via _getParam)");
        error_log("QuickSearch: query='$query2' (via _GET)");

        if (strlen($query) < 2) {
            echo json_encode([]);
            return;
        }

        $admin = $this->getAdmin();
        error_log("QuickSearch: admin=" . ($admin ? $admin->getUsername() : 'null'));

        $results = $this->getD2EM()
            ->getRepository('\\Entities\\Mailbox')
            ->searchForQuickSearch($query, $admin);

        error_log("QuickSearch: results count=" . count($results));
        error_log("QuickSearch: results=" . json_encode($results));

        echo json_encode($results);
    }
}
