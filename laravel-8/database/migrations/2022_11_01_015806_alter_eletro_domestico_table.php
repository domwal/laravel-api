<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEletroDomesticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eletro_domesticos', function (Blueprint $table) {
            $table->foreign('marca_id')->references('id')->on('marcas')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eletro_domesticos', function (Blueprint $table) {
            $table->dropForeign('eletro_domesticos_marca_id_foreign');
            $table->dropIndex('eletro_domesticos_marca_id_foreign');
        });
    }
}
