<?php
include_once ("../../config.php");
include_once ("locallib.php");
global $CFG, $PAGE, $OUTPUT;
/**
* Add css custom for the login, this is php render with javascript
* @author Andres Ag.
* @since September 07 of 2015
* @paradiso
*/
//echo $CFG->wwwroot . '/theme/paradisolmsfull/style/login_settings.css.php';

$PAGE->requires->css(new moodle_url('/theme/paradisolmsfull/style/login_page.css'));
$PAGE->requires->js( new moodle_url($CFG->wwwroot . '/auth/token/script.js') );
$PAGE->requires->css(new moodle_url('/theme/paradisolmsfull/style/login_settings.css.php'));/**
* get value from slider setting then add required files
* @author Esteban E.
* @since March 18 of 2015
* @paradiso
*/

$ru = "http://".$_SERVER['HTTP_HOST'];
$rst= $DB->get_record_sql("SELECT * FROM {config_plugins} WHERE name LIKE 'companydomain%' AND VALUE like '%".$ru."%'");
if($rst){
    $company_id = (int) str_replace('companydomain', '', $rst->name);
} else {
    $company_id = null;
}
/*
* Move to layout /theme/paradisolmsfull/layout/login.php because that generate a not valid html
* @author Andres Ag.
* @since August 16 of 2016
* @paradiso
*/
/*
$bgsetting = get_config('theme_paradisolmsfull', 'bgsetting'.$company_id);
$slider_effect = get_config('theme_paradisolmsfull', 'slider_effect_login_page'.$company_id);
if(!empty($slider_effect) && empty($bgsetting))
{
    $PAGE->requires->css(new moodle_url('/theme/paradisolmsfull/style/supersized.css'));
    $PAGE->requires->js( new moodle_url($CFG->wwwroot . '/auth/token/script.js') );

    ?>
    <script src="<?php echo $CFG->wwwroot;?>/theme/paradisolmsfull/javascript/image_slider.js"></script>
    <script src="<?php echo $CFG->wwwroot;?>/theme/paradisolmsfull/javascript/supersized.3.2.7.min.js"></script>
    <?php

    require_once ($CFG->dirroot . '/auth/token/slider.php');
}
*/

/**
* Commended because this a insecurity featured
* @modified uncommented to add ajax validation to user guest Esteban E. 20/06/2016
* @author Andres Ag.
* @since April 12 of 2016
* @paradiso
*/
$PAGE->requires->js( new moodle_url($CFG->wwwroot . '/auth/token/script.js') );
if(isset($CFG->customloginpage) && $CFG->customloginpage == true && !isset($_GET['lmslogin'])){
    require_once('custom-login.php');
    exit();
}
/**
* Get the settings (for general) of the login
* @author Andres Ag.
* @since date
* @paradiso
*/
require_once $CFG->dirroot . '/theme/paradisolmsfull/classes/settings/login.php';
$generalLoginSettings = new theme_paradisolmsfull_settings_login(null);
$generalLoginSettings->load();
$generalLSettings = $generalLoginSettings->getSettings();
/**
 * Get the settings (for company) of the login
 * @author Andres Ag.
 * @since September 08 of 2015
 */
global $DB;
$ru = "http://".$_SERVER['HTTP_HOST'];
$rst= $DB->get_record_sql("SELECT * FROM {config_plugins} WHERE name LIKE 'companydomain%' AND VALUE like '%".$ru."%'");
if($rst){
    $company_id = (int) str_replace('companydomain', '', $rst->name);
} else {
    $company_id = null;
}
$companyLoginSettings = new theme_paradisolmsfull_settings_login($company_id);
$companyLoginSettings->load($company_id);
$companyLSettings = $companyLoginSettings->getSettings($company_id);

//------------------------------------------------------ Review browser and SF Integration -------------------------------------------------------
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
if(count($matches)<2){
  preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
}
if (count($matches)>1){
  //Then we're using IE
  $version = $matches[1];
  switch(true){
    case ($version<=8):
      //IE 8 or under!
      break;
    case ($version==9 || $version==10):
      if (strpos($_SERVER['HTTP_REFERER'],'pss_SSO') !== false) {
        echo   "<div style='padding-left:10px;padding-top:10px;height:120px; width: 600px; color:white; border; border-style: solid;
                border-color: red;'>If you are seeing this message you need configure your browser as indicated bellow:
            <ul type='circle' style='padding-top:10px;'>
            <li>Open Internet Explorer by clicking the Start button Picture of the Start button, and then clicking Internet Explorer.</li>
            <li>Click the Tools button, and then click Internet Options.</li>
            <li>Click the Privacy tab, and then, under Settings, move the slider to the down in order to accept all cookies. Accept and Apply.</li>
            <li>Once you have set this up on Internet Explorer and saved the changes click on your SF Training tab again.</li>
            </ul></div>";
      }
      break;
    case ($version==11):
      if (strpos($_SERVER['HTTP_REFERER'],'pss_SSO') !== false) {
        echo   "<div style='padding-left:10px;padding-top:10px;height:120px; width: 70%; color:white; border; border-style: solid;
                border-color: red;'>If you are seeing this message you need configure your browser as indicated bellow:
            <ul type='circle' style='padding-top:10px;'>
            <li>Open Internet Explorer by clicking the Start button Picture of the Start button, and then clicking Internet Explorer.</li>
            <li>Click the Tools button, and then click Internet Options.</li>
            <li>Click the Privacy tab, and then, under Settings, move the slider to the down in order to accept all cookies. Accept and Apply.</li>
            <li>Once you have set this up on Internet Explorer and saved the changes click on your SF Training tab again.</li>
            </ul></div>";
      }
      //Version 11!
      break;
    default:
      //You get the idea
  }
}
$safari = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
if ($safari) {
    if (strpos($_SERVER['HTTP_REFERER'],'pss_SSO') !== false) {
        echo   "<div style='padding-left:10px;padding-top:10px;height:120px; width: 70%; color:white; border; border-style: solid;
                border-color: red;'>If you are seeing this message you need configure your browser as indicated bellow:
            <ul type='circle' style='padding-top:10px;'>
            <li>Open Safari by clicking the Start button Picture of the Start button, and then clicking Safari.</li>
            <li>Click the Tools button, and then click Preferences.</li>
            <li>Click the Privacy tab, and then, under block cookies, select Never.</li>
            <li>Once you have set this up on Safari and saved the changes click on your SF Training tab again.</li>
            </ul></div>";
    }
}
//------------------------------------------------------ Review browser and SF Integration -------------------------------------------------------
//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE -> https_required();
//$context = get_context_instance(CONTEXT_SYSTEM);
$context = context_system::instance();
$PAGE -> set_url("$CFG->httpswwwroot/auth/token/login.php");
$PAGE -> set_context($context);
$PAGE -> set_pagelayout('login');
if (!empty($CFG -> registerauth) or is_enabled_auth('none') or !empty($CFG -> auth_instructions)) {
    $show_instructions = true;
} else {
    $show_instructions = false;
}


$oidc = null;
$authsequence = get_enabled_auth_plugins(true);
$potentialidps = array();
foreach($authsequence as $authname)
{
    $authplugin = get_auth_plugin($authname);

    if('oidc' == $authname)
    {
        $tmp = $authplugin->loginpage_idp_list($SESSION->wantsurl);
        if(is_array($tmp) && count($tmp))
        {
            $oidc = current($tmp);
        }
    }
    else
    {
        $potentialidps = array_merge($potentialidps, $authplugin->loginpage_idp_list($SESSION->wantsurl));
    }
}

/// Define variables used in page
$site = get_site();
$loginsite = get_string("loginsite");
$PAGE -> navbar -> add($loginsite);
$PAGE -> set_title("$site->fullname: $loginsite");
$PAGE -> set_heading("$site->fullname");
$CFG -> additionalhtmlhead = "<style>
.tab-content table{border:0px}
.tab-content table td{background-color:transparent !important;border:0px !important}
.nav-tabs a{background-color:#ccc}
.nav-tabs li.active a{background-color:#fff}
.subcontent ol{text-align:left;font-size:12px}
.loginsub{position:relative;top:-125px}
#language_picker{position:relative;width:100px;top:-50px;left:90%;z-index:10000;}
</style>";
echo $OUTPUT -> header();
if (isset($show_instructions)) {
    $columns = 'twocolumns';
} else {
    $columns = 'onecolumn';
}
if (empty($CFG -> xmlstrictheaders) and !empty($CFG -> loginpasswordautocomplete)) {
    $autocomplete = 'autocomplete="off"';
} else {
    $autocomplete = '';
}
?>

 <?php 
/**
 * Move login as guest form to this place to prevent error with HTML/PHP structure
 * and allow works properly the form
 * @author Esteban E.
 * @since June 20 of 2016
 */

 if ($CFG->guestloginbutton and !isguestuser()) { ?>
    <div class="subcontent guestsub" style="display:none;">
    <div class="desc">
      <?php print_string("someallowguest") ?>
    </div>
    <form action="<?php echo $CFG->httpswwwroot; ?>/login/index.php" method="post" name="guestlogin" id="guestlogin">
      <div class="guestform">
        <input type="hidden" name="username" value="guest" />
        <input type="hidden" name="password" value="guest" />
        <input type="submit" value="<?php print_string("loginguest") ?>" />
      </div>
    </form>
    </div>
 <?php } ?>

<div class="loginbox clearfix">
    <div class="loginpanel">
    <?php if (($CFG->registerauth == 'email') || !empty($CFG->registerauth)) : ?>
        <div class="skiplinks"><a class="skip" href="<?php echo $CFG -> httpswwwroot; ?>/login/signup.php"><?php print_string("tocreatenewaccount"); ?></a></div>
    <?php endif; ?>

    <?php
    $token_config = get_config('auth/token');
//    print_object($companyLSettings);
    echo '<center id="token">';
    if (in_array('token', $authsequence)) {
        if (isset($token_config -> tokenlogoimage) && $token_config -> tokenlogoimage != NULL) {
            echo '<a href="index.php"><img src="' . $token_config -> tokenlogoimage . '" border="0" alt="TOKEN login" ></a>';
        }
        if (isset($token_config -> tokenlogoinfo)) {
            echo "<div class='desc'>$token_config->tokenlogoinfo</div>";
        }
    }
    echo '</center>';
    ?>

      <div class="subcontent loginsub">
        <!-- LOGIN BANNER -->
        <?php
        /**
        * this code was moved to this place because the welcome message needs to be in the login box not out of them
        * @author Esteban E.
        * @since Feb 23 of 2016
        * @paradiso
        */

         ?>
        <div class="message-login">
            <?php
                if($companyLSettings['companylogintext'] && $companyLSettings['companylogintext'] != '' && $companyLSettings['companylogintext'] != '<p>0</p>'){
                    ?><div class="login_text" ><?php

                    /**
                    * Push the welcome message with the images
                    * @author Andres Ag.
                    * @since May 13 of 2016
                    * @paradiso
                    */
                    $content =  $companyLSettings['companylogintext'];
                    $context_welcome = context_system::instance();
                    $content = file_rewrite_pluginfile_urls($content, 'pluginfile.php', $context_welcome->id, 'theme_paradisolmsfull', 'companylogintext', 0);
                    echo $content;

                    ?></div>
            <?php
                } else {
                    ?><div class="login_text">
<!--                <img class="img-responsive" src="<?php echo $OUTPUT -> pix_url('login_message', 'theme'); ?>" alt="message" />-->
            </div><?php
               }
             ?>
        </div>


        <?php
                if (!empty($errormsg)) {
                    echo '<div class="loginerrors alert alert-warning">';
                    echo $OUTPUT -> error_text($errormsg);
                    echo '</div>';
                }
        ?>


         <?php
        if((!isset($companyLSettings['disable_google']) or !$companyLSettings['disable_google']) or (!isset($companyLSettings['disable_facebook']) or !$companyLSettings['disable_facebook']) or (!isset($companyLSettings['disable_twitter']) or !$companyLSettings['disable_twitter']) or (!isset($companyLSettings['disable_linkedin']) or !$companyLSettings['disable_linkedin']) or (!isset($companyLSettings['disable_createaccount']) or !$companyLSettings['disable_createaccount'])){
         ?>
        <div class="login_div " >
        <?php } else{ ?>
            <div class="login_div " >
           <?php } ?>
            <?php if ($show_instructions) : ?>
                <ul class="nav nav-tabs" style="display: none;" >
                    <li class="active"><a href="#tab_login" data-toggle="tab"><?php echo get_string('login')?></a></li>
                    <li><a href="#tab_create_account" data-toggle="tab"><?php echo get_string('createaccount')?></a></li>
                </ul>
            <?php endif; ?>

            <!-- Tab panes -->
                <div class="tab-content" >


                    <?php

                   // if((isset($generalLSettings['disable_popupbox']) or $generalLSettings['disable_popupbox']) and (isset($generalLSettings['disable_popupboxshadow']) or $generalLSettings['disable_popupboxshadow']) )
                    if($companyLSettings['disable_popupbox']=='' && $companyLSettings['disable_popupboxshadow']=='' )
                    {
                         if((!isset($companyLSettings['disable_google']) or !$companyLSettings['disable_google']) or (!isset($companyLSettings['disable_facebook']) or !$companyLSettings['disable_facebook']) or (!isset($companyLSettings['disable_twitter']) or !$companyLSettings['disable_twitter']) or (!isset($companyLSettings['disable_linkedin']) or !$companyLSettings['disable_linkedin'])or (!isset($companyLSettings['disable_createaccount']) or !$companyLSettings['disable_createaccount']) or ($oidc && (!isset($companyLSettings['disable_oidc']) or !$companyLSettings['disable_oidc']))){
                            ?>
                    <div class="tab-pane active pop_shadow popup_color" id="tab_login" >

                       <?php
                            }


                    }

                    elseif($companyLSettings['disable_popupbox']=='' && $companyLSettings['disable_popupboxshadow']!='' )
                    {
                         if((!isset($companyLSettings['disable_google']) or !$companyLSettings['disable_google']) or (!isset($companyLSettings['disable_facebook']) or !$companyLSettings['disable_facebook']) or (!isset($companyLSettings['disable_twitter']) or !$companyLSettings['disable_twitter']) or (!isset($companyLSettings['disable_linkedin']) or !$companyLSettings['disable_linkedin'])or (!isset($companyLSettings['disable_createaccount']) or !$companyLSettings['disable_createaccount']) or ($oidc && (!isset($companyLSettings['disable_oidc']) or !$companyLSettings['disable_oidc']))){
                            ?>
                    <div class="tab-pane active popup_color" id="tab_login"  >

                        <?php
                                }

                    }

                    else
                    {
                         if((!isset($companyLSettings['disable_google']) or !$companyLSettings['disable_google']) or (!isset($companyLSettings['disable_facebook']) or !$companyLSettings['disable_facebook']) or (!isset($companyLSettings['disable_twitter']) or !$companyLSettings['disable_twitter']) or (!isset($companyLSettings['disable_linkedin']) or !$companyLSettings['disable_linkedin'])or (!isset($companyLSettings['disable_createaccount']) or !$companyLSettings['disable_createaccount']) or ($oidc && (!isset($companyLSettings['disable_oidc']) or !$companyLSettings['disable_oidc']))){
                            ?>
                    <div class="tab-pane active" id="tab_login"  >

                        <?php
                                }

                    }
                      ?>

                        <form action="<?php echo $CFG -> httpswwwroot; ?>/login/index.php" method="post" id="login" <?php echo $autocomplete; ?> >
                            <?php
                                if((!isset($companyLSettings['disable_google']) or !$companyLSettings['disable_google']) or (!isset($companyLSettings['disable_facebook']) or !$companyLSettings['disable_facebook']) or (!isset($companyLSettings['disable_twitter']) or !$companyLSettings['disable_twitter']) or (!isset($companyLSettings['disable_linkedin']) or !$companyLSettings['disable_linkedin']) or (!isset($companyLSettings['disable_createaccount']) or !$companyLSettings['disable_createaccount'])){
                            ?>
                            <div class="col-sm-12">
                            <?php
                                } else {
                                    if ($companyLSettings['disable_popupbox']=='' && $companyLSettings['disable_popupboxshadow']=='' )
                                    {
                            ?>
                         <div class="col-xs-12 pop_shadow popup_color"  >
                       <?php
                            }
                                elseif ($companyLSettings['disable_popupbox']=='' && $companyLSettings['disable_popupboxshadow']!='' )
                                {
                                    ?>
                            <div class="col-xs-12 popup_color"  >
                            <?php

                                }
                                else
                                {
                                    ?>
                            <div class="col-xs-12"  >
                            <?php

                                }

                                }
                            ?>
                                <div class="row">

                                </div>

                                <div class="clearfix"></div>
                                <?php
                                
                                   // if(!isset($CFG->paradiso_hide_lang) || $CFG->paradiso_hide_lang != TRUE){
                                if ($companyLSettings['language_selection'] === FALSE){
                                ?>
                                        <div class="row">

                                            <!-- script for language selection -->
                                            <script>
                                                $(document).ready(function(){
                                                    
                                       
                                                        $('#lang_menu').html($(".langmenu").html());
                                                        
                                                        $("#lang_menu" ).change(function( event ) {
                                                            var value = $(this).val();
                                                            
                                                            url='<?php echo $CFG -> wwwroot; ?>/auth/token/login.php/?lang='+value;
                                                            location.href=url;
                                                        });

                                                 
                                                });
                                            </script>
                                            <!-- end script for language selection -->
                                            <div style="display:none;"><?php echo $OUTPUT -> lang_menu_fullname(); ?></div>
                                            <div class="col-xs-12">
                                                <div class="input-container">
                                                    <i class="fa fa-flag"></i>
                                                <select id="lang_menu" class="form-control flag_space "></select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                                      //  }
                                    ?>

                                        <div class="form-group" id="un" >
                                        <div class="row">


                                            <div class="username_input col-xs-12">
                                                <div class="input-container">
                                                    <i class="fa fa-user"></i>
<!--                                                    Ayaj Mulani Add water mark User name-->
                                                    <input class="form-input form-control"  type="text" placeholder="<?php echo get_string('watermark_username','auth_token') ?>" name="username" id="username" size="30" tabindex="1" />
                                                    <!-- <span id="sign" ></span> -->
                                                </div>
                                                <?php
                                                /**
                                                * Commended because this is a insecurity featured
                                                * @author Andres Ag.
                                                * @since April 12 of 2016
                                                * @paradiso
                                                */
                                                ?>
                                                <!--<div id="er_msg" > <?php echo get_string('auth_token_error_login_page_username_warning','auth_token') ?> </div>-->
<!--                                                Ayaj Mulani warning message while username blank-->
                                                <!--<div id="blk_username" > <?php echo get_string('blk_username','auth_token') ?> </div>-->
                                                <?php
                                                /**
                                                * Commended because this is a insecurity featured
                                                * @author Andres Ag.
                                                * @since April 12 of 2016
                                                * @paradiso
                                                */
                                                ?>
                                                <!--<div id="er_msg" > <?php echo get_string('auth_token_error_login_page_username_warning','auth_token') ?> </div>-->
                                            </div>

                                        </div>
                                    </div>


                                <div class="clearfix"></div>
                                <div id="ps" >
                                            <div class="row">

                                            <div class="password_input col-xs-12 ">
                                                <div class="input-container">
                                                    <i class="fa fa-lock"></i>
<!--                                                    Ayaj Mulani Add water mark and warning message for Password-->
                                                    <input type="password" placeholder="<?php echo get_string('watermark_password','auth_token') ?>" name="password" id="password" size="30" value="" <?php echo $autocomplete; ?> tabindex="2"/>
                                                </div>
                                                <?php
                                                /**
                                                * Commended because this is a insecurity featured
                                                * @author Andres Ag.
                                                * @since April 12 of 2016
                                                * @paradiso
                                                */
                                                ?>
                                                <!--<div id="password_msg" > <?php echo get_string('password_warning','auth_token') ?> </div>-->
<!--                                                Ayaj Mulani warning message while password blank-->                                                
                                                <!--<div id="blk_password" > <?php echo get_string('blk_password','auth_token') ?> </div>-->
                                            </div>
                                        </div>
                                    </div>

                                        <?php if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) : ?>
                                            <div class="row">
                                                <div class="rememberpass col-xs-12 col-sm-12">
                                                   &nbsp<input  type="checkbox" name="rememberusername" id="rememberusername" value="1" tabindex="3"/>
                                                    <label id="rememberusername_text" style="padding-right:50px; " for="rememberusername" ><?php echo print_string('rememberusername', 'admin') ?></label>

<!--                                                    <br> <a id="forgot" style="margin-left:0px;" href="<?php echo $CFG -> httpswwwroot; ?>/login/forgot_password.php"><?php echo get_string("forgot", 'core_paradisolms') ?></a>-->
<!--                                                    <input  type="submit" class="btn btn-login btn-lg" data-toogle="button" value="<?php print_string("login") ?>" style="font-size: 16px" />-->

                                               </div>
                                            </div>

                                        <?php endif; ?>

                                <div class="row" >
                                    <div class="col-md-8">
                                        <a class="forgot" id="forgot" href="<?php echo $CFG -> httpswwwroot; ?>/login/forgot_password.php"><?php echo get_string("forgot", 'core_paradisolms') ?></a>
                                    </div>
                                    <div class="col-md-4 login_btn" >
<!--                                        Ayaj Mulani Add Id of login button -->
                                                    <input  type="submit" class="btn btn-login btn-lg btn btn-primary" id="login_btn" data-toogle="button" value="<?php print_string("login") ?>" style="font-size: 16px;" />
                                               </div>
                                            </div>
                                <?php
                                 if ($companyLSettings['disable_google']!='' && $companyLSettings['disable_facebook']!='' && $companyLSettings['disable_twitter']!='' && $companyLSettings['disable_linkedin']!='' && $companyLSettings['disable_createaccount']!='' ){
                                ?>

                                 <?php }else {?>
                                <div class="row">
                                               <div  class=" col-xs-12 col-sm-12 or-text">
                                                   <div  class="form-label col-xs-12 col-sm-12 col-sm-offset-5" style="font-size: 14px; ">
                                                <?php echo get_string('or','auth_token') ?>
                                            </div>
                                               </div>
                                            </div>
                                <?php }?>

                                <div class="row">
                                        <div class="col-md-6 " >
                                            <?php
                                                if(!isset($companyLSettings['disable_google']) or $companyLSettings['disable_google']==''){
                                             ?>
                                                    <a href="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/google_request.php"><img width="30" height="30" src="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/img/googleplus-icon.png"></a>
                                            <?php
                                            }
                                                if(!isset($companyLSettings['disable_facebook']) or $companyLSettings['disable_facebook']==''){
                                            ?>
                                                    <a href="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/facebook_request.php"><img width="30" height="30" src="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/img/facebook_box-icon.png"></a>
                                            <?php
                                                }
                                                
                                                if(!isset($companyLSettings['disable_twitter']) or $companyLSettings['disable_twitter']==''){
                                            ?>
                                                    <a href="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/twitter_request.php"><img width="30" height="30" src="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/img/twitter-icon.png"></a>
                                                     <?php
                                                }
                                                
                                                if(!isset($companyLSettings['disable_linkedin']) or $companyLSettings['disable_linkedin']==''){
                                            ?>
                                                    <a href="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/linkedin_request.php"><img width="28" height="28" src="<?php echo $CFG -> httpswwwroot; ?>/auth/elcentra/img/Linkedin-icon.png"></a>
                                            <?php
                                                }
                                            ?>

                                            <?php
                                                if(!isset($companyLSettings['disable_clever']) or $generalLSettings['disable_clever']==''){ ?>
                                                <a id="img-cleaver" href="<?php echo $CFG -> httpswwwroot; ?>/local/clever/login_request.php"><img src="<?php echo $CFG -> httpswwwroot; ?>/local/clever/pix/sign-in-with-clever-micro.png"></a>
                                            <?php
                                                }
                                            ?>
                                       </div>

                                       <div class="col-md-6 ">
                                             <?php
                                                    if(!isset($companyLSettings['disable_createaccount']) or $companyLSettings['disable_createaccount']==''){
                                                ?>
                                                <!-- <form action="<?php echo $CFG->httpswwwroot; ?>/login/signup.php" method="get" id="signup">-->
                                                <!-- <input type="button" class="btn btn-login btn-lg" data-toogle="button" value="<?php print_string("startsignup") ?>" onclick="location.href='<?php echo $CFG -> httpswwwroot; ?>/lms/index.php'" /> -->
                                                <?php if(isset($CFG->paradiso_sales) && 1 == $CFG->paradiso_sales) : ?>

                                                        <input  type="button" class="signup_btn btn btn-primary" value="<?php print_string("startsignup") ?>" onclick="location.href='http://lmstrial.paradisosolutions.com/elearning/lms/index.php'" style="" >
<!--                                                              <a id="forgot" style="margin-right:0px;" href="http://lmstrial.paradisosolutions.com/elearning/lms/index.php"><?php print_string("startsignup") ?> </a>-->
                                                <?php else : ?>
                                                       <input  type="button" class="signup_btn loginpagebuttons_settings btn btn-primary" value="<?php print_string("startsignup") ?>" onclick="location.href='<?php echo $CFG->httpswwwroot; ?>/login/signup.php'" style="" >

<!--                                                              <a id="forgot"  href="<?php echo $CFG->httpswwwroot; ?>/login/signup.php"><?php print_string("startsignup") ?></a>-->
                                                        <?php endif;
                                                            }
                                                        ?>
                                                        <?php 
                                                        /**
                                                         * This button will fire the login as guest form allowing to login user as guest
                                                         * if the setting $CFG->guestloginbutton is turned to show 
                                                         * @author Esteban E.
                                                         * @since June 20 of 2016
                                                         */
                                                        if ($CFG->guestloginbutton and !isguestuser()) { ?>
                                                            <input id="guestloginbtn" class="loginguest_btn  btn btn-primary" type="button" value="<?php print_string("loginguest") ?>" />
                                                        <?php } ?>
                                               </div>

                                    </div>



                                </div>
                            <div class="clearfix"></div>

                        </div>
                                <div class="tab-pane" id="tab_create_account">
                        <?php if (!isset($show_instructions)) : ?>
                            <div class="signuppanel">
                              <h2><?php print_string("firsttime") ?></h2>
                              <div class="subcontent">
                        <?php     if (is_enabled_auth('none')) { // instructions override the rest for security reasons
                                      print_string("loginstepsnone");
                                  } else if ($CFG->registerauth == 'email') {
                                      if (!empty($CFG->auth_instructions)) {
                                          echo format_text($CFG->auth_instructions);
                                      } else {
                                          print_string("loginsteps", "", "signup.php");
                                      } ?>
                                         <div class="signupform">
                                           <form action="<?php echo $CFG -> httpswwwroot; ?>/login/signup.php" method="get" id="signup">
                                           <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                                           </form>
                                         </div>
                        <?php     } else if (!empty($CFG->registerauth)) {
                                                            echo format_text($CFG->auth_instructions);
 ?>
                                      <div class="signupform">
                                        <form action="<?php echo $CFG -> httpswwwroot; ?>/login/signup.php" method="get" id="signup">
                                        <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                                        </form>
                                      </div>
                        <?php     } else {
                                                        echo format_text($CFG->auth_instructions);
                                                        }
 ?>
                              </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
      </div>

     </div>




<?php if (0 && !empty($potentialidps)) { ?>
    <div class="subcontent potentialidps">
        <h6><?php print_string('potentialidps', 'auth'); ?></h6>
        <div class="potentialidplist">
<?php
foreach ($potentialidps as $idp) {
    echo '<div class="potentialidp"><a href="' . $idp['url'] -> out() . '" title="' . $idp['name'] . '">' . $OUTPUT -> render($idp['icon'], $idp['name']) . '&nbsp;' . $idp['name'] . '</a></div>';
}
 ?>
        </div>
    </div>
<?php } ?>
                    <div class="footer" > 
                        <?php
                        /**
                        * show the Powered by Text with Hypertext
                        * @author Ayaj M
                        * @since Feb 29 of 2016
                        * @paradiso
                        */
                        $show_pwr = get_config('local_paradisolms', 'login_show_pwr');
                        $pwr_text = get_config('local_paradisolms', 'login_pwr_text'); 
                        $pwr_url .='http://';
                        $pwr_url .= get_config('local_paradisolms', 'login_pwr_url');
                        echo "<div id='pwr_text' style='display:$show_pwr' align='$show_pwr'>"; 
                        if(get_config('local_paradisolms', 'login_pwr_url')!='')
                        {
                            echo '<a target="_blank" href="'.$pwr_url.'">'.$pwr_text.'</a>';
                        }
                        else
                        {
                            echo $pwr_text;
                        }
                        echo '</div>';
                        ?>
                    </div></div>

<?php
if (!empty($CFG -> loginpageautofocus)) {
    //focus username or password
    $PAGE -> requires -> js_init_call('M.util.focus_login_form', null, true);
}
echo $OUTPUT -> footer();
