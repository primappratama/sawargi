<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SajagaReading;

class SajagaController extends Controller {
    public function index() {
        $nodes = SajagaReading::getLatestPerNode();

        $nodeList = [
            ['id' => 'TX-01', 'name' => 'Lereng Nagrak'],
            ['id' => 'TX-02', 'name' => 'Talagaherang'],
            ['id' => 'TX-03', 'name' => 'Bojongsawah'],
        ];

        return view('admin.sajaga', compact('nodes', 'nodeList'));
    }
}