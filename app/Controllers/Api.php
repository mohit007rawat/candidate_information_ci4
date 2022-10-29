<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;
use CodeIgniter\Files\File;
use Dompdf\Dompdf;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Api extends ResourceController
{
    use ResponseTrait;
    // protected $session;
    // protected $data;
    protected $candidate_model;

     // Initialize Objects
    public function __construct(){
        $this->candidate_model = new CandidateModel();
        // $this->session= \Config\Services::session();
        // $this->data['session'] = $this->session;
    }


    // Index List Page
    public function index(){
        if(!empty($this->request->getVar('search_data')))
        {
            $searchValue=  $this->request->getVar('search_data');
            $this->candidate_model->like('name', $searchValue);
            $this->candidate_model->orLike('email', $searchValue);
            $this->candidate_model->orLike('contact', $searchValue);
        }
        $data = $this->candidate_model->orderBy('id DESC')->select("*,CONCAT('".base_url('/uploads/photo')."/',profile_img) as profile_img,CONCAT('".base_url('/uploads/resume')."/',resume) as resume")->get()->getResult();
        // echo $this->candidate_model->getLastQuery();
        $response = [
            'status'   => 200,
            'data' => $data,
            'messages' => [
            'success' => 'Data Found successfully'
            ]
        ];
        return $this->respond($response);
    }

    // Insert And Update Function
    public function save(){
        $post = [
            'name' => $this->request->getPost('name'),
            'gender' => $this->request->getPost('gender'),
            'contact' => $this->request->getPost('contact'),
            'email' => $this->request->getPost('email'),
            'education_qualification' => $this->request->getPost('education_qualification')            
        ];

        $resume = $this->request->getFile('resume');
        if(!empty($_FILES['resume']['name']))
        {
            if (!$resume->hasMoved()) {
                $getRandomName =$resume->getRandomName();
                $resume->move('uploads/resume/', $getRandomName);
            }
            $post['resume'] = $getRandomName ?? NULL;
        }

        $photo = $this->request->getFile('profile_img');
        if(!empty($_FILES['profile_img']['name']))
        {
            if (!$photo->hasMoved()) {
                $getRandomPhotoName =$photo->getRandomName();
                $photo->move('uploads/photo/', $getRandomPhotoName);
            }
            $post['profile_img'] = $getRandomPhotoName ?? NULL;
        }


        if(!empty($this->request->getPost('candidate_id')))
        {
            $save = $this->candidate_model->where(['id'=>$this->request->getPost('candidate_id')])->set($post)->update();
            $msg = 'Details has been updated successfully';
        }
        else{
            $save = $this->candidate_model->insert($post);
            $msg = 'Details has been added successfully';
        }


        if($save){
            $response = [
                'status'   => 200,
                'messages' => [
                    'success' => $msg
                ]
            ];
        }else{
            $response = [
                'status'   => 400,
                'messages' => [
                    'success' => 'Something went Wrong!!'
                ]
            ];
        }
        return $this->respondCreated($response);
    }


    // Delete Data
    public function remove($id = null){
        if(empty($id)){
            return $this->failNotFound('No Candidate found');
        }
        $delete = $this->candidate_model->delete($id);
        if($delete){
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Candidate Details deleted successfully'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Candidate found');
        }
    }

    // PDF Data
    public function view_pdf($id=''){
        if(empty($id)){
            $this->session->setFlashdata('error_message','Unknown Data ID.') ;
            return redirect()->to('/candidate_curd/index');
        }
        $this->data['page_title'] = "View Contact Details";
        $qry= $this->candidate_model->select("*")->where(['id'=>$id]);
        $finalData = $qry->first();

        $html= "<table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Name</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>".$finalData['name']."</td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Email</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>".$finalData['email']."</td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Mobile Number</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>".$finalData['contact']."</td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Gender</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>".$finalData['gender']."</td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Education Qualification</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>".$finalData['education_qualification']."</td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Resume</th>
                        <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'><a href=/uploads/resume/".$finalData['resume']." target='_blank'>View RESUME</a></td>
                    </tr>
                    <tr>
                        <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Photo</th>
                            <img src=/uploads/photo/".$finalData['profile_img']." width='100px' height='100px'>
                            <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'></td>
                    </tr>
                </table>";
        
        // echo WRITEPATH; die;

        $dompdf = new Dompdf(); 
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("",  array("Attachment"=>false));

        // require_once WRITEPATH . '../vendor/autoload.php';
        // $mpdf = new \Mpdf\Mpdf();
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();
        // die;
    }

}
