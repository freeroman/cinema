<?php //netteCache[01]000368a:2:{s:4:"time";s:21:"0.84587800 1399830302";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:54:"C:\dev\www\cinema\app\templates\Homepage\booking.latte";i:2;i:1399830294;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:22:"released on 2014-03-17";}}}?><?php

// source file: C:\dev\www\cinema\app\templates\Homepage\booking.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'auh9kpn2va')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb7ea9d9ce40_content')) { function _lb7ea9d9ce40_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <h2><a class="btn btn-default" href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>
">« Back</a></h2>
            </div>
            <div class="col-md-8 text-center">
                <h2><?php echo Nette\Templating\Helpers::escapeHtml($performance['name'], ENT_NOQUOTES) ?></h2>
                <h3>Starts at <?php echo Nette\Templating\Helpers::escapeHtml($template->date($performance['start_dt'], 'd. M H:i'), ENT_NOQUOTES) ?></h3>
            </div>
            <div class="col-md-2">
                <h2><a id="proceed" class="btn btn-default" href="<?php echo htmlSpecialChars($_control->link("Homepage:proceed")) ?>
">Proceed »</a></h2>
            </div>
        </div>
            <label>Numb of seats</label>
            <select id="seats-number" class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        <div class="cinema" style="position: relative; width: 210px"<?php echo ' id="' . $_control->getSnippetId('seats') . '"' ?>>
<?php call_user_func(reset($_l->blocks['_seats']), $_l, $template->getParameters()) ?>
        </div>
    </div>
</div><?php
}}

//
// block _seats
//
if (!function_exists($_l->blocks['_seats'][] = '_lb6a7c6ddd85__seats')) { function _lb6a7c6ddd85__seats($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('seats', FALSE)
;$iterations = 0; foreach ($seats as $key => $seat) { ?>
                <a id="<?php echo htmlSpecialChars($key) ?>" class="ajax" href="#"><div class="<?php echo htmlSpecialChars($template->stateColor($seat)) ?>" style="float: left;"></div></a>
<?php $iterations++; } 
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
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 