<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50);
            $table->string('logo')->nullable();;
            $table->string('slug', 50)->nullable();
            $table->string('description', 300);
            $table->string('primary_color', 20);
            $table->string('secondary_color', 20);
            $table->string('sport');

            $table->foreignId('owner_id')->constrained('users');
            $table->foreignId('organization_id')->nullable()->constrained(('organizations'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
