<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use App\Helpers\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_schedules_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->log(withSoftdelete: true, withUserLog: true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_participants');
    }
};
