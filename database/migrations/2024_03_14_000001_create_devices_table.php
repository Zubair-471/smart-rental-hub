<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->string('image_url')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('good');
            $table->json('specifications')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
}; 