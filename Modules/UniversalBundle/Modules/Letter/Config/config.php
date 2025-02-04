<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Letter',
    'verification_required' => false,
    'pack_id' => 50767378,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.3.61',
    'script_name' => $addOnOf.'-letter-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Letter\Entities\LetterSetting::class,
];
