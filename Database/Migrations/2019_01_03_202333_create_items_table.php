<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('item_types', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('type');
		    $table->string('class');
		    $table->timestamps();
	    });
	    Schema::create('items', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('type');
		    $table->integer('company_id')->unsigned()->index();
		    $table->string('name');
		    $table->text('description')->nullable();
		    $table->boolean('is_drafted')->default(0);
		    $table->boolean('is_active')->default(1);
		    $table->boolean('is_verified')->default(0);
		    $table->timestamps();

		    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
	    });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('item_types');
		Schema::dropIfExists('items');
	}
}
