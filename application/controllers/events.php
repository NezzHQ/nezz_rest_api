<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class events extends CI_Controller {

    //
    public function GetAllEvents()
    {
        $this->load->model("events_model","e_m");

        $event = $this->e_m->getAllEvents();

        echo json_encode($event);
    }

    // get all the events for a particular planner
    public function GetEventsPlanner()
    {
        $response = array();

        $this->load->model("events_model","e_m");

        if(count($_POST) > 0)
        {
            if($this->input->post('UserId') != null)
            {
                $user_id = $this->input->post("UserId");

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
        }



        echo json_encode($response);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */