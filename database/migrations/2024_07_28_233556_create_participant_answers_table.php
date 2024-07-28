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
        Schema::create('participant_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('exam_participants');
            $table->foreignId('package_question_id')->constrained();
            $table->char('answer', 1);
            
            $table->log(false, false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_answers');
    }
};
