<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFoldersTable extends Migration
{
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id', 'parent_fk_2186093')->references('id')->on('folders');
        });
    }
}
