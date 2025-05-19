<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TestSession extends BaseController
{
    public function index()
    {
        $session = session();

        // Set session jika belum ada
        if (!$session->has('foo')) {
            $session->set('foo', 'bar');
            return "Session di-set: foo=bar";
        } else {
            $foo = $session->get('foo');
            return "Session sudah ada: foo=$foo";
        }
    }
}
