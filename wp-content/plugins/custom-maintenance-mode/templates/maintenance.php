<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        /* Dynamic background image inline CSS */
        body {
            background: url('<?php echo esc_url(get_option('cmm_background_image')); ?>') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            /* Dark overlay */
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="maintenance-wrapper">
        <h1>We're Under Maintenance</h1>
        <p><?php echo esc_html(get_option('cmm_message')); ?></p>

        <?php if (get_option('cmm_timer')): ?>
            <div id="countdown"></div>
        <?php endif; ?>

        <!-- Email subscription form -->
        <?php if (get_option('cmm_subscribe')): ?>
            <div class="subscribe-form">
                <?php echo do_shortcode(get_option('cmm_subscribe')); ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="<?php echo plugin_dir_url(__FILE__) . '../assets/js/script.js'; ?>"></script>
</body>

</html>