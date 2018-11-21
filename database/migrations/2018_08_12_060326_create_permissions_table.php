<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100)->nullable()->comment('权限名称');
			$table->integer('pid')->nullable()->default(0)->comment('上级ID');
			$table->string('key', 100)->nullable()->comment('图标');
			$table->string('url')->nullable()->comment('链接地址');
			$table->integer('sort')->default(0)->comment('排序');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permissions');
	}

}
