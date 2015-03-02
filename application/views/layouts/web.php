<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->config->item('project_name') ?></title>
<link href="<?= $this->config->item('domain') ?>/public/stylesheets/web/style.css" rel="stylesheet" />
<link href="<?= $this->config->item('domain') ?>/public/stylesheets/web/forms.css" rel="stylesheet" />
<link rel="shortcut icon" href="<?= $this->config->item('domain') ?>/public/images/favicon.ico" type="image/icon">
<link rel="icon" href="<?= $this->config->item('domain') ?>/public/images/favicon.ico" type="image/icon">
<meta name="keywords" content="<?= $this->config->item('meta_keywords') ?>">
<meta name="description" content="<?= $this->config->item('meta_description') ?>">
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?= $this->config->item('domain') ?>/public/stylesheets/style.css">
<!-- Javascript -->
<script type="text/javascript" src="<?= $this->config->item('domain') ?>/public/javascripts/jquery/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?= $this->config->item('domain') ?>/public/javascripts/common.js"></script>

</head>

<body>
<div id="wrapper">
    <div id="content" >
      <?= $template['body']; ?>
    </div>
</div>
<div id="footer">
    <a href="/privacy">Privacy Policy</a> | &copy; <?= date("Y") ?> <?= $this->config->item('project_name') ?>. All rights reserved.
</div>
</body>
</html>
