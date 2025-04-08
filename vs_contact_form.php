<?php
/*
Plugin Name: VS Contact Form Plugin
Plugin URI:  https://github.com/Valsym/Wordpress-VS-Contact-Form-Plugin/
Description: Creates an interfaces to manage contact form on your website. Useful for showing contact form based information quickly. Includes both a widget and shortcode for ease of use.
Version:     2.0.0
Author:      Valery Simonov
Author URI:  https://github.com/Valsym/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

class vs_contact_form {

    public function __construct(){

        add_action('wp_enqueue_scripts', array($this,'enqueue_public_scripts_and_styles')); // scripts and styles
        register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
        register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook

    }

    public function html_form_code() {
        //output
        $html = '<div class="field-container">';
        $html .= '<p>Пожалуйста, введите ваши контактные данные и короткое сообщение ниже,<br> и я постараюсь ответить на ваш запрос как можно скорее.</p>';
        $html .= '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        $html .= '<p class="field">';
        $html .= 'Ваше имя (*) <br />';
        $html .= '<input type="text" name="cf-name" pattern="[a-zA-Z0-9а-яА-Я ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" placeholder="Your Name" />';
        $html .= '</p>';
        $html .= '<p class="field">';
        $html .= 'Ваш Email (*) <br />';
        $html .= '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" placeholder="Your Email" />';
        $html .= '</p>';
        $html .= '<p class="field">';
        $html .= 'Тема сообщения (*) <br />';
        $html .= '<input type="text" name="cf-subject" pattern="[a-zA-Zа-яА-Я ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40" placeholder="Subject" />';
        $html .= '</p>';
        $html .= '<p class="field">';
        $html .= 'Ваше сообщение (*) <br />';
        $html .= '<textarea rows="10" cols="35" name="cf-message" placeholder="Your Message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
        $html .= '</p>';
        $html .= '<p><input type="submit" name="cf-submitted" value="Отправить"/></p>';
        $html .= '<p>* - требуется ввести данные</p>';
        $html .= '</form></div>';

        return $html;
    }
    public function deliver_mail() {
        // if the submit button is clicked, send the email
        if ( isset( $_POST['cf-submitted'] ) ) {

            // sanitize form values
            $name    = sanitize_text_field( $_POST["cf-name"] );
            $email   = sanitize_email( $_POST["cf-email"] );
            $subject = sanitize_text_field( $_POST["cf-subject"] );
            $message = esc_textarea( $_POST["cf-message"] );
            // get the blog administrator's email address
            $to = get_option( 'admin_email' );
            $headers = "From: $name <$email>" . "\r\n";
            // If email has been process for sending, return a success message
            $html = '';
            if ( wp_mail( $to, $subject, $message, $headers ) ) {
                $html .= '<div>';
                $html .= '<p>Спасибо, что связались со мной, ожидайте ответа в ближайшее время.</p>';
                $html .= '</div>';
            } else {
                $html .= 'Произошла ошибка. Попробуйте еще раз.';
            }
            return $html;
        }
    
    }

    //enqueues scripts and styled on the front end
	public function enqueue_public_scripts_and_styles(){
		wp_enqueue_style('cf_styles', plugin_dir_url(__FILE__). '/css/cf_styles.css');
		
	}

}
$vs_contact_form = new vs_contact_form;

//include shortcodes
include(plugin_dir_path(__FILE__) . 'inc/vs_contact_form_shortcode.php');

?>
