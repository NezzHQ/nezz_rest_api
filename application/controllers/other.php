<?php

if( ! defined('BASEPATH')) exit('No direct script access allowed');

class other extends CI_Controller {

    public function TermsandConditions() {

        $response = array();


        $this->load->model("other_model","o_m");


        $data = $this->o_m->TOS();

        if(count($data) > 0)
        {
            $response["status"] = 1;

            $response["TOS"] = $data["content"];
        }
        else {
            $response["status"] = 0;
        }


        echo json_encode($response);

    }


    public function PrivacyPolicy() {

        $response = array();


        $this->load->model("other_model","o_m");


        $data = $this->o_m->POS();

        if(count($data) > 0)
        {
            $response["status"] = 1;

            $response["POS"] = $data["content"];
        }
        else {
            $response["status"] = 0;
        }


        echo json_encode($response);

    }


    public function GetStates()
    {
        $this->load->model('other_model','o_m');

        $response = $this->o_m->States();

        echo json_encode($response);
    }


    public function GetCitiesByState()
    {
        if(isset($_GET["state_id"])) {

            $state_id = $_GET["state_id"];

            if($state_id != '') {

                $this->load->model('other_model', 'o_m');

                $response = $this->o_m->City($state_id);

                echo json_encode($response);
            }
        }
    }



}