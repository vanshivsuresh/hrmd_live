<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Affiliate',
    'verification_required' => false,
    'pack_id' => 54299368,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.3.9',
    'script_name' => $addOnOf . '-affiliate-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Affiliate\Entities\AffiliateGlobalSetting::class,
];
