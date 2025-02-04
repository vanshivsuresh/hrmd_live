<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Recruit',
    'verification_required' => false,
    'pack_id' => 43314875,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.2.5',
    'script_name' => $addOnOf . '-recruit-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Recruit\Entities\RecruitGlobalSetting::class,
];
