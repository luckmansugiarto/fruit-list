<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFruitTable extends Migration
{
    public $tableName = 'fruit';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 150);
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('depth')->default(0);
            $table->softDeletes();

            $table->unique(['label', 'depth'], 'unq_fruit_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Blueprint $table)
    {
        $table->dropUnique('unq_fruit_primary');
        $table->dropIfExists($this->tableName);
    }
}
