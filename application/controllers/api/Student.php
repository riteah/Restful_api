<?php
require APPPATH.'libraries/REST_Controller.php';

class Student extends REST_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->load->model(array("api/student_model"));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('security'));
    }
    /*
    INSERT: POST REST TYPE
    UPDATE: PUT REST TYPE
    DELETE: DELETE REST TYPE
    LIST: GET REST TYPE
    */

    // POST: <project_url>/index.php/student
    public function index_post(){
        // insert data method
        // $data = json_decode(file_get_contents("php://input"));

        // $name = isset($data->name) ? $data->name : "";
        // $age = isset($data->age) ? $data->age : "";
        // $grade = isset($data->grade) ? $data->grade : "";
        // $address = isset($data->address) ? $data->address : "";
        //form inputs
        $name = $this->security->xss_clean($this->input->post("name"));
        $age = $this->security->xss_clean($this->input->post("age"));
        $grade = $this->security->xss_clean($this->input->post("grade"));
        $address = $this->security->xss_clean($this->input->post("address"));

        //form validation for inputs
        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("age", "Age", "required");
        $this->form_validation->set_rules("grade", "Grade", "required");
        $this->form_validation->set_rules("address", "Address", "required");

        //checking for form submission has any error
        if($this->form_validation->run() === FALSE){
            //we have some error
            $this->response(array(
                "status" => 0,
                "message" => "All fields required"
            ), REST_Controller::HTTP_NOT_FOUND);
        }else{
            if(!empty($name) && !empty($age) && !empty($grade) && !empty($address)){
                //all values are availble
                $student = array(
                    "name" => $name,
                    "age" => $age,
                    "grade" => $grade,
                    "address" => $address,
                );
                if($this->student_model->insert_student($student)){
                    $this->response(array(
                        "status" => 1,
                        "message" => "Student has been created"
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        "status" => 0,
                        "message" => "Failed to create student"
                    ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }else{
                //we have some empty field
                $this->response(array(
                    "status" => 0,
                    "message" => "All fields required"
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }
      
    }
    
    // PUT: <project_url>/index.php/student
    public function index_put(){
        // UPDATE data method
       $data = json_decode(file_get_contents("php://input"));

       if(isset($data->id) && isset($data->name) && isset($data->age) && isset($data->grade) && isset($data->address)){
        $student_id = $data->id;

        $student_info = array(
        "name" =>  $data->name,
        "age" => $data->age,
        "grade" => $data->grade,
        "address" => $data->address

        );
        if($this->student_model->update_students($student_id,$student_info)){
            $this->response(array(
                "status" => 1,
                "message" => "student data updated succesfully"
            ), REST_Controller::HTTP_OK);
        }else{
            $this->response(array(
                "status" => 0,
                "message" => "failed to update data"
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
       }else{
        $this->response(array(
            "status" => 0,
            "message" => "All fields required"
        ), REST_Controller::HTTP_NOT_FOUND);
       }
    }

    // DELETE: <project_url>/index.php/student
    public function index_delete(){
        $data = json_decode(file_get_contents("php://input"));
        $student_id = $this->security->xss_clean($data->student_id);
        if($this->student_model->delete_student($student_id)){
            $this->response(array(
                "status" => 1,
                "message" => "student has been deleted"
            ), REST_Controller::HTTP_OK);
        }else{
            $this->response(array(
                "status" => 0,
                "message" => "Failed t delete student"
            ), REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // LIST: <project_url>/index.php/student
    public function index_get(){
        // LIST data method
      $students = $this->student_model->get_students();

        //print_r($query->result());
        if(count($students) > 0){
        $this->response(array(
            "status" => 1,
            "message" => "student found",
            "data" => $students
        ), REST_Controller::HTTP_OK);
    }else{
        $this->response(array(
            "status" => 0,
            "message" => "No student found",
            "data" => $students
        ), REST_Controller::HTTP_NOT_FOUND);
    }
    }
}
?>