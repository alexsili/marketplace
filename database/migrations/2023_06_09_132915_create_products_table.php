<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->string('name');
            $table->text('description');
            $table->decimal('price')->unsigned()->nullable();
            $table->char('status', 1)->default('A')->comment('A-active, I-inactive');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
