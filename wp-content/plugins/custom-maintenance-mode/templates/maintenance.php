<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        body {
            background-image: url('<?php echo esc_url(get_option('cmm_background_image')); ?>');
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            padding: 50px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
        }

        #countdown {
            font-size: 2rem;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <h1>We'll be back soon!</h1>
    <p><?php echo esc_html(get_option('cmm_message')); ?></p>

    <?php if (get_option('cmm_timer')): ?>
        <div id="countdown"></div>
        <script>
            let countdownTime = new Date().getTime() + <?php echo esc_attr(get_option('cmm_timer')) * 3600000; ?>;
            let countdownInterval = setInterval(function() {
                let now = new Date().getTime();
                let timeLeft = countdownTime - now;

                let hours = Math.floor(timeLeft / (1000 * 60 * 60));
                let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById('countdown').innerHTML = hours + 'h ' + minutes + 'm ' + seconds + 's ';

                if (timeLeft < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('countdown').innerHTML = 'We are live now!';
                }
            }, 1000);
        </script>
    <?php endif; ?>

    <?php if (get_option('cmm_subscribe')): ?>
        <div><?php echo do_shortcode(get_option('cmm_subscribe')); ?></div>
    <?php endif; ?>
</body>

</html>