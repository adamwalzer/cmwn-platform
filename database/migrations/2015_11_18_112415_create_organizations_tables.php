<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('district_organization');
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('code');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('district_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('district_id')->unsigned();
            $table->unsignedInteger('organization_id')->unsigned();
            $table->unique(array('organization_id'));
            $table->unique(array('district_id', 'organization_id'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('district_organization');
    }
}
