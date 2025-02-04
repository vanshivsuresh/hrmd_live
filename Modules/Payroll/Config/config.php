<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Payroll',
    'verification_required' => false,
    'pack_id' => 26202694,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.2.3',
    'script_name' => $addOnOf.'-payroll-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Payroll\Entities\PayrollGlobalSetting::class,
];
