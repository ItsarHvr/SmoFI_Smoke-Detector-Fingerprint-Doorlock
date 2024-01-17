<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('log_access', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('fingerprint_id');
            $table->date('access_date');
            $table->time('access_time');
            $table->string('access');
            //$table->timestamps(); // Hapus kolom timestamp
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_access');
    }
};
