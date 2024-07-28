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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('duration');
            $table->integer('quota');
            $table->foreignId('package_id')->constrained();
            $table->boolean('is_active')->default(false);

            $table->log(withSoftdelete: true, withUserLog: true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
