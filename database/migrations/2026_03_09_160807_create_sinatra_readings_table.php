<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sinatra_readings', function (Blueprint $table) {
            $table->id();
            $table->string('zone_id');        // ZONA-1, ZONA-2
            $table->string('zone_name');
            $table->integer('adc_raw');       // 0-1023
            $table->float('level_pct');       // persen
            $table->boolean('valve_open');
            $table->string('status');         // BUKA, TUTUP, HOLD
            $table->timestamps();

            $table->index('zone_id');
            $table->index('created_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('sinatra_readings');
    }
};