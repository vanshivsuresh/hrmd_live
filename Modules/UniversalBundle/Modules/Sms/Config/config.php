<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Sms',
    'verification_required' => false,
    'pack_id' => 27915117,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.2.3',
    'script_name' => $addOnOf.'-sms-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Sms\Entities\SmsSetting::class,
];
