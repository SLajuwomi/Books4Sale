<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $req) {
        return view('index');
    }

    public function addbook(Request $req) {
        return view('addbook');
    }

    public function bookdetail(Request $req) {
        return view('bookdetail');
    }

    public function error(Request $req) {
        $code= $req->query('error');
        $msg= "Unexpected Error";
              if ($code=='db_connect') {
            $msg= "Error connecting to database.";
           }
    
    
    
        return view('error', [
            'error_msg' => $msg
        ]);
        }
    

    public function deletebook(Request $req) {
        return view('delete-book');
    }
}
