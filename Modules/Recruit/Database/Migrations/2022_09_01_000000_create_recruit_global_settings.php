<?php

use App\Scopes\CompanyScope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Recruit\Entities\ApplicationSource;
use Modules\Recruit\Entities\RecruitGlobalSetting;
use Modules\Recruit\Entities\RecruitSetting;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recruit_global_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_code')->nullable();
            $table->string('module_type', 20)->nullable();
            $table->timestamp('supported_until')->nullable();
            $table->timestamps();
        });

        $setting = RecruitSetting::withoutGlobalScope(CompanyScope::class)->first();

        $newSetting = new RecruitGlobalSetting;

        if ($setting) {
            $newSetting->module_code = $setting->module_code;
        }
        $newSetting->saveQuietly();

        Schema::table('recruit_settings', function (Blueprint $table) {
            $table->dropColumn(['module_code']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zoom_setting', function (Blueprint $table) {
            $table->dropColumn(['module_code']);
        });
    }

};
