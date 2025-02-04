<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel Application - Server Requirements</title>
    <style>
        body {
            padding-top: 18px;
            font-family: sans-serif;
            background: #f9fafb;
            font-size: 14px;
        }

        #container {
            width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            border: 2px solid #f0f0f0;
            -webkit-box-shadow: 0 1px 15px 1px rgba(90, 90, 90, 0.08);
            box-shadow: 0 1px 15px 1px rgba(90, 90, 90, 0.08);
        }

        a {
            text-decoration: none;
            color: red;
        }

        h1 {
            text-align: center;
            color: #424242;
            border-bottom: 1px solid #e4e4e4;
            padding-bottom: 25px;
            font-size: 22px;
            font-weight: normal;
        }

        table {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
        }

        table thead th {
            text-align: left;
            padding: 5px 0px 5px 0px;
        }

        table tbody td {
            padding: 5px 0px;
        }

        table tbody td:last-child,
        table thead th:last-child {
            text-align: right;
        }

        .label {
            padding: 3px 10px;
            border-radius: 4px;
            color: #fff;

        }

        .label.label-success {
            background: #4ac700;
        }

        .label.label-warning {
            background: #dc2020;
        }


        .logo {
            margin-bottom: 30px;
            margin-top: 20px;
            display: block;
        }

        .logo img {
            margin: 0 auto;
            display: block;
        }

        .scene {
            width: 100%;
            height: 100%;
            perspective: 600px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;

            svg {
                width: 240px;
                height: 240px;
            }

        }

        @keyframes arrow-spin {
            50% {
                transform: rotateY(360deg);
            }
        }
    </style>
</head>

<body>
    <?php

    function getSizeAndStatus($maxSizeKey) {
        try {
            // Retrieve the raw value from php.ini
            $maxSize = ini_get($maxSizeKey);

            // Convert the size to bytes
            $sizeInBytes = return_bytes($maxSize);

            // Format the size in either MB or GB
            if ($sizeInBytes >= 1 << 30) {
                return [
                    'size' => round($sizeInBytes / (1 << 30), 2) . ' GB',
                    'greater' => true
                ];
            }

            $mb = $sizeInBytes / 1048576;

            if ($sizeInBytes >= 1 << 20) {
                return [
                    'size' => round($sizeInBytes / (1 << 20), 2) . ' MB',
                    'greater' => $mb >= 20
                ];
            }

            if ($sizeInBytes >= 1 << 10) {
                return [
                    'size' => round($sizeInBytes / (1 << 10), 2) . ' KB',
                    'greater' => false
                ];
            }

            return [
                'size' => $sizeInBytes . ' Bytes',
                'greater' => false
            ];
        } catch (\Exception $e) {
            return [
                'size' => '0 Bytes',
                'greater' => true
            ];
        }
    }

    function getUploadMaxFilesize() {
        return getSizeAndStatus('upload_max_filesize');
    }

    function getPostMaxSize() {
        return getSizeAndStatus('post_max_size');
    }

    // Helper function to convert human-readable size to bytes
    function return_bytes($val) {
        $val = trim($val);
        $valNew= substr($val,0,-1);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
        case 'g':
            $valNew *= 1024;
        case 'm':
            $valNew *= 1024;
        case 'k':
            $valNew *= 1024;
        }

        return $valNew;
    }


    $error = false;

    if (version_compare(PHP_VERSION, '8.2.0') >= 0) {
        $requirement1 = "<span class='label label-success'>v." . PHP_VERSION . '</span>';
    }
    else {
        $error = true;
        $requirement1 = "<span class='label label-warning'>Your PHP version is " . PHP_VERSION . '</span>';
    }

    if (!extension_loaded('tokenizer')) {
        $error = true;
        $requirement2 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement2 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('pdo')) {
        $error = true;
        $requirement3 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement3 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('curl')) {
        $error = true;
        $requirement4 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement4 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('openssl')) {
        $error = true;
        $requirement5 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement5 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('mbstring')) {
        $error = true;
        $requirement6 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement6 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('ctype') && !function_exists('ctype')) {
        $error = true;
        $requirement7 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement7 = "<span class='label label-success'>Enabled</span>";
    }


    if (!extension_loaded('gd')) {
        $error = true;
        $requirement9 = "<span class='label label-warning'>Not enabled</span>";
    }
    else {
        $requirement9 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('zip')) {
        $error = true;
        $requirement10 = "<span class='label label-warning'>Zip Extension is not enabled</span>";
    }
    else {
        $requirement10 = "<span class='label label-success'>Enabled</span>";
    }

    $url_f_open = ini_get('allow_url_fopen');

    if ($url_f_open != '1' && $url_f_open != 'On') {
        $error = true;
        $requirement11 = "<span class='label label-warning'>Allow_url_fopen is not enabled!</span>";
    }
    else {
        $requirement11 = "<span class='label label-success'>Enabled</span>";
    }

    if (!extension_loaded('intl')) {
        $error = true;
        $requirement12 = "<span class='label label-warning'>INTL Extension is not enabled</span>";
    }
    else {
        $requirement12 = "<span class='label label-success'>Enabled</span>";
    }

    $max_time = ini_get('max_execution_time');

    if ($max_time <= 30) {
        $error = true;
        $requirement13 = "<span class='label label-warning'>max_execution_time on your server is " . $max_time . ". Do increase it</span>";
    }
    else {
        $requirement13 = "<span class='label label-success'> $max_time Good Enough</span>";
    }


    if(!function_exists('proc_open')) {
        $error = true;
        $requirement14 = "<span class='label label-warning'>Proc Open is not enabled</span>";
    }
    else {
        $requirement14 = "<span class='label label-success'>Enabled</span>";
    }

    if(!function_exists('proc_close')) {
        $error = true;
        $requirement15 = "<span class='label label-warning'>Proc Close is not enabled</span>";
    }
    else {
        $requirement15 = "<span class='label label-success'>Enabled</span>";
    }

    if(!getUploadMaxFilesize()['greater']) {
        $error = true;
        $requirement16 = "<span class='label label-warning'>".getUploadMaxFilesize()['size']."</span>";
    }
    else {
        $requirement16 = "<span class='label label-success'>".getUploadMaxFilesize()['size']."</span>";
    }

    if(!getPostMaxSize()['greater']) {
        $error = true;
        $requirement17 = "<span class='label label-warning'>".getPostMaxSize()['size']."</span>";
    }
    else {
        $requirement17 = "<span class='label label-success'>".getPostMaxSize()['size']."</span>";
    }


    ?>
    <div id="container">
       
        <div class="scene" id="scene">
            <svg version="1.1" id="dc-spinner" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 38 38" preserveAspectRatio="xMinYMin meet">
                <text x="14" y="21" font-family="Monaco" font-size="2px" style="letter-spacing:0.6" fill="grey">LOADING
                    <animate attributeName="opacity" values="0;1;0" dur="1.8s" repeatCount="indefinite" />
                </text>
                <path fill="#373a42" d="M20,35c-8.271,0-15-6.729-15-15S11.729,5,20,5s15,6.729,15,15S28.271,35,20,35z M20,5.203
    C11.841,5.203,5.203,11.841,5.203,20c0,8.159,6.638,14.797,14.797,14.797S34.797,28.159,34.797,20
    C34.797,11.841,28.159,5.203,20,5.203z">
                </path>

                <path fill="#373a42" d="M20,33.125c-7.237,0-13.125-5.888-13.125-13.125S12.763,6.875,20,6.875S33.125,12.763,33.125,20
    S27.237,33.125,20,33.125z M20,7.078C12.875,7.078,7.078,12.875,7.078,20c0,7.125,5.797,12.922,12.922,12.922
    S32.922,27.125,32.922,20C32.922,12.875,27.125,7.078,20,7.078z">
                </path>

                <path fill="#2AA198" stroke="#2AA198" stroke-width="0.6027" stroke-miterlimit="10" d="M5.203,20
            c0-8.159,6.638-14.797,14.797-14.797V5C11.729,5,5,11.729,5,20s6.729,15,15,15v-0.203C11.841,34.797,5.203,28.159,5.203,20z">
                    <animateTransform attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" calcMode="spline" keySplines="0.4, 0, 0.2, 1" keyTimes="0;1" dur="2s" repeatCount="indefinite" />
                </path>

                <path fill="#859900" stroke="#859900" stroke-width="0.2027" stroke-miterlimit="10" d="M7.078,20
  c0-7.125,5.797-12.922,12.922-12.922V6.875C12.763,6.875,6.875,12.763,6.875,20S12.763,33.125,20,33.125v-0.203
  C12.875,32.922,7.078,27.125,7.078,20z">
                    <animateTransform attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="1.8s" repeatCount="indefinite" />
                </path>
            </svg>
        </div>


        <table class="table table-hover" id="requirements" style="display:none;">
            <thead>
                <tr>
                    <th>Requirements</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PHP 8.2.0+</td>
                    <td><?php echo $requirement1; ?></td>
                </tr>
                <tr>
                    <td>TOKENIZER</td>
                    <td><?php echo $requirement2; ?></td>
                </tr>
                <tr>
                    <td>PDO PHP Extension</td>
                    <td><?php echo $requirement3; ?></td>
                </tr>
                <tr>
                    <td>cURL PHP Extension</td>
                    <td><?php echo $requirement4; ?></td>
                </tr>
                <tr>
                    <td>OpenSSL PHP Extension</td>
                    <td><?php echo $requirement5; ?></td>
                </tr>
                <tr>
                    <td>MBString PHP Extension</td>
                    <td><?php echo $requirement6; ?></td>
                </tr>


                <tr>
                    <td>GD PHP Extension</td>
                    <td><?php echo $requirement9; ?></td>
                </tr>
                <tr>
                    <td>Zip PHP Extension</td>
                    <td><?php echo $requirement10; ?></td>
                </tr>
                <tr>
                    <td>allow_url_fopen</td>
                    <td><?php echo $requirement11; ?></td>
                </tr>
                <tr>
                    <td>Intl PHP Extension</td>
                    <td><?php echo $requirement12; ?></td>
                </tr>
                <tr>
                    <td>Max Execution Time</td>
                    <td><?php echo $requirement13; ?></td>
                </tr>
                <tr>
                    <td>Proc_open</td>
                    <td><?php echo $requirement14; ?></td>
                </tr>
                <tr>
                    <td>Proc_close</td>
                    <td><?php echo $requirement15; ?></td>
                </tr>
                <tr>
                    <td>Upload Max Filesize</td>
                    <td><?php echo $requirement16; ?></td>
                </tr>
                <tr>
                    <td>Post Max size</td>
                    <td><?php echo $requirement17; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <br />
                        <br />
                        Additionally you will need <b>mod_rewrite</b> enabled in your server. <br /><small>(this script unable to
                            check if mod_rewrite extension is allowed in your server, consult with your hosting provider for
                            this extension)</small>
                    </td>
                </tr>
            </tfoot>
        </table>
        <br />

    </div>
    <script>
        const scene = {
            complete: function () {
                const scene = document.getElementById("scene");
                scene.remove();
            }
        };
        document.addEventListener("readystatechange", function() {
            if (document.readyState === "complete") {
                setTimeout(function() {
                    scene.complete();
                    const requirements = document.getElementById("requirements");
                    requirements.style['display'] = null;
                }, 3000);
            }
        });
    </script>
</body>

</html>
