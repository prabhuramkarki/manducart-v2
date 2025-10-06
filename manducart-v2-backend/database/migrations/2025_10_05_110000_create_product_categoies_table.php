<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('category_id'); // Primary key
            $table->text('product_category'); // Category name
            $table->text('product_color'); // Category color
            $table->text('product_size'); // Category size
            $table->tinyInteger('status')->nullable(); // Active or inactive
            $table->unsignedInteger('created_by')->nullable(); // Created by admin
            $table->unsignedInteger('updated_by')->nullable(); // Updated by admin
            $table->timestamp('created_at')->useCurrent(); // Creation time
            $table->timestamp('updated_at')->useCurrent()->nullable(); // Update time

            // Foreign key constraint
            // $table->foreign('created_by')
            //     ->references('admin_id')
            //     ->on('tbl_admins')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
