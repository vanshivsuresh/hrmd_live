<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Payroll\Entities\PayrollGlobalSetting;
use Modules\Payroll\Entities\PayrollSetting;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_global_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_code')->nullable();
            $table->string('module_type', 20)->nullable();
            $table->timestamp('supported_until')->nullable();
            $table->timestamps();
        });

        $setting = PayrollSetting::withoutGlobalScope(\App\Scopes\CompanyScope::class)->first();

        $newSetting = new PayrollGlobalSetting;

        if ($setting) {
            $newSetting->module_code = $setting->module_code;
        }

        $newSetting->saveQuietly();

        Schema::table('payroll_settings', function (Blueprint $table) {
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
            $table->dropColumn(['module_code', 'supported_until']);
        });
    }
};
