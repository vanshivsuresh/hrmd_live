<?php

$addOnOf = 'hrms-saas-new';

return [
    'name' => 'Webhooks',
    'verification_required' => false,
    'pack_id' => 49460682,
    'pc_pack_id' => 23263417,
    'parent_min_version' => '5.3.54',
    'script_name' => $addOnOf . '-webhooks-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\Webhooks\Entities\WebhooksGlobalSetting::class,
];
