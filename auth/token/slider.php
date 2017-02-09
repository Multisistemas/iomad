<?php
/**
* Code use for Slider
* @author Ayaj.Mulani
* @since Feb 22 of 2016
* @paradiso
*/

global $CFG, $PAGE, $OUTPUT,$DB;

$dbman = $DB->get_manager();

if($dbman->table_exists('slider_images'))
{



$ru = "http://".$_SERVER['HTTP_HOST'];
$rst= $DB->get_record_sql("SELECT * FROM {config_plugins} WHERE name LIKE 'companydomain%' AND VALUE like '%".$ru."%'");
if($rst){
    $company_id = (int) str_replace('companydomain', '', $rst->name);
} else {
    $company_id = null;
}

require_once $CFG->dirroot . '/theme/paradisolmsfull/classes/settings/login.php';
// $generalLoginSettings = new theme_paradisolmsfull_settings_login(null);
// $generalLoginSettings->load();
// $generalLSettings = $generalLoginSettings->getSettings();
 
$slider_effect = get_config('theme_paradisolmsfull'.$company_id, 'slider_effect_login_page');
$time_interval = get_config('theme_paradisolmsfull'.$company_id, 'slider_interval_login_page');

/**
* Get images saved in config then create a javascript var ( img_upload_thumbnail_file ) 
* and asign that values to it
* @author Esteban E.
* @since March 17 of 2016
* @paradiso
*/

if($companyId==NULL)
{
    $companyIdparced = '0' ;
}else 
{
  $companyIdparced = $companyId ;
}

$imgs = $DB->get_records_sql('select file_name from {slider_images} where companyid = ? ', array($companyIdparced));
foreach ($imgs as $key => $value) {
    $arrayimages[] = $value->file_name ;
}

$arrayimages = json_encode($arrayimages);

echo html_writer::tag('script', "var img_upload_thumbnail_file ='" . $arrayimages ."';");
/**
* Validate if the actual login page belongs to a tenant the load images from company folder
* if not the load default folder mdata/imgs/loginpage 
* @author Esteban E.
* @since March 17 of 2016
* @paradiso
*/
if(!empty($company_id))
{
 $urltolookup = $CFG->wwwroot.'/theme/paradisolmsfull/plugins/ImageUploader/lib/get_image_thumbnail.php?action=route&route=loginpage/'.$company_id.'/';
}
else 
{
 $urltolookup = $CFG->wwwroot.'/theme/paradisolmsfull/plugins/ImageUploader/lib/get_image_thumbnail.php?action=route&route=loginpage/';
}


 }
/**
* Asign url to search images to a var then add the files name to it 
* @author Esteban E.
* @since March 17 of 2016
* @paradiso
*/
?>
<script type="text/javascript">

    var urltolookup ='<?php echo $urltolookup ?>';

    /**
    * add extra validation if the user save settign without uploading 
    * images then don allow to show the slider
    * @author Esteban E.
    * @since March 31 of 2016
    * @paradiso
    */
    if(img_upload_thumbnail_file != null && img_upload_thumbnail_file != '')
    {

    img_upload_thumbnail_file_parsed = JSON.parse(img_upload_thumbnail_file);
    
    var ArrayOfImagesToSlide = new Array() ;    
    for(var i =0 ; i < img_upload_thumbnail_file_parsed.length;i++)
    {   
        ArrayOfImagesToSlide.push({image: urltolookup+img_upload_thumbnail_file_parsed[i] , title : 'Image Credit: Maria Kazvan'} );
    }
    jQuery(function($){
 
     $.supersized({
         
        // Functionality
        slide_interval          :   3000,       // Length between transitions
        transition              :   <?php echo $slider_effect; ?> ,          // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        transition_speed        :   <?php echo $time_interval; ?>,        // Speed of transition
                                                   
        // Components                           
        slide_links             :   'blank',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
        slides                  :   ArrayOfImagesToSlide

        });
     
    });
        
    }
     
</script>