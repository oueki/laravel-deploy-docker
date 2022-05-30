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
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
//            $table->unsignedInteger('category_id');
            $table->softDeletes();



//            $table->foreign('category_id')->references('id')->on('categories');
//            $table->foreignId('category_id')->constrained();


            $table->foreignId('category_id')
                ->constrained()
                ->onUpdate('restrict')
                ->onDelete('restrict');

//            $table->foreignId('category_id')
//                ->constrained()
//                ->onUpdate('cascade')
//                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('category_id');
        });
    }
};
