<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('background_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('method_name');
            $table->json('parameters')->nullable();
            $table->integer('priority')->default(0);
            $table->integer('retry_count')->default(0);
            $table->timestamp('delayed_until')->nullable();
            $table->enum('status', ['pending', 'running', 'completed', 'failed']);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }
};
