<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id'); // Primary key
            $table->string('product_name', 250);
            $table->text('product_details');
            $table->unsignedInteger('category_id'); // Foreign Key to product_categories

            // Product image
            $table->string('product_image', 250)->nullable();

            $table->integer('product_quantity');
            $table->decimal('product_price', 10, 2);
            $table->integer('rating')->default(0);

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->integer('status')->default(1);

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign key for category_id
            $table->foreign('category_id')
                ->references('category_id')
                ->on('product_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
