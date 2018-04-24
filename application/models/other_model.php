<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class other_model extends CI_Model {

    // getting terms and conditions
    public function TOS() {

        $data = array();



        $query = $this->db->query("SELECT document_template.content FROM document_template WHERE document_template.docu_name = 'TERMS_CONTENT'");

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();
        }


        return $data;

    }


    // getting privacy policy
    public function POS()
    {
        $data = array();

        $query = $this->db->query("SELECT document_template.content FROM document_template WHERE document_template.docu_name = 'PRIVACY_CONTENT'");

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();
        }

        return $data;
    }


    // uploading multiple files
    public function file($dir)
    {
        $data = array();

        $config['upload_path'] = './'.$dir.'/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;


        $this->load->library('upload', $config);

        if($this->upload->do_upload())
        {
            $data = $this->upload->data();
        }
        else {
            $errors = $this->upload->display_errors ();
        }

        return $data;
    }



    // get States
    public function States()
    {
        $data = array();

        $query = $this->db->query("SELECT DISTINCT us_cities.state_name,us_cities.state_id FROM us_cities");

        if($query->num_rows() > 0)
        {
            $data["status"] = 1;
            $data["states"] = $query->result_array();
        }
        else {
            $data["status"] = 0;
        }

        return $data;
    }


    // get City by States
    public function City($state_id)
    {
        $data = array();

        $query = $this->db->query("SELECT us_cities.city,us_cities.us_cities_id FROM us_cities WHERE us_cities.state_id='$state_id'");

        if($query->num_rows() > 0)
        {
            $data["status"] = 1;
            $data["cities"] = $query->result_array();
        }
        else {
            $data["status"] = 0;
        }

        return $data;
    }


    public function random_code()
    {
        $digits = 4;
        $number = rand(pow(10, $digits-1), pow(10, $digits)-1);

        return $number;
    }

    public function confirmation_email($email,$code)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= "From: Nezz \r\n";

        $message = "Your confirmation code is:  ".$code;

        mail($email,"Confirmation From Nezz",$message,$headers);
    }

    public function Reset_password_email($email,$code)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= "From: Nezz \r\n";

        $message = "Your Reset code is:  ".$code;

        mail($email,"Reset code From Nezz",$message,$headers);
    }

    public function Reset_password_confirmation($email)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= "From: Nezz \r\n";

        $message = "Password Changed for Nezz";

        mail($email,"Your Nezz Password has been changed",$message,$headers);
    }


    public function Help_mail($packet)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: '.$packet["user_name"].'<'.$packet["user_email"].'>' . "\r\n";

        $message = "<table>
                    
                    <tr>
                        <td>Name:</td> <td>".$packet["user_name"]."</td>
                    </tr>
                    
                    <tr>
                        <td>UserId:</td> <td>".$packet["user_id"]."</td>
                    </tr>
                    
                    <tr>
                        <td>Email:</td> <td>".$packet["user_email"]."</td>
                    </tr>
                    
                    <tr>
                        <td>Message:</td> <td>".$packet["user_message"]."</td>
                    </tr>
                    
                    </table>";

        $status = mail("abdullah017196@gmail.com",$packet["user_subject"],$message,$headers);

        return $status;
    }

    public function gettingWelcomeEmail() {

        $query = $this->db->query("SELECT 	
content AS msg FROM document_template WHERE docu_name = 'EMAIL_WELCOME_MESSAGE'")->row_array();


        return $query['msg'];

    }

    public function SedingWelcomemail($firstname,$email,$message)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: Nezz Inc<info@nezz.io>' . "\r\n";



        $status = mail($email,"Welcome to Nezz",$message,$headers);

        return $status;
    }
}