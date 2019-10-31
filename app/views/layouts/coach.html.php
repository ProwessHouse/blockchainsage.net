<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!--
  Customize this policy to fit your own app's needs. For more guidance, see:
      https://github.com/apache/cordova-plugin-whitelist/blob/master/README.md#content-security-policy
  Some notes:
    * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
    * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
    * Disables use of inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
      * Enable inline JS: add 'unsafe-inline' to default-src
  -->
  <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap: content:">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover">

  <meta name="theme-color" content="#007aff">
  <meta name="format-detection" content="telephone=no">
  <meta name="msapplication-tap-highlight" content="no">
  <title>My App</title>
  <!-- web-start -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/icons/apple-touch-icon.png">
  <link rel="icon" href="assets/icons/favicon.png">
  <link rel="manifest" href="/manifest.json">
  <!-- web-end -->
  <link rel="stylesheet" href="/app/webroot/_/framework7/css/framework7.bundle.min.css">
  <link rel="stylesheet" href="/app/webroot/_/css/icons.css">
  <link rel="stylesheet" href="/app/webroot/_/css/app.css">
</head>
<body>
  <div id="app">
    
    <!-- Your main view, should have "view-main" class -->
    <div class="view view-main view-init safe-areas">
      <div class="page" data-name="home">
        <!-- Top Navbar -->
        <div class="navbar navbar-small">
          <div class="navbar-bg"></div>
          <div class="navbar-inner">
            <div class="left">
<!--              <a href="#" class="link icon-only panel-open" data-panel="left">
                <i class="icon f7-icons if-not-md">menu</i>
                <i class="icon material-icons if-md">menu</i>
              </a>
            --></div> 
            <div class="title sliding">Personality Test</div>
            <div class="right">
<!--              <a href="#" class="link icon-only panel-open" data-panel="right">
                <i class="icon f7-icons if-not-md">menu</i>
                <i class="icon material-icons if-md">menu</i>
              </a>
										--></div> 
          </div>
        </div>
        <!-- Toolbar
        <div class="toolbar toolbar-bottom">
          <div class="toolbar-inner">
            <a href="#" class="link">Left Link</a>
            <a href="#" class="link">Right Link</a>
          </div>
        </div>
								-->
        <!-- Scrollable page content-->
        <div class="page-content">
          <div class="block-title">.</div>
			<?php echo $this->content(); ?>



        </div>
      </div>
    </div>



  </div>
  <!-- CORDOVA_PLACEHOLDER_DONT_REMOVE -->
  <!-- Framework7 library -->
  <script src="/app/webroot/_/framework7/js/framework7.bundle.min.js"></script>
  <!-- Cordova APIs -->
  <script src="/app/webroot/_/js/cordova-app.js"></script>
  <!-- App routes -->
  <script src="/app/webroot/_/js/routes.js"></script>
  <!-- App scripts -->
  <script src="/app/webroot/_/js/app.js"></script>
</body>
</html>