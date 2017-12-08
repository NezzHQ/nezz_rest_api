<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class talent extends CI_Controller {

    public function GetGigs()
    {
        $this->load->model('events_model','e_m');

        $response = array();


        $events = $this->e_m->getAllEvents();

        if(count($events) > 0)
        {
            $response["status"] = 1;
            $response["event_list"] = $events;
        }
        else {
            $response["status"] = 0;
        }


        echo json_encode($response);
    }

    // planner invite event list
    public function GetTalentInvites()
    {
        $this->load->model("events_model","e_m");

        $response = array();

        if(isset($_POST["UserId"]))
        {
            $talent_id = $_POST["UserId"];

            $this->load->model("events_model","e_m");

            $data = $this->e_m->getPendingInviteFORtalent($talent_id);

            if(count($data) > 0)
            {
                $response["status"] = 1;

                $response["event_invite_from_planner_list"] = $data;
            }
            else {
                $response["status"] = 0;
            }

        }

        echo json_encode($response);
    }

    // successfully booked event list
    public function GetTalentBookings()
    {
        $this->load->model("events_model","e_m");

        $response = array();

        if(isset($_POST["UserId"]))
        {
            $talent_id = $_POST["UserId"];

            $this->load->model("events_model","e_m");

            $data = $this->e_m->getBookedeventFORtalent($talent_id);

            if(count($data) > 0)
            {
                $response["status"] = 1;

                $response["event_booked_list"] = $data;
            }
            else {
                $response["status"] = 0;
            }

        }

        echo json_encode($response);
    }



    // search for event
    public function SearchGigs()
    {
        $this->load->model("events_model","e_m");

        $filter = array();
        $response = array();

        if (count($_POST) > 0) {
            if (isset($_POST["searchString"]) and ($_POST["searchString"] != '')) {
                $filter["search_with"] = $_POST["searchString"];
            } else {
                if(isset($_POST["genreList"]) and isset($_POST["skillList"]))
                {
                    $filter["prefred_genres"] = $_POST["genreList"];
                    $filter["prefred_skills"] = $_POST["skillList"];
                }

                if((isset($_POST["city"]) and ($_POST["city"] != '')) and isset($_POST["state"]) and ($_POST["state"] != ''))
                {
                    $filter["city"] = $_POST["city"];
                    $filter["state"] = $_POST["state"];
                }
            }

           // $filter["prefred_genres"] = array(3,4);
          //  $filter["prefred_skills"] = array(1,3);


            $data = $this->e_m->SearchEventsForTalent($filter);

            if (count($data) > 0) {
                $response["status"] = 1;
                $response["event_list"] = $data;
            } else {
                $response["status"] = 0;
            }

            echo json_encode($response);
        }
    }

}