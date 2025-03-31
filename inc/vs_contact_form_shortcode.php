<?php
/*
 * Wp contact form Shortcode
 * A shortcode created to display a contact form when used in the post or page editor
 */


//defines the functionality for the contact form shortcode
class vs_contact_form_shortcode {

    //on initialize
    public function __construct(){
        add_action('init', array($this,'register_contact_form_shortcode')); //shortcodes
    }

    //location shortcode
    public function register_contact_form_shortcode(){
        add_shortcode('vs_contact_form', array($this,'vs_contact_form_shortcode_output'));
    }

    //shortcode display
    public function vs_contact_form_shortcode_output($atts, $content = '', $tag){

        //get the global vs_contact_form class
        global $vs_contact_form;

        ob_start();
        echo $vs_contact_form->deliver_mail();
        echo $vs_contact_form->html_form_code();
        return ob_get_clean();
    }

}

$vs_contact_form_shortcode = new vs_contact_form_shortcode;

?>
