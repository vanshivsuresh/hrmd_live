<?php

$addOnOf = 'hrms-saas-new';
$product = $addOnOf . '-cybersecurity-module';

return [
    'name' => 'CyberSecurity',
    'verification_required' => false,
    'pack_id' => 50108120,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.3.6',
    'script_name' => $product,
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\CyberSecurity\Entities\CyberSecuritySetting::class,
];
