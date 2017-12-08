<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class events_model extends CI_Model
{
    // prefred genres according to event table
    function Prefered_Genre($event_id)
    {
        $data = array();

        $query = $this->db->get_where("event_preferred_genre",array("event_id"=>$event_id));

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    // prefred genres according to event table
    function Prefered_Skills($event_id)
    {
        $data = array();

        $query = $this->db->get_where("event_preferred_skills",array("event_id"=>$event_id));

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    // planner acording to event table
    function PlannerfromEvent($event_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_account.firstName,user_account.lastName,user_account.profilePic,user_account.rating FROM user_account WHERE user_account.userId = (SELECT event_planner.user_id FROM event_planner WHERE event_planner.event_id = ".$event_id.")");

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();
        }

        return $data;
    }

    // event type
    function eventType($type_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event_types.id,event_types.type_name FROM event_types WHERE event_types.id=".$type_id);

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();
        }

        $data['Events'] = null;

        return $data;
    }

    // getting info according to the event table
    function getAllEvents()
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event ORDER BY event.Id DESC");


        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data) ; $x++)
            {
                $event = $data[$x];

                //$event["PreferredGenres"] = $this->Prefered_Genre($event['Id']);
                //$event["PreferredSkills"] = $this->Prefered_Skills($event['Id']);
                $event["Planners"] = $this->PlannerfromEvent($event['Id']);

                $event["Type"] = $this->eventType($event['type_id']);

                $event["distance"] = 0;

                $data[$x] = $event;
            }

        }

        return $data;

    }



    // getting event invite list
    function getEventInviteList($planner_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id AS event_id,event_invites.user_id AS talent_id,event.Name,event.dateCreated FROM event_invites JOIN event ON event_invites.event_id = event.Id WHERE event_invites.event_id IN (SELECT event_planner.event_id FROM event_planner WHERE event_planner.user_id = '".$planner_id."') ORDER BY event_invites.id DESC");

        $this->load->model("accounts_model","a_m");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data) ; $x++)
            {
                $event = $data[$x];

                $event["TalentTypeNeeded"] = $this->Prefered_Skills($event["event_id"]);

                $event["Talent"] = $this->a_m->getTalentProfile($event["talent_id"],2);

                $data[$x] = $event;
            }

        }

        return $data;

    }




    // getting events for particular planner
    function getAllEventsByPlanner($planner_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE event.Id IN (SELECT event_planner.event_id FROM event_planner WHERE event_planner.user_id = ".$planner_id.") ORDER BY event.Id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data) ; $x++)
            {
                $event = $data[$x];

                $event["PreferredGenres"] = $this->Prefered_Genre($event['Id']);
                $event["PreferredSkills"] = $this->Prefered_Skills($event['Id']);

                $event["Type"] = $this->eventType($event['type_id']);

                $event["distance"] = 0;

                $data[$x] = $event;
            }

        }

        return $data;

    }





    // getting events by event id
    function getEventsByEvent($event_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id,event.description,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE event.Id IN (SELECT event_planner.event_id FROM event_planner WHERE event_planner.event_id = ".$event_id.")");

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();

            $data["PreferredGenres"] = $this->Prefered_Genre($data['Id']);
            $data["PreferredSkills"] = $this->Prefered_Skills($data['Id']);

            $data["Type"] = $this->eventType($data['type_id']);

            $data["distance"] = 0;
        }

        return $data;
    }


    // getting event invite pending for the talent
    function getPendingInviteFORtalent($talent_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id as event_id,event.Name,event.dateCreated,event.description,event.location,event.picture,event.title,event.longitude,event.latitude FROM event WHERE event.Id IN (SELECT event_invites.event_id FROM event_invites WHERE event_invites.user_id =  '".$talent_id."' AND event_invites.status_id = 0)");


        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data); $x++)
            {
                $data[$x]["planner"] = $this->PlannerfromEvent($data[$x]["event_id"]);
            }
        }

        return $data;
    }


    // getting successfully booked event list
    function getBookedeventFORtalent($talent_id)
    {
        $data = array();

        $query = $this->db->query("SELECT event.Id as event_id,event.Name,event.dateCreated,event.description,event.location,event.picture,event.title,event.longitude,event.latitude FROM event WHERE event.Id IN (SELECT event_invites.event_id FROM event_invites WHERE event_invites.user_id =  '".$talent_id."' AND event_invites.status_id = 1)");


        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data); $x++)
            {
                $data[$x]["planner"] = $this->PlannerfromEvent($data[$x]["event_id"]);
            }
        }

        return $data;
    }


    // searching event for talent
    function SearchEventsForTalent($filter)
    {
        $data = array();

        if(isset($filter["search_with"]))
        {
            if($filter["search_with"] != '')
            {
                $query = $this->db->query("SELECT event.Id as event_id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE CONCAT(event.location,event.Name,event.dateCreated,event.title) LIKE '%".$filter["search_with"]."%' ORDER BY event.Id DESC");
            }
        }
        else {
            if(isset($filter["prefred_genres"]) and isset($filter["prefred_skills"]))
            {
                $genres = join("','",$filter["prefred_genres"]);
                $skills = join("','",$filter["prefred_skills"]);

                if(isset($filter["city"]) and isset($filter["state"]))
                {
                    $city = $filter["city"];
                    $state = $filter["state"];

                    $query = $this->db->query("SELECT event.Id as event_id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE event.Id IN (SELECT event_preferred_skills.event_id FROM event_preferred_skills WHERE event_preferred_skills.skill_id IN('$skills')) AND event.Id IN (SELECT event_preferred_genre.event_id FROM event_preferred_genre WHERE event_preferred_genre.genre_id IN ('$genres')) AND ((event.location LIKE '%$city%') OR (event.location LIKE '%$state%')) ORDER BY event.Id DESC");
                }

                //echo "SELECT event.Id as event_id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE event.Id IN (SELECT event_preferred_skills.event_id FROM event_preferred_skills WHERE event_preferred_skills.skill_id IN('$skills')) AND event.Id IN (SELECT event_preferred_genre.event_id FROM event_preferred_genre WHERE event_preferred_genre.genre_id IN ('$genres')) ORDER BY event.Id DESC";

                $query = $this->db->query("SELECT event.Id as event_id,event.type_id,event.Name,event.dateCreated,event.dateEnd,event.dateStarted,event.description,event.location,event.longitude,event.latitude,event.picture,event.title FROM event WHERE event.Id IN (SELECT event_preferred_skills.event_id FROM event_preferred_skills WHERE event_preferred_skills.skill_id IN('$skills')) AND event.Id IN (SELECT event_preferred_genre.event_id FROM event_preferred_genre WHERE event_preferred_genre.genre_id IN ('$genres')) ORDER BY event.Id DESC");
            }
        }

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();

            for($x = 0; $x < count($data); $x++)
            {
                $data[$x]["planner"] = $this->PlannerfromEvent($data[$x]["event_id"]);
            }
        }


        return $data;
    }

}