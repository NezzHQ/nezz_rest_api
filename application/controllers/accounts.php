<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class accounts extends CI_Controller {

    public function GetAllTalents()
    {

        $this->load->model("accounts_model","a_c");

        // getting all the talents
        $data = $this->a_c->getAllTalents();

        $status = 0;

        if(count($data) > 0)
        {
            $status = 1;
        }

        echo json_encode(array("status" => $status,"data" => $data,"numofrecords" => count($data)));
    }



    // get user files
    public function GetUserFiles()
    {
        $this->load->model("accounts_model","a_c");

        $response = array();

        if(count($_POST) > 0)
        {
            if($this->input->post("UserId") != null)
            {
                $user_id = $this->input->post("UserId");

                $data = $this->a_c->getUserFiles($user_id);

                if(count($data) > 0)
                {
                    $response["status"] = 1;
                }
                else {
                    $response["status"] = 0;
                }

                $response["data"] = $data;
            }
        }

       echo json_encode($response);
    }


    // *Gets personal profile details for the current user.
    public function GetPersonalDetails()
    {
        $response = array();

        $this->load->model("accounts_model","a_m");

        if(isset($_POST['UserId']))
        {
            $user_id = $_POST["UserId"];

            $data = $this->a_m->getPersonalDetails($user_id);

            if(count($data) > 0)
            {
                $response["status"] = 1;

                $response["user_info"] = $data;
            }
            else {
                $response["status"] = 0;
            }
        }

        echo json_encode($response);
    }


    // set profile pic
    public function SetProfilePicture()
    {
        $response = array();

        if(isset($_POST['user_id']))
        {
            $user_id = $_POST['user_id'];

            if($user_id != '')
            {
                if(count($_FILES) > 0)
                {
                    $this->load->model("accounts_model","a_m");

                    $data = $this->a_m->setProfilePicture($user_id);

                    $response = $data;
                }
            }

        }



        echo json_encode($response);
    }


    // login with facebook
    public function LoginWithFacebook() {
        $response = array();

        if(isset($_GET["DeviceToken"]))
        {
            $device_token = $_GET["DeviceToken"];

            if($device_token != '')
            {
                $this->load->model("accounts_model","a_c");

                $data = $this->a_c->loginviaFacebook($device_token);

                if(count($data) > 0)
                {
                    $response["status"] = 1;
                    $response["user_data"] = $data;
                }
                else {

                    if(isset($_GET["Email"]) and isset($_GET["first_name"]) and isset($_GET['last_name']) and isset($_GET['id']))
                    {
                        if(($_GET["Email"] != '') and ($_GET["first_name"] != '') and ($_GET['last_name'] != '') and ($_GET['id'] != ''))
                        {
                            $res = $this->a_c->signUpEmail(array("DeviceToken"=>$device_token,"email"=>$_GET['Email'],"first_name"=>$_GET["first_name"],"last_name"=>$_GET["last_name"],"password"=>$_GET['id'],"userId"=>$_GET['id']));

                            if($res["status"] == 1)
                            {
                                $data = $this->a_c->loginviaFacebook($device_token);

                                $response["status"] = 1;
                                $response["user_data"] = $data;
                            }
                            else {
                                $response = $res;
                            }

                        }


                    }
                    else {
                        $response["status"] = 0;
                    }

                }

            }
        }

        echo json_encode($response);
    }


    // sign up using reqular form
    public function LoginWithEmail() {
        $response = array();

        if(isset($_POST["email"]) and isset($_POST["password"]))
        {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if(($email != '') and ($password != ''))
            {
                $this->load->model("accounts_model","a_c");

                $data = $this->a_c->loginEmail($email,$password);

                if(count($data) > 0)
                {
                    $response["status"] = 1;
                    $response["user_data"] = $data;
                }
                else {
                    $response["status"] = 0;
                }

            }
        }

        echo json_encode($response);
    }




    // regular notification
    public function enableNotification()
    {
        $response = array();


        if(isset($_POST['UserId']) and isset($_POST['enable']))
        {
            $userid = $_POST['UserId'];
            $enable = $_POST['enable'];

            if($userid != '')
            {
                $this->load->model("accounts_model","a_m");

                $response = $this->a_m->editNotification($userid,$enable);
            }

        }


        echo json_encode($response);
    }


    // regular notification
    public function enableEmailNotification()
    {
        $response = array();


        if(isset($_POST['UserId']) and isset($_POST['enable']))
        {
            $userid = $_POST['UserId'];
            $enable = $_POST['enable'];

            if($userid != '' and $enable != '')
            {
                $this->load->model("accounts_model","a_m");

                $response = $this->a_m->editEmailnotification($userid,$enable);
            }

        }


        echo json_encode($response);
    }


    // email signup
    public function SignUpWithEmail()
    {
        $response = array();

        if(isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["first_name"]) and isset($_POST["last_name"]))
        {
            if(($_POST['email'] != '') and ($_POST['password'] != '') and ($_POST['first_name'] != '') and ($_POST['last_name'] != ''))
            {
                $data = array("email" => $_POST["email"],"password" => $_POST["password"],"first_name" => $_POST["first_name"],"last_name" => $_POST["last_name"]);

                $this->load->model("accounts_model","a_m");

                $response = $this->a_m->signUpEmail($data);
            }
        }


        echo json_encode($response);
    }


    // forgot password
    public function ForgotPassword()
    {
        $response = array();

        if(isset($_POST['email']))
        {
            if($_POST["email"] != '')
            {
                $email  = $_POST["email"];

                $this->load->model('accounts_model','a_m');

                $response = $this->a_m->forgotPassword($email);
            }
        }

        echo json_encode($response);
    }


    // reset password
    public function ResetPassword()
    {
        $response = array();

        if(isset($_POST['email']) and isset($_POST['new_password']))
        {
            if(($_POST["email"] != '') and ($_POST["new_password"] != ''))
            {
                $email  = $_POST["email"];
                $password  = $_POST["new_password"];

                $this->load->model('accounts_model','a_m');

                $response = $this->a_m->updatePassword(array("userid"=>$email,"password"=>$password));
            }
        }

        echo json_encode($response);
    }

    // add toekn
    public function addDeviceToken()
    {
        $response = array();

        if(isset($_POST['device_id']) and isset($_POST['user_id']))
        {
            $device_token = $_POST['device_id'];
            $user_id = $_POST['user_id'];

            $this->load->model('accounts_model','a_m');

            if($device_token != '' and $user_id != '')
            {
                $response = $this->a_m->addDeviceToken(array("device_token"=>$device_token,"user_id"=>$user_id));
            }
        }

        echo json_encode($response);
    }


    // logout
    public function LogOut()
    {
        $response = array();

        if(isset($_POST['UserId']))
        {
            $user_id = $_POST['UserId'];

            if($user_id != '')
            {
                $this->load->model('accounts_model','a_m');

                $data = $this->a_m->getPersonalDetails($user_id);

                if(count($data) > 0)
                {
                    $response["status"] = 1;
                    $response["message"] = "Successfully Logged out";
                }
                else {
                    $response["status"] = 0;
                    $response["message"] = "Invalid User Id";
                }

            }
        }

        echo json_encode($response);
    }


    // update profile
    public function UpdateProfile()
    {
        $response = array();


        if(isset($_POST['userId']) and isset($_POST['businessName']) and isset($_POST['firstName']) and isset($_POST['lastName']) and isset($_POST['birthday']) and isset($_POST['gender']) and isset($_POST['email']) and isset($_POST['mobileNumber']) and isset($_POST['location']))
        {
            $data['userId'] = $_POST['userId'];
            $data['bussiness_name'] = $_POST['businessName'];
            $data['firstName'] = $_POST['firstName'];
            $data['lastName'] = $_POST['lastName'];
            $data['birthday'] = $_POST['birthday'];
            $data['gender'] = $_POST['gender'];
            $data['email'] = $_POST['email'];
            $data['mobileNumber'] = $_POST['mobileNumber'];
            $data['location'] = $_POST['location'];

            $this->load->model('accounts_model','a_m');

            $response = $this->a_m->updateUserProfile($data);

        }



        echo json_encode($response);
    }



    // send mail help
    public function MailHelp()
    {

        $response = array();


        if(count($_POST) > 0)
        {
            try {
                $data = array();

                foreach ($_POST as $key => $value)
                {
                    if($_POST[$key] != '')
                    {
                        $data[$key] = $value;
                    }
                    else {
                        throw new Exception("Need All The Arrtidutes");
                    }
                }

                $this->load->model('accounts_model','a_m');

                $response = $this->a_m->help_mail_sender($data);


            }
            catch(Exception $e)
            {
                $response["message"] = $e->getMessage();
                $response["staus"] = 0;
            }
        }



        echo json_encode($response);
    }








    // device push notification
    public function DevicePushNotification()
    {
        $this->load->model("accounts_model","a_m");

        $response = array();


        if(count($_POST) > 0)
        {

            if(isset($_POST['DeviceToken']) and isset($_POST['enable']))
            {

                $device_token = $_POST['DeviceToken'];
                $enable = $_POST['enable'];

                $response = $this->a_m->AddingPushNotification(array("device_token"=>$device_token,"enable"=>$enable));
            }

        }


        echo json_encode($response);

    }



    // enable push notification
    public function EnablePushNotification()
    {
        $this->load->model("accounts_model","a_m");

        $response = array();


        if(count($_POST) > 0)
        {

            if(isset($_POST['DeviceToken']) and isset($_POST['enable']) and isset($_POST['user_type']))
            {

                $device_token = $_POST['DeviceToken'];
                $enable = $_POST['enable'];
                $flag = $_POST['user_type'];

                $response = $this->a_m->AddingPushNotification(array("device_token"=>$device_token,"enable"=>$enable),$flag);
            }

        }


        echo json_encode($response);
    }








}