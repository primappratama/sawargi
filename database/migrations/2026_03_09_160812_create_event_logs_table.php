<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('system');         // SAJAGA, SINATRA, SYSTEM
            $table->string('node_id')->nullable();
            $table->string('event_type');     // STATUS_CHANGE, ALERT, dll
            $table->string('severity');       // INFO, WARNING, DANGER
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->index('system');
            $table->index('severity');
            $table->index('created_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('event_logs');
    }
};