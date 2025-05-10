<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ConsolidateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop existing views first
        DB::statement('DROP VIEW IF EXISTS get_topic_list');
        DB::statement('DROP VIEW IF EXISTS get_recent_messages');
        DB::statement('DROP VIEW IF EXISTS get_all_messages');

        // Drop sayit_messages table to recreate with updated foreign key
        Schema::dropIfExists('sayit_messages');

        // Create sayit_messages table with reference to users table
        Schema::create('sayit_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamp('ts')->useCurrent();
            $table->string('topic', 100)->default('');
            $table->string('message', 500)->default('');
        });

        // Create the views to use the users table
        DB::statement("
            CREATE VIEW get_all_messages AS
            SELECT message_id, user_id, email, name as screen_name, 
                   CONVERT_TZ(ts, '+00:00', 'America/Chicago') AS ts, 
                   topic, message
            FROM sayit_messages INNER JOIN users ON sayit_messages.user_id = users.id
            ORDER BY ts DESC
        ");

        DB::statement("
            CREATE VIEW get_recent_messages AS
            SELECT message_id, user_id, email, name as screen_name, 
                   CONVERT_TZ(ts, '+00:00', 'America/Chicago') AS ts, 
                   topic, message
            FROM sayit_messages INNER JOIN users ON sayit_messages.user_id = users.id
            ORDER BY ts DESC LIMIT 10
        ");

        DB::statement("
            CREATE VIEW get_topic_list AS
            SELECT topic, COUNT(topic) as topic_count 
            FROM sayit_messages 
            GROUP BY topic 
            ORDER BY COUNT(topic) DESC, topic
        ");

        // Drop sayit_users table since it's no longer needed
        Schema::dropIfExists('sayit_users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration cannot be easily reversed since data would be lost
        // If needed, restore from backup
    }
} 