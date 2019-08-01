<!DOCTYPE html>
<html lang="hu">
<head>
    <title>ADMINISZTRÁCIÓS FELÜLET</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="cache-control" content="public" />

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <?php if(!empty($css_files)): ?>
        <?php foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <?php echo $header; ?>
    <main id="main">
        <?php echo $content; ?>
    </main>
    <?php echo $footer; ?>

    <?php if(!empty($js_files)): ?>
        <?php foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo $notification_html; ?>
    <?php echo $modals; ?>
</body>
</html>
