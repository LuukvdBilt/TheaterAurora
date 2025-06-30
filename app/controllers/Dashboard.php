<?php

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        $this->view('dashboard/index', $data);
    }
}