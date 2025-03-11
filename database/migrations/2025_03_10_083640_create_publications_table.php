<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('patron_id');
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
