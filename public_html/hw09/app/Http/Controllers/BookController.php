<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $req)
    {
        // error_log("Start of Index");
        $sql = 'SELECT * FROM books ORDER BY price';
        $books = DB::select($sql);
        // error_log("Got books");


        return view('index', [
            'books' => $books
        ]);
        // error_log("returned");
    }

    public function addbook(Request $req)
    {
        $sql = 'SELECT * FROM books';
        $booktitle = DB::select($sql);


        $sql = 'SELECT * FROM books';
        $price = DB::select($sql);

        $book_id = $req->query('edit');
        $is_edit_request = FALSE;
        if (ctype_digit($book_id)) {
            error_log("Start of Loop");
            $sql = 'SELECT * FROM books WHERE book_id=?';
            $previous = DB::select($sql, [$book_id]);
            $is_edit_request = count($previous) > 0;
        }
        if ($is_edit_request) {
            $prev = $previous[0];
        } else {
            $prev = (object) ['title' => '', 'price' => ''];
        }

        return view('addbook', [
            'booktitle' => $booktitle,
            'price' => $price,
            'prev' => $prev,
            'edit' => $book_id
        ]);
    }

    public function postaddbook(Request $req)
    {
        // error_log("Here");
        $data = $req->validate([
            'booktitle' => 'required|max:500',
            'bookcondition' => 'required|max:500',
            'price' => 'required|max:500',
            'edit' => ''
        ]);

        $title = $data['booktitle'];
        $condition = $data['bookcondition'];
        $cost = $data['price'];

        if (isset($data['edit'])) {
            $sql = "SELECT * FROM books WHERE book_id = ?";
            $books = DB::select($sql, [$data['edit']]);
            if (count($books) > 0 && $books[0]->user_id == Auth::id()) {
                $sql = 'UPDATE books SET title=?, condition=?, price=? WHERE book_id=?';
                DB::statement($sql, [ucwords($title), $condition, $cost, $data['edit']]);
            }
        } else {
            $sql = 'INSERT INTO books (created_by, user_id, title, condition, price) VALUES (?, ?, ?, ?, ?)';
            DB::statement($sql, [Auth::id(), Auth::id(), ucwords($title), ucwords($condition), $cost]);
        }
        return redirect('/');
    }



    public function bookdetail(Request $req)
    {

        $data = $req->validate([
            'book_id' => 'integer'
        ]);

        error_log("Book book id:" . $data['book_id']);
        // Want to use the Laravel framework to do most stuff then 
        // $id = $req->query('book_id');
        // if (!ctype_digit($data['book_id']) | !$data['book_id']) {
        //     return redirect('/error?error=book_not_found');
        // }
        // error_log("Book id: " . $id);
        // error_log("Here now 2");
        // error_log("Books var:" . $book_id);

        // Need double quotes for variable interpolation
        // error_log("Here");

        if (!ctype_digit($data['book_id']) | !$data['book_id']) {
            return redirect('/error?error=book_not_found');
        }
        $sql = 'SELECT * FROM books WHERE book_id=?';
        $books = DB::select($sql, [$data['book_id']]);
        // error_log("Here 2");


        return view('bookdetail', [
            'book' => $books[0]
        ]);


        // $sql = 'SELECT * FROM books';
        // $books = DB::select($sql);

        // return view('bookdetail', [
        //     'books' => $books
        // ]);
    }


    public function delete_book(Request $req)
    {
        $data = $req->validate([
            'book_id' => 'required|integer|gt:0'
        ]);

        // $title = $data['booktitle'];
        // $condition = $data['bookcondition'];
        // $cost = $data['price'];
        $sql = "SELECT * FROM books WHERE book_id = ?";
        $books = DB::select($sql, [$data['book_id']]);
        if (count($books) > 0 && $books[0]->user_id == Auth::id()) {
            $sql = 'DELETE FROM books WHERE book_id=?';
            DB::statement($sql, [$data['book_id']]);
        }
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

}
