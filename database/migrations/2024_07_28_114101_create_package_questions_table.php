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
        Schema::create('package_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained();
            $table->integer('number');
            $table->string('header')->nullable();
            $table->text('text')->nullable();
            $table->jsonb('choices')->nullable();
            $table->char('correct_choice', 1)->nullable();

            $table->log(withSoftdelete: true, withUserLog: true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_questions');
    }
};
