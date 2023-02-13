<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('offer_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('offer_versions');
            $table->foreignId('offer_id')->constrained();
            $table->unsignedMediumInteger('version')->default(1);
            $table->boolean('is_final')->default(false);
            $table->timestamps();
            $table->unique(['offer_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_versions');
    }
};
