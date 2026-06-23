<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('games_id')->constrained('games')->cascadeOnDelete();
            $table->decimal('price_at_purchase', 10, 2);
            $table->unsignedTinyInteger('quantity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
