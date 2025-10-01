<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScansTable extends Migration {
    public function up() {
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamp('scan_date');
            $table->json('raw_result');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('scans');
    }
}
