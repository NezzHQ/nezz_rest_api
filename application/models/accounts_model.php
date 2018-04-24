<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class accounts_model extends CI_Model
{

    // this will give away the list of all the talents
    function getAllTalents()
    {
        $data = array();

        // getting all the initial talents
        $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,user_account.bio,user_account.cityStateId,us_cities.city,user_account.profilePicTalent,user_account.rate,user_account.ratingTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id WHERE userType='T' AND user_account.profilePicTalent IS NOT NULL ORDER BY user_account.userId DESC")->result_array();

        // skills
        $skill_query = $this->db->query("SELECT skills.Id,skills.Name FROM skills")->result_array();

        $skills = array();

        // parsing skills
        for ($i = 0; $i < count($skill_query); $i++) {
            $s = $skill_query[$i];
            $skills[$s["Id"]] = $s["Name"];
        }


        if (count($talent_query) > 0) {


            for ($x = 0; $x < count($talent_query); $x++) {
                $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query[$x]["userId"] . "'")->result_array();

                $talent_genre = $this->db->query("SELECT genre.Name,genre.Id FROM genre WHERE genre.Id IN (SELECT talent_genres.genre_id FROM talent_genres WHERE user_id = '" . $talent_query[$x]["userId"] . "')")->result_array();

                if (count($talent_skill_query) > 0) {
                    for ($y = 0; $y < count($talent_skill_query); $y++) {

                        $t_s_k = $talent_skill_query[$y];

                        $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];

                        $talent_skill_query[$y] = $t_s_k;

                    }

                    $talent_query[$x]["skills"] = $talent_skill_query;
                } else {
                    $talent_query[$x]["skills"] = array();
                }

                if (count($talent_genre) > 0) {
                    $talent_query[$x]["genre"] = $talent_genre;
                } else {
                    $talent_query[$x]["genre"] = array();
                }

            }

            $data = $talent_query;

        }

        return $data;
    }


    // list of regular talents
    function getRegularTalents()
    {
        $data = array();

        // getting all the initial talents
        $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,user_account.bio,user_account.cityStateId,us_cities.city,user_account.profilePicTalent,user_account.rate,user_account.ratingTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id WHERE (user_account.userType='T' AND user_account.featured='0')  ORDER BY user_account.userId DESC")->result_array();

        // skills
        $skill_query = $this->db->query("SELECT skills.Id,skills.Name FROM skills")->result_array();

        $skills = array();

        // parsing skills
        for ($i = 0; $i < count($skill_query); $i++) {
            $s = $skill_query[$i];
            $skills[$s["Id"]] = $s["Name"];
        }


        if (count($talent_query) > 0) {


            for ($x = 0; $x < count($talent_query); $x++) {
                $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query[$x]["userId"] . "'")->result_array();

                $talent_genre = $this->db->query("SELECT genre.Name,genre.Id FROM genre WHERE genre.Id IN (SELECT talent_genres.genre_id FROM talent_genres WHERE user_id = '" . $talent_query[$x]["userId"] . "')")->result_array();

                if (count($talent_skill_query) > 0) {
                    for ($y = 0; $y < count($talent_skill_query); $y++) {

                        $t_s_k = $talent_skill_query[$y];

                        $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];

                        $talent_skill_query[$y] = $t_s_k;

                    }

                    $talent_query[$x]["skills"] = $talent_skill_query;
                } else {
                    $talent_query[$x]["skills"] = array();
                }

                if (count($talent_genre) > 0) {
                    $talent_query[$x]["genre"] = $talent_genre;
                } else {
                    $talent_query[$x]["genre"] = array();
                }

            }

            $data = $talent_query;

        }

        return $data;
    }


    // get featured talent list
    function getFeaturedTalents()
    {
        $data = array();

        // getting all the initial talents
        $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,user_account.bio,user_account.cityStateId,us_cities.city,user_account.profilePicTalent,user_account.rate,user_account.ratingTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id WHERE (user_account.userType='T' AND user_account.featured='1')  ORDER BY user_account.userId DESC")->result_array();

        // skills
        $skill_query = $this->db->query("SELECT skills.Id,skills.Name FROM skills")->result_array();

        $skills = array();

        // parsing skills
        for ($i = 0; $i < count($skill_query); $i++) {
            $s = $skill_query[$i];
            $skills[$s["Id"]] = $s["Name"];
        }


        if (count($talent_query) > 0) {


            for ($x = 0; $x < count($talent_query); $x++) {
                $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query[$x]["userId"] . "'")->result_array();

                $talent_genre = $this->db->query("SELECT genre.Name,genre.Id FROM genre WHERE genre.Id IN (SELECT talent_genres.genre_id FROM talent_genres WHERE user_id = '" . $talent_query[$x]["userId"] . "')")->result_array();

                if (count($talent_skill_query) > 0) {
                    for ($y = 0; $y < count($talent_skill_query); $y++) {

                        $t_s_k = $talent_skill_query[$y];

                        $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];

                        $talent_skill_query[$y] = $t_s_k;

                    }

                    $talent_query[$x]["skills"] = $talent_skill_query;
                } else {
                    $talent_query[$x]["skills"] = array();
                }

                if (count($talent_genre) > 0) {
                    $talent_query[$x]["genre"] = $talent_genre;
                } else {
                    $talent_query[$x]["genre"] = array();
                }

            }

            $data = $talent_query;

        }

        return $data;
    }


    // get all files for the particular user
    function getUserFiles($user_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_files.id AS FileId,user_files.user_id,user_files.name AS Name,user_files.file_path as Path,user_files.thumbnail_path,user_files.file_type AS FileType FROM user_files WHERE user_files.user_id = " . $user_id);


        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }


    // get talent profile by user id
    function getTalentProfile($user_id, $flag = 1)
    {
        $data = array();

        // if flag is 2 then request is for particular info
        if ($flag == 2) {
            // getting particular info about a particular talent
            $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,us_cities.city,user_account.profilePicTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id WHERE user_account.userId = '" . $user_id . "' ORDER BY user_account.userId DESC")->row_array();
        } else {
            // getting all info about a particular talent
            $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,user_account.bio,user_account.cityStateId,us_cities.city,user_account.profilePicTalent,user_account.rate,user_account.ratingTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id WHERE user_account.userId = '" . $user_id . "' ORDER BY user_account.userId DESC")->row_array();
        }


        // skills
        $skill_query = $this->db->query("SELECT skills.Id,skills.Name FROM skills")->result_array();

        $skills = array();

        // parsing skills
        for ($i = 0; $i < count($skill_query); $i++) {
            $s = $skill_query[$i];
            $skills[$s["Id"]] = $s["Name"];
        }


        if (count($talent_query) > 0) {
            if ($flag != 2) {

                for ($x = 0; $x < count($talent_query); $x++) {
                    $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query["userId"] . "'")->result_array();

                    $talent_genre = $this->db->query("SELECT genre.Name,genre.Id FROM genre WHERE genre.Id IN (SELECT talent_genres.genre_id FROM talent_genres WHERE user_id = '" . $talent_query["userId"] . "')")->result_array();

                    if (count($talent_skill_query) > 0) {
                        for ($y = 0; $y < count($talent_skill_query); $y++) {

                            $t_s_k = $talent_skill_query[$y];

                            $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];

                            $talent_skill_query[$y] = $t_s_k;

                        }

                        $talent_query["skills"] = $talent_skill_query;
                    } else {
                        $talent_query["skills"] = array();
                    }

                    if (count($talent_genre) > 0) {
                        $talent_query["genre"] = $talent_genre;
                    } else {
                        $talent_query["genre"] = array();
                    }

                }

            } else {
                for ($x = 0; $x < count($talent_query); $x++) {
                    $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query["userId"] . "'")->result_array();

                    if (count($talent_skill_query) > 0) {
                        for ($y = 0; $y < count($talent_skill_query); $y++) {

                            $t_s_k = $talent_skill_query[$y];

                            $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];

                            $talent_skill_query[$y] = $t_s_k;

                        }

                        $talent_query["skills"] = $talent_skill_query;
                    } else {
                        $talent_query["skills"] = array();
                    }
                }
            }

            $data = $talent_query;

        }

        return $data;
    }


    // *Gets personal profile details for the current user.
    function getPersonalDetails($user_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_account.userId,user_account.bussiness_name AS businessName,user_account.firstName,user_account.lastName,user_account.birthday,user_account.gender,user_account.email,user_account.mobileNumber,user_account.location,user_account.profilePic FROM user_account WHERE user_account.userId = '" . $user_id . "' OR user_account.email = '$user_id'");

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }


    // Searching talent
    function getTalentByKey($filter)
    {
        $data = array();
        $talent_query = array();

        $skills = array();


        // search with string
        if (isset($filter["search_with"])) {
            $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,us_cities.city,user_account.profilePicTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id
WHERE CONCAT(user_account.talentName, us_cities.city, us_cities.state_name) LIKE '%" . $filter["search_with"] . "%'")->result_array();
        } else {

            if (isset($filter['skill_search']) and isset($filter['genre_search'])) {

                $skills = join("','", $filter['skill_search']);
                $genre = join("','", $filter['genre_search']);

                $talent_query = $this->db->query("SELECT user_account.userId,us_cities.state_name,us_cities.city,user_account.profilePicTalent,user_account.talentName FROM user_account JOIN us_cities ON user_account.cityStateId = us_cities.us_cities_id
WHERE ( user_account.userId IN (SELECT talent_skills.user_id FROM talent_skills WHERE talent_skills.skill_id IN ('$skills')) ) AND ( user_account.userId IN (SELECT talent_genres.user_id FROM talent_genres WHERE talent_genres.genre_id IN ('$genre'))  ) ORDER BY user_account.userId DESC")->result_array();

            }

        }


        if (count($talent_query) > 0) {
            for ($x = 0; $x < count($talent_query); $x++) {
                $talent_skill_query = $this->db->query("SELECT talent_skills.skill_id FROM talent_skills WHERE talent_skills.user_id = '" . $talent_query[$x]["userId"] . "'")->result_array();

                $talent_genre = $this->db->query("SELECT genre.Name,genre.Id FROM genre WHERE genre.Id IN (SELECT talent_genres.genre_id FROM talent_genres WHERE user_id = '" . $talent_query[$x]["userId"] . "')")->result_array();

                if (count($talent_skill_query) > 0) {
                    for ($y = 0; $y < count($talent_skill_query); $y++) {

                        $t_s_k = $talent_skill_query[$y];

                        if (isset($skills[$t_s_k["skill_id"]])) {
                            $t_s_k["skill_name"] = $skills[$t_s_k["skill_id"]];
                        }


                        $talent_skill_query[$y] = $t_s_k;

                    }

                    $talent_query[$x]["skills"] = $talent_skill_query;
                } else {
                    $talent_query[$x]["skills"] = array();
                }

                if (count($talent_genre) > 0) {
                    $talent_query[$x]["genre"] = $talent_genre;
                } else {
                    $talent_query[$x]["genre"] = array();
                }

            }

            $data = $talent_query;
        }


        return $data;
    }


    function setProfilePicture($userId)
    {
        $response = array();

        $this->load->model('other_model', 'o_m');

        $data = $this->o_m->file("user_files");

        $new_path = base_url()."user_files/" . $data["file_name"];

        $user_exist = $this->db->query("SELECT user_account.userId FROM user_account WHERE user_account.userId = '$userId'")->row_array();

        if (count($user_exist) == 1) {
            $this->db->set('profilePic', $new_path)->where('userId', $userId)->update('user_account');
            $result = $this->db->affected_rows();

            $response["status"] = True;
            $response["message"] = "Successfully Updated";
        } else {
            $response["status"] = False;
            $response["message"] = "Invalid User Id";
        }

        return $response;
    }

    function loginviaFacebook($user_id)
    {
        $userId = $this->db->query("SELECT user_devices.user_id FROM user_devices WHERE user_devices.user_id='$user_id'")->row_array();
        $response = array();

        if (count($userId) > 0) {
            $userId = $userId["user_id"];
            $response = $this->getPersonalDetails($userId);
        } else {
            //  have to work on this
        }

        return $response;
    }

    function logintoFacebookviaUserId($user_id)
    {
        $userId = $this->db->query("SELECT user_devices.user_id FROM user_devices WHERE user_devices.user_id='$user_id'")->row_array();
        $response = array();

        if (count($userId) > 0) {
            $userId = $userId["user_id"];
            $response = $this->getPersonalDetails($userId);
        } else {
            //  have to work on this
        }

        return $response;
    }


    // notification
    function editNotification($user_id,$enable,$device_token)
    {
        $response = array();
        $status_dic = $this->db->query("SELECT user_account.allow_notif FROM user_account WHERE user_account.userId = '$user_id' ")->row_array();

        if(count($status_dic) > 0)
        {
            $status = $enable;

            $this->db->query("UPDATE user_account SET allow_notif = $status WHERE user_account.userId = '$user_id'");

            $flag = $status == '0'? False : True;


            $response["status"] = 1;
            $response["enabled"] = $flag;
            $response["message"] = "Information successfully updated";

        }
        else {
            $response["status"] = 0;
            $response["message"] = "Invalid User Id";
        }

        return $response;
    }


    // email
    function editEmailnotification($user_id,$enable)
    {
        $response = array();
        $status_dic = $this->db->query("SELECT user_account.allow_email FROM user_account WHERE user_account.userId = '$user_id' ")->row_array();

        if(count($status_dic) > 0)
        {
            $status = $enable;



            $flag = $status == '0'? False : True;

            $this->db->query("UPDATE user_account SET allow_email = $status WHERE user_account.userId = '$user_id'");

            $response["enabled"] = $flag;
            $response["status"] = 1;
            $response["message"] = "Information successfully updated";

        }
        else {
            $response["status"] = 0;
            $response["message"] = "Invalid User Id";
        }

        return $response;
    }


    // login with email
    function loginEmail($email,$password)
    {
        $userId = $this->db->query("SELECT userid FROM user_login WHERE userid='$email' AND Password = '$password'")->row_array();
        $response = array();

        if (count($userId) > 0) {
            $userId = $userId["userid"];
            $response = $this->getPersonalDetails($userId);
        }

        return $response;
    }


    // sign up
    function signUpEmail($data)
    {
        $response = array();

        $login = array("userid"=>$data["email"],"Password"=>$data["password"]);

        if(isset($data["userId"]))
        {
            $user_account = array("userId"=>$data["userId"],"email"=>$data["email"],"firstName"=>$data["first_name"],"lastName"=>$data["last_name"]);
        }
        else {
            $user_account = array("userId"=>$data["email"],"email"=>$data["email"],"firstName"=>$data["first_name"],"lastName"=>$data["last_name"]);
        }




        //$query = $this->db->get_where("user_login",array("userid"=>$login["userid"]));

        $query1 = $this->db->query("SELECT userid FROM user_login WHERE userid = '".$data["email"]."'");
        $query2 = $this->db->query("SELECT userId FROM user_account WHERE userId = '".$data["email"]."'");


        if(($query1->num_rows() == 0) or (isset($data["DeviceToken"]))) {
            if($query2->num_rows() == 0 or isset($data["DeviceToken"])) {

                if(isset($data["DeviceToken"]))
                {

                    $using_facebook = array("user_id"=>$user_account['userId'],"device_id" => $data["DeviceToken"]);
                    $login = array("userid" => $user_account['userId'],"Password" => $user_account["email"]);

                    if($this->db->insert("user_account", $user_account) and $this->db->insert("user_login", $login) and $this->db->insert("user_devices",$using_facebook))
                    {
                        $response["status"] = 1;
                    }
                }
                else  {
                    if ($this->db->insert("user_account", $user_account) and $this->db->insert("user_login", $login)) {
                        $response["status"] = 1;
                        $this->load->model("other_model", "o");

                        $code = $this->o->random_code();

                        $this->o->confirmation_email($login["userid"], $code);

                        $response["confirmation_code"] = $code;
                        $response["message"] = "Successfully Signed up";
                    } else {
                        $response["status"] = 0;
                        $response["message"] = "server error";
                    }
                }



                // welcome email
                $this->load->model('other_model','o_m');


                $welcome_message = $this->o_m->gettingWelcomeEmail();

                $pattern="/{{name}}/"; // replacing template with name

                $welcome_message = preg_replace($pattern,$user_account['firstName'],$welcome_message);


                $this->o_m->SedingWelcomemail($user_account['firstName'],$user_account['email'],$welcome_message);


            }
            else {
                $response["status"] = 0;
                $response["message"] = "Email Already Registered";
            }
        }
        else {
            $response["status"] = 0;
            $response["message"] = "Email Already Registered";
        }

        return $response;
    }



    // forgot password
    public function forgotPassword($email)
    {
        $response = array();

        $query = $this->db->query("SELECT userid FROM user_login WHERE userid = '".$email."'");

        if($query->num_rows() > 0)
        {
            $this->load->model("other_model","o_m");

            $response["status"] = 1;
            $response["code"] = $this->o_m->random_code();

            $this->o_m->Reset_password_email($email,$response["code"]);
        }
        else {
            $response["status"] = 0;
            $response["message"] = "Email haven't found";
        }

        return $response;
    }


    // reset password
    public function updatePassword($data)
    {
        $response = array();

        $query = $this->db->query("SELECT userid FROM user_login WHERE userid = '".$data["userid"]."'");

        if($query->num_rows() > 0)
        {
            $this->db->query("UPDATE user_login SET Password = '".$data["password"]."' WHERE userid = '".$data["userid"]."'");

            if($this->db->affected_rows() > 0)
            {
                $response["status"] = 1;
                $response["message"] = "Password Successfully Updated";

                $this->load->model("other_model","o_m");
                $this->o_m->Reset_password_confirmation($data["userid"]);
            }
            else {
                $response["status"] = 0;
                $response["message"] = "You Used the Old password";
            }
        }
        else {
            $response["status"] = 0;
            $response["message"] = "Invalid Email";
        }


        return $response;
    }



    // add device token for push notification
    public function addDeviceToken($data)
    {
        $response = array();

        if($this->db->insert('naaz_push_notification',$data))
        {
            $response["status"] = True;
            $response["message"] = "Successfully Added";
        }
        else {
            $response["status"] = False;
            $response["message"] = "Error occured";
        }

        return $response;
    }



    // update profile
    public function updateUserProfile($user_data)
    {
        $response = array();

        $this->load->model('accounts_model','a_m');

        $user_exist = $this->a_m->getPersonalDetails($user_data["userId"]);

        if(count($user_exist) > 0)
        {
            if($this->db->update('user_account',$user_data,array("userId" => $user_data["userId"])))
            {
                $response["status"] = 1;
                $response["message"] = "Successfully Updated";
            }
            else {
                $response["status"] = 0;
                $response["message"] = "Error occured";
            }


        }
        else {
            $response["status"] = 0;
            $response["message"] = "Invalid User id";
        }


        return $response;
    }





    //   help mail
    public function help_mail_sender($packet)
    {
        $response = array();
        $this->load->model('other_model','o_m');


        $response["status"] = $this->o_m->Help_mail($packet);

        if($response["status"])
        {
            $response["status"] = 1;
            $response["message"] = "Successfully Send";
        }
        else {
            $response["status"] = 0;
            $response["message"] = "error occured";
        }

        return $response;
    }


    // device token exist for push notification
    public function DeviceTokenCheck($token)
    {
        $flag = false;

        if($this->db->query("SELECT n_p_id FROM naaz_push_notification WHERE device_token = '$token'")->num_rows() > 0)
        {
            $flag = true;
        }

        return $flag;
    }

    // adding and enabling device token
    public function AddingPushNotification($packet,$flag)
    {
        $response = array();


        $this->load->model("accounts_model","a_m");

        if($this->a_m->DeviceTokenCheck($packet['device_token']))
        {
            $flag = "old";
        }
        else {
            $flag = "new";
        }

        switch ($flag) {
            case "new":
                if ($this->db->insert("naaz_push_notification", $packet)) {
                    $response["status"] = 1;
                    $response["message"] = "Successfully Added";
                    $response["enable"] = $packet["enable"];
                } else {
                    $response["status"] = 0;
                    $response["message"] = "Error Occured";
                }
                break;

            case "old":
                if ($this->db->update("naaz_push_notification", $packet,array("device_token"=>$packet["device_token"]))) {
                    $response["status"] = 1;
                    $response["message"] = "Successfully Updated";
                    $response["enable"] = $packet["enable"];
                } else {
                    $response["status"] = 0;
                    $response["message"] = "Error Occured";
                }
                break;

        }





        return $response;
    }







}