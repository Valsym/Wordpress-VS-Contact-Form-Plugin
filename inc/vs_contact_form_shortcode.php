<?php

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
        $vs_contact_form->deliver_mail();
        $vs_contact_form->html_form_code();
        return ob_get_clean();
    }

}
$vs_contact_form_shortcode = new vs_contact_form_shortcode;

?>
