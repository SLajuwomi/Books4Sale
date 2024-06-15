<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SayItMessages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SayItController extends Controller
{
	public function index(Request $req)
	{
		
		$sql = 'SELECT * FROM get_recent_messages';
		$messages = DB::select($sql);


		$sql = 'SELECT * FROM get_topic_list';
		$topics = DB::select($sql);


		$message_id = $req->query('edit');

		$is_edit_request = FALSE;
		if (ctype_digit($message_id)) {
			error_log("Start of Loop");
			$sql = 'SELECT * FROM get_all_messages WHERE message_id=?';
			$previous = DB::select($sql, [$message_id]);
			$is_edit_request = count($previous) > 0;
		}
		if ($is_edit_request) {
			$prev = $previous[0];
		} else {
			$prev = (object) ['topic' => '', 'message' => ''];
		}

		return view('sayit', [
			'topics' => $topics,
			'messages' => $messages,
			'prev' => $prev,
			'edit' => $message_id
		]);

	}

	public function error(Request $req)
	{
		$code = $req->query('error');
		$msg = "Unexpected Error";
		if ($code == 'db_connect') {
			$msg = "Error connecting to database.";
		}



		return view('error', [
			'error_msg' => $msg
		]);
	}

	public function save_message(Request $req)
	{
		$data = $req->validate([
			'message' => 'required|max:500',
			'existing-topic' => 'required|max:100',
			'new-topic' => 'max:100',
			'edit' => ''
		]);

		$topic = strlen($data['new-topic']) > 0 ? $data['new-topic'] : $data['existing-topic'];

		if (isset($data['edit'])) {
			$sql = 'SELECT * FROM get_all_messages WHERE message_id=?';
			$messages = DB::select($sql, [$data['edit']]);
			if (count($messages) > 0 && $messages[0]->user_id == Auth::id()) {
				$sql = 'UPDATE sayit_messages SET topic=?, message=? WHERE message_id=?';
				DB::statement($sql, [ucwords($topic), $data['message'], $data['edit']]);
			}
		} else {
			$sql = 'INSERT INTO sayit_messages (user_id, topic, message) VALUES (?, ?, ?)';
			DB::statement($sql, [Auth::id(), ucwords($topic), $data['message']]);
		}

		return redirect('/');
	}

	public function delete_message(Request $req)
	{
		$data = $req->validate([
			'msg-id' => 'required|integer|gt:0'
		]);

		$sql = 'SELECT * FROM get_all_messages WHERE message_id=?';
		$messages = DB::select($sql, [$data['msg-id']]);
		if (count($messages) > 0 && $messages[0]->user_id == Auth::id()) {
			$sql = 'DELETE FROM  sayit_messages WHERE message_id=?';
			DB::statement($sql, [$data['msg-id']]);
		}
		return redirect('/');
	}

	public function message_detail(Request $req)
	{
		$data = $req->validate([
			'msg-id' => 'required|integer|gt:0'
		]);

		$sql = 'SELECT * FROM get_all_messages WHERE message_id=?';
		$messages = DB::select($sql, [$data['msg-id']]);
		return view('message_detail', [
			'message' => $messages[0]
		]);
	}
}
