<?php 

/**
 *
 *
 *      @Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Api;

use MiamiTrips\Base\BaseController;


class Ajax extends BaseController{
    public function register(){

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        //Add Words Ajax
        add_action( 'wp_ajax_AddWord', array( $this, 'AddWord' ) ); 
        add_action( 'wp_ajax_nopriv_AddWord', array( $this, 'AddWord' ) );
        //Search words ajax
        add_action('wp_ajax_SearchWord' , array($this , 'searchWord'));
        add_action('wp_ajax_nopriv_SearchWord' , array($this , 'searchWord'));
    }


    public function AddWord(){
        
        if(! DOING_AJAX )
            return false;


        if(!check_ajax_referer( 'search_autobody', 'nonce' ))
            return false;        

       

        $word = sanitize_text_field($_POST['term']);


        $insert = $this->wpdb->insert( $this->base_table_name , array(
            'name' => $word,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ,
        ));


        if($insert){
            $return = array(
                'message'       => 'The word <i>' . $word . '</i> is successfully added' , 
                'classesAdded'  => 'alert alert-success'
            );
        }else{
            $return = array(
                'message'       => 'We can not process your request at the moment, please try again later!' , 
                'classesAdded'  => 'alert alert-danger'
            );
        }

        
        echo json_encode($return);

        wp_die();



    }

    public function SearchWord(){
        
        if(! DOING_AJAX )
            return false;

        if(!check_ajax_referer( 'search_autobody', 'nonce' ))
            return false;        

        $array = array();

        $word = sanitize_text_field($_POST['term']);

        $words = $this->wpdb->get_results('SELECT * FROM '. $this->base_table_name .' WHERE `name` LIKE "' . $word .'%"'  );


        foreach($words as $one){
            $array[]=$one->name ;
        }

        echo json_encode($array);

        wp_die();
    }


    public function enqueue_scripts(){
        wp_enqueue_script('AutobodyJs' , $this->plugin_url . 'assets/js/frontend.js' , __FILE__ );

        wp_localize_script('AutobodyJs', 'Autobody', array(
            'nonce' => wp_create_nonce ( 'check_nonce' ) ,
            'url'   => admin_url( 'admin-ajax.php' ),
        ));
    }

}