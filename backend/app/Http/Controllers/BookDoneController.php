<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\BookDoneService;

class BookDoneController extends Controller
{

    public function __construct() {
        $this->bookDoneService = new BookDoneService();
    }

    public function getBookDoneData(Request $request) {
        $studioId = $request->query('studio_id');
        return $this->bookDoneService->getBookDoneData($studioId);
    }

}