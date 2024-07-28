<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
use App\Helpers\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name');
            $table->boolean('is_random_question')->default(false);
            $table->boolean('is_random_choice')->default(false);
            $table->boolean('is_active')->default(false);

            $table->log(withSoftdelete: true, withUserLog: true);
        });

        DB::statement('CREATE UNIQUE INDEX ON packages (code) WHERE deleted_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_packages');
    }
};
