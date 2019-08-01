<!DOCTYPE html>
<html lang="hu">
<head>
    <?php if(!empty($meta['title'])): ?>
        <title><?php echo $meta['title']; ?></title>
    <?php endif; ?>
    <?php if(!empty($meta['favicon'])): ?>
        <link rel="icon" type="<?php echo $meta['favicon']->type; ?>" href="<?php echo base_url() . $meta['favicon']->src; ?>">
    <?php endif; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?php echo !empty($meta['description']) ? $meta['description'] : ''; ?>">
    <meta name="keywords" content="<?php echo !empty($meta['keywords']) ? $meta['keywords'] : ''; ?>">
    <meta name="author" content="<?php echo !empty($meta['author']) ? $meta['author'] : ''; ?>">
    <meta http-equiv="cache-control" content="public" />

    <?php if(!empty($meta['fb:app_id'])): ?>
        <meta property="fb:app_id" content="<?php echo $meta['fb:app_id']; ?>" />
    <?php endif; ?>
    <?php if(!empty($meta['og:title'])): ?>
        <meta property="og:title" content="<?php echo $meta['og:title']; ?>" />
    <?php endif; ?>
    <?php if(!empty($meta['og:url'])): ?>
        <meta property="og:url" content="<?php echo $meta['og:url']; ?>" />
    <?php endif; ?>
    <?php if(!empty($meta['og:type'])): ?>
        <meta property="og:type" content="<?php echo $meta['og:type']; ?>" />
    <?php endif; ?>
    <?php if(!empty($meta['og:image'])): ?>
        <meta property="og:image" content="<?php echo $meta['og:image']; ?>" />
    <?php endif; ?>
    <?php if(!empty($meta['og:description'])): ?>
        <meta property="og:description" content="<?php echo $meta['og:description']; ?>" />
    <?php endif; ?>

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var app_url = '<?php echo app_url('api'); ?>';
        <?php if(!empty($meta['fb:app_id'])): ?>
            facebook_object.app_id = "<?php echo $meta['fb:app_id']; ?>";
        <?php endif; ?>
        <?php if(!empty($meta['og:title'])): ?>
            facebook_object.title = "<?php echo $meta['og:title']; ?>";
        <?php endif; ?>
        <?php if(!empty($meta['og:url'])): ?>
            facebook_object.url = "<?php echo $meta['og:url']; ?>";
        <?php endif; ?>
        <?php if(!empty($meta['og:type'])): ?>
            facebook_object.type = "<?php echo $meta['og:type']; ?>";
        <?php endif; ?>
        <?php if(!empty($meta['og:image'])): ?>
            facebook_object.image = "<?php echo $meta['og:image']; ?>";
        <?php endif; ?>
        <?php if(!empty($meta['og:description'])): ?>
            facebook_object.description = "<?php echo $meta['og:description']; ?>";
        <?php endif; ?>
    </script>

    <?php if(!empty($appis->google_fonts)): ?>
        <?php echo $appis->google_fonts; ?>
    <?php endif; ?>
    <?php if(!empty($appis->fb)): ?>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              app_id           : '<?php echo $appis->fb; ?>',
              autoLogAppEvents : true,
              xfbml            : true,
              version          : 'v4.0'
            });
          };
        </script>
        <script async defer src="https://connect.facebook.net/hu_HU/sdk.js"></script>
   <?php endif; ?>

   <?php if(!empty($css_files)): ?>
        <?php foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
    <?php endif; ?>
   
   <?php if(!empty($appis->tagmanager)): ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php $appis->tagmanager; ?>');</script>
<!-- End Google Tag Manager -->
<?php endif; ?>
</head>
<body id="<?php echo $page_id; ?>">
    <?php if(!empty($appis->tagmanager)): ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php $appis->tagmanager; ?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        <?php endif; ?>
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
    <?php echo $cookie_police; ?>
    <?php echo $notification_html; ?>
    <?php echo $modals; ?>
</body>
</html>
