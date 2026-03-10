<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('node_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('node_id')->unique(); // TX-01, TX-02, TX-03, RX-01
            $table->string('node_name');
            $table->string('node_type');         // TX, RX
            $table->boolean('is_online')->default(false);
            $table->timestamp('last_seen')->nullable();
            $table->float('battery')->nullable();
            $table->integer('rssi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('node_statuses');
    }
};