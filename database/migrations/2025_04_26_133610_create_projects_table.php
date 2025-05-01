<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->string('status',50);
            $table->text('description')->nullable();
            $table->date('received_date');
            $table->date('temp_deadline')->nullable();
            $table->date('deadline');
            $table->date('temp_pay_date')->nullable();
            $table->date('pay_date')->nullable();
            $table->integer('cost_per_character')->nullable();
            $table->integer('deadline_character')->nullable();
            $table->integer('temp_salary')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('total_characters')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
