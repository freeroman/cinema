<?php //netteCache[01]000359a:2:{s:4:"time";s:21:"0.62516700 1399801735";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:45:"C:\dev\www\cinema\app\templates\@layout.latte";i:2;i:1399801734;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:22:"released on 2014-03-17";}}}?><?php

// source file: C:\dev\www\cinema\app\templates\@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'm4gqfl14kl')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbe7df770154_title')) { function _lbe7df770154_title($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>Nette Application Skeleton<?php
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lbeb5101d7a3_head')) { function _lbeb5101d7a3_head($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block _flash
//
if (!function_exists($_l->blocks['_flash'][] = '_lb544b3ed6fe__flash')) { function _lb544b3ed6fe__flash($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('flash', FALSE)
;$iterations = 0; foreach ($flashes as $flash) { ?>	<div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } 
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb4667fcb816_scripts')) { function _lb4667fcb816_scripts($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<script src="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/js/jquery.js"></script>
	<script src="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/js/netteForms.js"></script>
	<script src="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/js/nette.ajax.js"></script>
        <script src="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/js/main.js"></script>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
<?php if (isset($robots)) { ?>	<meta name="robots" content="<?php echo htmlSpecialChars($robots) ?>">
<?php } ?>

	<title><?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->upper($template->striptags(ob_get_clean()))  ?></title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/css/screen.css">
        
        <link rel="stylesheet" href="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/css/jumbotron-narrow.css">
	<link rel="shortcut icon" href="<?php echo htmlSpecialChars(Nette\Templating\Helpers::safeUrl($basePath)) ?>/favicon.ico">
	<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

</head>

<body>
	<script> document.documentElement.className+=' js' </script>
<div id="<?php echo $_control->getSnippetId('flash') ?>"><?php call_user_func(reset($_l->blocks['_flash']), $_l, $template->getParameters()) ?>
</div>        
        <div class="container">
        <div class="header">
          <ul class="nav nav-pills pull-right">
            <li class="active"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>
">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
            <h3 class="text-muted"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>
">Cinema</a></h3>
        </div>
            
            
<?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
                <div class="footer">
          <p>&copy; Roman Pechal 2014</p>
        </div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
</body>
</html>
