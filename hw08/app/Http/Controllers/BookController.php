<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $req)
    {
        // error_log("Start of Index");
        $sql = 'SELECT * FROM books';
        $books = DB::select($sql);
        // error_log("Got books");


        return view('index', [
            'books' => $books
        ]);
        error_log("Here now 1");
        // error_log("returned");
    }

    public function addbook(Request $req)
    {
        return view('addbook');
    }

    public function postaddbook(Request $req)
    {
        // error_log("Here");
        $data = $req->validate([
            'booktitle' => 'required|max:500',
            'bookcondition' => 'required|max:500',
            'price' => 'required|max:500'
        ]);

        // error_log("Here Now");
        error_log("Data:" . print_r($data, TRUE));

        $title = $data['booktitle'];
        $condition = $data['bookcondition'];
        $cost = $data['price'];
        $sql = 'INSERT INTO books (title, condition, price) VALUES (?, ?, ?)';
        DB::statement($sql, [ucwords($title), ucwords($condition), is_numeric($cost)]);
        return redirect('/');
    }



    public function bookdetail(Request $req)
    {

        // Want to use the Laravel framework to do most stuff then 
        $id = $req->query('book_id');
        if (!ctype_digit($id) | !$id) {
            return redirect('/error?error=book_not_found');
        }
        // error_log("Book id: " . $id);
        // error_log("Here now 2");
        // error_log("Books var:" . $book_id);

        // Need double quotes for variable interpolation
        $sql = "SELECT * FROM books WHERE book_id = $id";
        $books = DB::select($sql);

        return view('bookdetail', [
            'books' => $books,
            'id' => $id
        ]);

        // $sql = 'SELECT * FROM books';
        // $books = DB::select($sql);

        // return view('bookdetail', [
        //     'books' => $books
        // ]);
    }


    public function delete_book(Request $req)
    {


        // error_log("Here");
        $data = $req->validate([
            'book_id' => 'required|integer|gt:0'
        ]);

        $title = $data['booktitle'];
        $condition = $data['bookcondition'];
        $cost = $data['price'];
        $sql = 'DELETE FROM books WHERE book_id=?';
        DB::statement($sql, [$data['book_id']]);
        return redirect('/');
    }

    public function error(Request $req)
    {
        $code = $req->query('error');
        $msg = "Unexpected Error";
        if ($code == 'db_connect') {
            $msg = "Error connecting to database.";
        }

        if ($code == 'book_not_found') {
            $msg = "Book ID not found in database ";
        }



        return view('error', [
            'error_msg' => $msg
        ]);
    }


    public function deletebook(Request $req)
    {
        return view('delete-book');
    }
}
