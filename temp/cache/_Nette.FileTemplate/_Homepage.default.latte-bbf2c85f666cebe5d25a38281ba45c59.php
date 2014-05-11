<?php //netteCache[01]000368a:2:{s:4:"time";s:21:"0.77834900 1399812489";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:54:"C:\dev\www\cinema\app\templates\Homepage\default.latte";i:2;i:1399810768;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:22:"released on 2014-03-17";}}}?><?php

// source file: C:\dev\www\cinema\app\templates\Homepage\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'o0u4l40td1')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbaed05ee000_content')) { function _lbaed05ee000_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="jumbotron">
    <h2>Upcoming performances</h2>
<?php $iterations = 0; foreach ($performances as $show) { ?>
    <a href="<?php echo htmlSpecialChars($_control->link("Homepage:booking", array($show->id_performances))) ?>
">
        <div class="panel panel-default show-md">
            <div class="panel-body">
                <?php echo Nette\Templating\Helpers::escapeHtml($show->name, ENT_NOQUOTES) ?>
 at <?php echo Nette\Templating\Helpers::escapeHtml($template->date($show->start_dt, 'd. M H:i'), ENT_NOQUOTES) ?>

            </div>
        </div>
    </a>
<?php $iterations++; } ?>
</div>

<div class="md-modal">
<?php $_ctrl = $_control->getComponent("tickets"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->redrawControl(NULL, FALSE); $_ctrl->render() ?>
</div>
<div class="md-overlay"></div><?php
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

<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 