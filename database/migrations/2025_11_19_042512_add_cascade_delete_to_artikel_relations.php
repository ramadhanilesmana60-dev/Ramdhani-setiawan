<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update komentars table to add cascade delete
        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['artikel_id']);
            $table->foreign('artikel_id')->references('id')->on('artikels')->onDelete('cascade');
        });

        // Update likes table to add cascade delete
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['artikel_id']);
            $table->foreign('artikel_id')->references('id')->on('artikels')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Revert back to original foreign key constraints
        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['artikel_id']);
            $table->foreign('artikel_id')->references('id')->on('artikels');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['artikel_id']);
            $table->foreign('artikel_id')->references('id')->on('artikels');
        });
    }
};