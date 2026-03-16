<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('gyro_x')->default(0);
            $table->float('gyro_y')->default(0);
            $table->float('gyro_z')->default(0);
            $table->float('soil_moisture')->default(0);
            $table->float('rainfall')->default(0);
            $table->float('suhu')->default(0);
            $table->tinyInteger('status')->default(0); // 0:AMAN 1:WASPADA 2:BAHAYA 3:S.BAHAYA
            $table->float('latitude')->default(0);
            $table->float('longitude')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sensor_data');
    }
};