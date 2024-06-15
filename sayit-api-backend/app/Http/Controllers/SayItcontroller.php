<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SayItController extends Controller
{
    public function get_messages(Request $req)
	{
		$sql= 'SELECT * from get_recent_messages';
		return DB::select($sql);
	}		
     public function get_message(Request $req)
	{
		$sql= 'SELECT * from get_all_messages WHERE message_id=?';
		return DB::select($sql, [$req->id]);
	}		

	public function post_message(Request $req)
	{
		$data = $req->validate([
			'message' => 'required|max:500',
			'topic' => 'required|max:100',
		]);

		try {
		$sql = 'INSERT INTO sayit_messages (user_id, topic, message) VALUES (?, ?, ?)';
		//DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
		DB::statement($sql, [Auth::id(), ucwords($data['topic']), $data['message']]);
		return response()->json(null,201);
		} 
		catch (Exception $e) {
			return response()->json(['error' => 'Unexpected database failure'],  503);
		}
	}

	public function put_message(Request $req)
	{
		if(!ctype_digit($req->id)) {
			return response() -> json(['error' => 'Invalid id.'], 400);
		}
		$data = $req->validate([
			'message' => 'required|max:500',
			'topic' => 'required|max:100',
		]);

		try {
		$sql = 'UPDATE sayit_messages SET topic=?, message=? WHERE message_id=?';
		//DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
		DB::statement($sql, [ucwords($data['topic']), $data['message'], $req->id]);
		return response()->json(null,200);
		} 
		catch (Exception $e) {
			return response()->json(['error' => 'Unexpected database failure'],  503);
		}
	}	

	public function delete_message(Request $req)
	{
		if(!ctype_digit($req->id)) {
			return response() -> json(['error' => 'Invalid id.'], 400);
		}


		try {
		$sql = 'DELETE FROM sayit_messages WHERE message_id=?';
		//DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
		DB::statement($sql, [$req->id]);
		return response()->json(null,204);
		} 
		catch (Exception $e) {
			return response()->json(['error' => 'Unexpected database failure'],  503);
		}
	}	
    //
}
