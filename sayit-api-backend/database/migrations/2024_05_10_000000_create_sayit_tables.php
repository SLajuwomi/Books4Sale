<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSayitTables extends Migration
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

        Schema::create('sayit_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sayit_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('user_id')->constrained('sayit_users', 'user_id')->onDelete('cascade');
            $table->timestamp('ts')->useCurrent();
            $table->string('topic', 100)->default('');
            $table->string('message', 500)->default('');
        });

        // Create the views
        DB::statement("
            CREATE VIEW get_all_messages AS
            SELECT message_id, user_id, email, name as screen_name, 
                   CONVERT_TZ(ts, '+00:00', 'America/Chicago') AS ts, 
                   topic, message
            FROM sayit_messages INNER JOIN sayit_users USING(user_id) 
            ORDER BY ts DESC
        ");

        DB::statement("
            CREATE VIEW get_recent_messages AS
            SELECT message_id, user_id, email, name as screen_name, 
                   CONVERT_TZ(ts, '+00:00', 'America/Chicago') AS ts, 
                   topic, message
            FROM sayit_messages INNER JOIN sayit_users USING(user_id) 
            ORDER BY ts DESC LIMIT 10
        ");

        DB::statement("
            CREATE VIEW get_topic_list AS
            SELECT topic, COUNT(topic) as topic_count 
            FROM sayit_messages 
            GROUP BY topic 
            ORDER BY COUNT(topic) DESC, topic
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop views first
        DB::statement('DROP VIEW IF EXISTS get_topic_list');
        DB::statement('DROP VIEW IF EXISTS get_recent_messages');
        DB::statement('DROP VIEW IF EXISTS get_all_messages');
        
        // Then drop tables
        Schema::dropIfExists('sayit_messages');
        Schema::dropIfExists('sayit_users');
    }
} 