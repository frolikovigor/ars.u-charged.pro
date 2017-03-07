<?php
/**
 * J!Blank Template for Joomla by JBlank.pro (JBZoo.com)
 *
 * @package    JBlank
 * @author     SmetDenis <admin@jbzoo.com>
 * @copyright  Copyright (c) JBlank.pro
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 * @link       http://jblank.pro/ JBlank project page
 */

defined('_JEXEC') or die;


// init $tpl helper
require dirname(__FILE__) . '/php/init.php';

?><?php echo $tpl->renderHTML(); ?>
<head>
    <?php
    $document = JFactory::getDocument();
    $headData = $document->getHeadData();
    $scripts = $headData['scripts'];
    unset($scripts['/media/jui/js/jquery.min.js']);
    unset($scripts['/media/jui/js/jquery-noconflict.js']);
    unset($scripts['/media/jui/js/jquery-migrate.min.js']);
    $headData['scripts'] = $scripts;
    $document->setHeadData($headData);
    ?>
    <script src="/templates/jblank/js/jquery-2.2.4.min.js"></script>
    <jdoc:include type="head" />
    <!--[if (gt IE 9)|!(IE)]><!--><link href="/dev/static/css/separate-css/accordion.css" rel="stylesheet" type="text/css"><!--<![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--><link href="/dev/static/css/main.css" rel="stylesheet" type="text/css"><!--<![endif]-->
</head>
<?php
  $pageClassSuffix = JFactory::getApplication()->getMenu()->getActive()? JFactory::getApplication()->getMenu()->getActive()->params->get('pageclass_sfx', '-default') : '-default';
?>
<body class="<?php echo $tpl->getBodyClasses(); ?> <?php echo $pageClassSuffix ?>">

    <!--[if lt IE 7]><p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience. </p><![endif]-->


    <!--
        Your HTML code starts here!
    -->

    <?php if ($tpl->isMobile()) : ?>
        <!-- only for mobiles  -->
    <?php endif; ?>

    <?php if ($tpl->isTablet()) : ?>
        <!-- only for tablets  -->
    <?php endif; ?>

    <?php
    require_once "php/libs/simplehtmldom/simple_html_dom.php";

    $articleCurrentId = (JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article')? JRequest::getInt('id') : 0;
    $tablePlan         = & JTable::getInstance('Content', 'JTable');
    $tablePlanReturn  = $tablePlan->load(array('id'=>$articleCurrentId));

    $htmlPage = $tablePlan->introtext;

    //Применение шаблонов
    $listTemplates = array();
    $handle = opendir($tpl -> partial);
    while (false !== ($getFileTemplate = readdir($handle))) {
        if (strpos($getFileTemplate, ".php") !== false) $listTemplates[] = strtr($getFileTemplate, array(".php" => ""));
    }
    closedir($handle);

    foreach ($listTemplates as $templateItem) {
        $owerflowTemplate = 0;
        while(
            (false !== ($posTemplateS = strpos($htmlPage, "[".$templateItem))) &&
            (false !== ($posTemplateE = strpos($htmlPage, "[/".$templateItem."]", $posTemplateS)))
        ) {
            $owerflowTemplate++;
            if ($owerflowTemplate > 1000) break;
            $templateString = substr($htmlPage, $posTemplateS, $posTemplateE+strlen("[/".$templateItem."]") - $posTemplateS);
            $templateString = strtr($templateString, array("[".$templateItem => "<div","[/".$templateItem."]" => "</div>"));
            if (mb_substr_count($templateString,"]") != 1) continue;
            $templateString = strtr($templateString, array("]" => ">"));
            $templateString = str_get_html($templateString);
            $templateString = $templateString->find('div',0);

            $paramsTemplate = isset($templateString -> attr) ? $templateString -> attr : array();
            $paramsTemplate['content'] = $templateString -> innertext;

            $htmlPage = substr_replace(
                $htmlPage,
                $tpl->partial($templateItem, $paramsTemplate),
                $posTemplateS,
                $posTemplateE+strlen("[/".$templateItem."]") - $posTemplateS
            );
        }
    }

    echo $htmlPage;
    ?>

    <jdoc:include type="modules" name="post_component" />

<!--    <script src="/media/jui/js/jquery-noconflict.js"></script>-->
    <script src="/media/jui/js/jquery-migrate.min.js"></script>
    <script src="/media/system/js/caption.js"></script>
    <script src="/templates/jblank/js/template.js?254"></script>

    <script src="/dev/static/js/separate-js/accordion.js"></script>
    <script src="/templates/jblank/js/libs/jquery.animation.easing.js"></script>

    <script src="/dev/static/js/separate-js/jquery.dotdotdot.min.js"></script>
    <script src="/dev/static/js/separate-js/jquery.touchSwipe.min.js"></script>
    <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
    <script src="/dev/static/js/main.js"></script>
</body>
</html>
