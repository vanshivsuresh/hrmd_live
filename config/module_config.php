<?php

$PRODUCT = 'hrms-saas-new';
$P_ID = 005;
$PRODUCT_URL = 'https://hrmdaddy.com';
$UPDATE_DOMAIN = 'https://update.hrmdaddy.com';
$VERIFY_DOMAIN = 'https://verify.hrmdaddy.com';

return [

    /*
     * Model name of where Code is stored
     */
    'setting' => \App\Models\GlobalSetting::class,

    /*
     * Add redirect route here route('login') will be used
     */
    'redirectRoute' => 'login',

    'product_name' => 'hrms-saas-new',

    /*
    * Set which users can perform an update;
    * This parameter accepts: ARRAY(user_id) ,or FALSE => for example: [1]  OR  [1,3,0]  OR  false
    * Generally, ADMIN have user_id=1; set FALSE to disable this check (not recommended)
    */

    'allow_users_id' => false,



    'pack_id' => 005,

    'plugins_url' => $VERIFY_DOMAIN . '/plugins/' . $P_ID,

    /*
    * Temp folder to store update before to install it.
    */
    'tmp_path' => storage_path() . '/app',
    /*
    * URL where your updates are stored ( e.g. for a folder named 'updates', under http://site.com/yourapp ).
    */
    'update_baseurl' => $UPDATE_DOMAIN . '/' . $PRODUCT,
    /*
    * URL to verify your Code
    */
    'verify_url' => $VERIFY_DOMAIN . '/verify-purchase',

    'latest_version_file' => $VERIFY_DOMAIN . '/latest-version/' . $P_ID,

    /*
     * Update log file
     */
    'updater_file_path' => $UPDATE_DOMAIN . '/' . $PRODUCT . '/laraupdater.json',

    /*
    * Set a middleware for the route: updater.update
    * Only 'auth' NOT works (manage security using 'allow_users_id' configuration)
    */
    'middleware' => ['web', 'auth'],

   
    /*
     * Change Log URL
     */
    'versionLog' => $VERIFY_DOMAIN . '/version-log/' . $PRODUCT
];
