<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class planner_model extends CI_Model
{

    public function getSoundCloudResource($user_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_external_media.id,user_external_media.name,user_external_media.url,user_external_media.thumbnail_url,user_external_media.type FROM user_external_media WHERE (type = 'S' AND user_external_media.user_id = '".$user_id."') ORDER BY user_external_media.id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    public function getYoutubeResource($user_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_external_media.id,user_external_media.name,user_external_media.url,user_external_media.thumbnail_url,user_external_media.type FROM user_external_media WHERE (type = 'Y' AND user_external_media.user_id = '".$user_id."') ORDER BY user_external_media.id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    public function getTalentPhotos($user_id)
    {
        $data = array();

        $query = $this->db->query("SELECT user_files.name AS PhotoName,user_files.file_path AS Path FROM user_files WHERE (user_files.file_type = 'P' AND user_files.user_id = '".$user_id."') ORDER BY user_files.id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    public function TalentMedia($user_id)
    {
        $data = array();

        $data["SoundCloud"] = $this->getSoundCloudResource($user_id);
        $data["Youtube"] = $this->getYoutubeResource($user_id);
        $data["Photos"] = $this->getTalentPhotos($user_id);

        return $data;
    }



    // articles
    public function getAllarticles()
    {
        $data = array();

        $query = $this->db->query("SELECT a_id AS id,a_title AS title,a_contenturl AS contentURL,a_imageurl AS imageURL,a_source AS source FROM articles ORDER BY a_id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }



    // video articles
    // articles
    public function getAllVideoarticles()
    {
        $data = array();

        $query = $this->db->query("SELECT v_id,v_src AS video_source,v_title FROM videos ORDER BY v_id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }






}




?>