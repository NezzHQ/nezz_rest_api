<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class planner extends CI_Controller {

    // get list of talents
    /*public function GetTalents()
    {
        $this->load->model("accounts_model","a_c");

        // getting all the talents
        $data = $this->a_c->getAllTalents();


        $status = 0;

        if(count($data) > 0)
        {
            $status = 1;
        }

        $response = array("status" => $status,"data" => $data,"numofrecords" => count($data));

        echo json_encode($response);
    }*/


    public function GetTalents()
    {
        $this->load->model("accounts_model","a_c");

        // getting regular talents
        $regular_talents = $this->a_c->getRegularTalents();

        // getting featured talents
        $featured_talents = $this->a_c->getFeaturedTalents();


        $status = 0;

        if(count($regular_talents) > 0)
        {
            $status = 1;
        }

        $response = array("status" => $status,"general_talents" => $regular_talents,"featured_talents" => $featured_talents);

        echo json_encode($response);
    }



    // get talent media
    public function GetTalentMedia()
    {
        $this->load->model("planner_model","p_m");

        // request with Content-type : x-www-form-urlencoded

        if(isset($_POST["UserId"]))
        {
            $response = array();

            $user_id = $_POST["UserId"]; // it will carry user id


            $data = $this->p_m->TalentMedia($user_id);


            if(count($data) > 0)
            {
                $response["status"] = 1;
                $response["media"] = $data;
            }


            echo json_encode($response);
        }


    }


    // get all the events for a particular planner
    public function GetPlannerLineUps()
    {
        $response = array();

        $this->load->model("events_model","e_m");

        if(isset($_POST["UserId"]))
        {
            $user_id = $_POST["UserId"];

            $events = $this->e_m->getAllEventsByPlanner($user_id);

            if(count($events) > 0)
            {
                $response["status"] = 1;
            }
            else {
                $response["status"] = 0;
            }

            $response["events"] = $events;
        }

        echo json_encode($response);
    }


    // get info for a particular talent
    public function GetTalentProfile()
    {
        $response = array();

        $this->load->model("accounts_model","a_m");

        if(isset($_POST["UserId"]))
        {
            $user_id = $_POST["UserId"];

            $talent = $this->a_m->getTalentProfile($user_id);


            if(count($talent) > 0)
            {
                $response["status"] = 1;
            }
            else {
                $response["status"] = 0;
            }

            $response["talent"] = $talent;
        }

        echo json_encode($response);
    }



    // Gets event details for one single event
    public function GetEventDetails()
    {
        $response = array();

        $this->load->model("events_model","e_m");

        if(isset($_POST["EventId"]))
        {
            $event_id = $_POST["EventId"];

            $event = $this->e_m->getEventsByEvent($event_id);


            if(count($event) > 0)
            {
                $response["status"] = 1;
            }
            else {
                $response["status"] = 0;
            }

            $response["event_description"] = $event;
        }

        echo json_encode($response);
    }


    // Gets the current requests and invites for the Planner
    public function GetPlannerRequests()
    {
        $response = array();

        if(isset($_POST["UserId"]))
        {
            $planner_id = $_POST["UserId"];

            $this->load->model("events_model","e_m");

            $data = $this->e_m->getEventInviteList($planner_id);

            if(count($data) > 0)
            {
                $response["status"] = 1;

                $response["event_invite_list"] = $data;
            }
            else {
                $response["status"] = 0;
            }

        }

        echo json_encode($response);
    }


    // search talent with keys
    public function SearchTalents()
    {
        $response = array();

        // $req_dump = print_r($_POST, TRUE);
        //    $fp = fopen('request.log', 'a');
        //  fwrite($fp, $req_dump);
        //    fclose($fp);

        //  die();

        if(count($_POST) > 0)
        {
            $this->load->model("accounts_model","a_m");

            $filter = array();

            if(isset($_POST["searchString"]))
            {
                if(htmlentities($_POST["searchString"]) != '')
                {
                    $filter["search_with"] = $_POST["searchString"];
                }
            }
            else
            {
                if(isset($_GET['SkillList']))
                {
                    $filter["skill_search"] = $_GET['SkillList'];
                }
                else {
                    $filter["skill_search"] = array();
                }

                if(isset($_GET['GenreList']))
                {
                    $filter["genre_search"] = $_GET['GenreList'];
                }
                else {
                    $filter["genre_search"] = array();
                }

            }

            // $filter["genre_search"] = array(1,3);
            //$filter["skill_search"] = array(1,3);

            $talent_list = $this->a_m->getTalentByKey($filter);


            if(count($talent_list) > 0)
            {
                $response["status"] = 1;

                $response["talents"] = $talent_list;
            }
            else {
                $response["status"] = 0;
            }
        }


        echo json_encode($response);
    }


    public function GetAllArticles() {
        $response = array();

        $this->load->model("planner_model","p_m");

        $data = $this->p_m->getAllarticles();


        if(count($data) > 0)
        {
            $response["status"] = 1;
            $response["articles"] = $data;
        }
        else {
            $response["status"] = 0;
        }

        echo json_encode($response);


    }

    public function GetAllVideoArticles() {
        $response = array();

        $this->load->model("planner_model","p_m");

        $data = $this->p_m->getAllVideoarticles();


        if(count($data) > 0)
        {
            $response["status"] = 1;
            $response["video_articles"] = $data;
        }
        else {
            $response["status"] = 0;
        }

        echo json_encode($response);


    }

}