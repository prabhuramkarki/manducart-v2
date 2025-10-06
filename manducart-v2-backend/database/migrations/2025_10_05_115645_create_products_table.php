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
            $table->unsignedInteger('category_id'); // FK to product_categories

            // Product images
            $table->string('product_image', 250)->nullable();
            $table->string('product_image2', 250)->nullable();
            $table->string('product_image3', 250)->nullable();
            $table->string('product_image4', 250)->nullable();

            $table->integer('product_quantity');
            $table->integer('product_price');
            $table->integer('rating');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->integer('status')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();

            // Foreign key for created_by (admins)
            // $table->foreign('created_by')
            //     ->references('admin_id')
            //     ->on('tbl_admins')
            //     ->onUpdate('cascade');

            // ✅ Correct foreign key for category_id
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
