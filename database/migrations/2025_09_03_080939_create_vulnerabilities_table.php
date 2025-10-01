<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVulnerabilitiesTable extends Migration {
    public function up() {
        Schema::create('vulnerabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scan_id')->constrained()->onDelete('cascade');
            $table->string('cve_id')->nullable();
            $table->string('package');
            $table->string('installed_version')->nullable();
            $table->string('fixed_version')->nullable();
            $table->string('severity');
            $table->string('title');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('vulnerabilities');
    }
}
