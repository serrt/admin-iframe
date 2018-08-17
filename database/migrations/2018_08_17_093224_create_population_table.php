<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePopulationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('population', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('number', 20)->nullable()->comment('户籍编号');
			$table->integer('master')->nullable()->comment('户主编号(population.id)');
			$table->char('name', 20)->nullable()->comment('姓名');
			$table->string('avatar', 200)->nullable()->comment('头像');
			$table->string('relation', 100)->nullable()->comment('与户主的关系');
			$table->string('old_name', 20)->nullable()->comment('曾用名');
			$table->char('id_number', 20)->nullable()->comment('身份证');
			$table->boolean('sex')->nullable()->default(1)->comment('性别(0:女, 1:男)');
			$table->timestamp('birthday')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('生日');
			$table->string('birth_place', 200)->nullable()->comment('出生地');
			$table->string('place', 200)->nullable()->comment('籍贯');
			$table->integer('type')->nullable()->comment('户籍类型(keywords.population_type)');
			$table->integer('community')->nullable()->comment('社别(keywords.community)');
			$table->integer('nation')->nullable()->comment('民族(keywords.nation)');
			$table->integer('polity')->nullable()->comment('政治面貌(keywords.polity)');
			$table->integer('education')->nullable()->comment('文化程度(keywords.culture)');
			$table->string('marry', 20)->nullable()->comment('婚姻状况');
			$table->integer('area')->nullable()->comment('小区(keywords.area)');
			$table->integer('building')->nullable()->comment('楼栋号(keywords.building)');
			$table->string('door', 20)->nullable()->comment('门牌号');
			$table->string('address', 200)->nullable()->comment('现住地址');
			$table->integer('benefit')->nullable()->default(0)->comment('是否享受福利(0:否,1:是)');
			$table->integer('is_military')->nullable()->default(0)->comment('兵役(0: 未服兵役, 1: 已服兵役)');
			$table->integer('is_voter')->nullable()->default(0)->comment('选民(0: 未参加, 1: 已参加)');
			$table->string('occupation', 100)->nullable()->comment('职业');
			$table->string('health', 100)->nullable()->comment('身体状况');
			$table->string('phone', 100)->nullable()->comment('联系方式');
			$table->string('remarks', 200)->nullable()->comment('备注');
			$table->string('company', 100)->nullable()->comment('公司');
			$table->integer('company_province')->nullable()->comment('公司所在省(regions.id)');
			$table->integer('company_city')->nullable()->comment('公司所在市(regions.id)');
			$table->integer('company_area')->nullable()->comment('公司所在区(regions.id)');
			$table->string('work_type', 100)->nullable()->comment('工种');
			$table->dateTime('applay_time')->nullable()->comment('申报时间');
			$table->string('apply_reason', 100)->nullable()->comment('申报原因');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('population');
	}

}
