<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'LanguagePack',
    'verification_required' => false,
    'pack_id' => 48773832,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.3.3',
    'script_name' => $addOnOf.'-languagepack-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\LanguagePack\Entities\LanguagePackSetting::class,
];
