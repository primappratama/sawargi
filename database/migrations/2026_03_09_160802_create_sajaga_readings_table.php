<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sajaga_readings', function (Blueprint $table) {
            $table->id();
            $table->string('node_id');        // TX-01, TX-02, TX-03
            $table->string('node_name');
            $table->float('tilt_angle');      // derajat kemiringan
            $table->float('accel_x');
            $table->float('accel_y');
            $table->float('accel_z');
            $table->float('rainfall');        // mm
            $table->float('soil_moist');      // persen
            $table->string('status');         // AMAN, WASPADA, BAHAYA
            $table->float('battery')->nullable();
            $table->integer('rssi')->nullable();
            $table->timestamps();

            $table->index('node_id');
            $table->index('created_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('sajaga_readings');
    }
};