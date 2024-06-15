<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function get_books(Request $req)
    {
        $sql = 'SELECT * FROM books';
        return DB::select($sql);
    }

    public function get_book(Request $req)
    {


        if (!ctype_digit($req->id)) {
            return response()->json(['error' => 'Invalid id.'], 400);
        }

        try {
            $sql = 'SELECT * FROM books WHERE book_id=?';
            $selected = DB::select($sql, [$req->id]);
            if (!$selected) {
                return response()->json(['error' => 'Invalid id.'], 400);
            } else {
                return DB::select($sql, [$req->id]);
            }
        } catch (Exception $e) {
            return response()->json(null, 200);
        }
    }

    public function post_book(Request $req)
    {
        $data = $req->validate([
            'title' => 'required|max:50',
            'condition' => 'required',
            'price' => 'required|max:5'
        ]);

        try {
            $sql = 'INSERT INTO books (book_id, created_by, title, condition, price) VALUES (default, ?, ?, ?, ?)';
            //DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
            DB::statement($sql, [Auth::id(), ucwords($data['title']), $data['condition'], $data['price']]);
            return response()->json(null, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unexpected database failure'],  503);
        }
    }

    public function put_book(Request $req)
    {
        if (!ctype_digit($req->id)) {
            return response()->json(['error' => 'Invalid id.'], 400);
        }

        $data = $req->validate([
            'title' => 'required|max:100',
            'condition' => 'required|max:10',
            'price' => 'required|max:10',
        ]);

        try {
            $sql = 'UPDATE books SET title=?, condition=?, price=? WHERE book_id=?';
            $selected = DB::select($sql, [ucwords($data['title']), $data['condition'], $data['price'], $req->id]);
            if (!$selected) {
                return response()->json(['error' => 'Invalid id.'], 400);
            } else {
                //DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
                DB::statement($sql, [ucwords($data['title']), $data['condition'], $data['price'], $req->id]);
                return response()->json(null, 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unexpected database failure'],  503);
        }
    }

    public function delete_book(Request $req)
    {
        if (!ctype_digit($req->id)) {
            return response()->json(['error' => 'Invalid id.'], 400);
        }


        try {
            $sql = 'DELETE FROM books WHERE book_id=?';
            $selected = DB::select($sql, [$req->id]);
            if (!$selected) {
                return response()->json(['error' => 'Invalid id.'], 400);
            } else {
                //DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
                DB::statement($sql, [$req->id]);
                return response()->json(null, 204);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unexpected database failure'],  503);
        }
    }
}
