<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\TeamsModel;
use Myth\Auth\Authorization\GroupModel as AuthorizationGroupModel;
use Myth\Auth\Models\UserModel;

class TeamController extends BaseController
{

    protected $usermodel;
    protected $cabangModel;
    protected $groupModel;
    protected $teamModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->usermodel = new UserModel();
        $this->cabangModel = new CabangModel();
        $this->groupModel = new AuthorizationGroupModel();
        $this->teamModel = new TeamsModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {

        $users = $this->usermodel->getDataUser()->findAll();

        $data = [
            'title'         => "Team's Management",
            'team'      => $users,
        ];
        return view('dashboard/team/index', $data);
    }

    public function edit(int $id)
    {

        $user = $this->usermodel->getSingleUser($id)->get()->getFirstRow();


        $groups = $this->usermodel->getGroups()->get()->getResult();
        $cabangs = $this->cabangModel->get()->getResult();


        $data = [
            'title' => 'Edit User Data',
            'userdata'  => $user,
            'validation'    => \Config\Services::validation(),
            'group'     => $groups,
            'cabangs'   => $cabangs
        ];
        return view('dashboard/team/edit', $data);
    }

    public function attemptEdit(int $id)
    {
        $validate = $this->validate([
            'username' => [
                'rules'     => 'required|string',
                'errors'    => [
                    'required'  => 'Please Insert Your Username !',
                    'string'   => 'The Pembimbing Must Be string',
                ],
            ],
            'email' => [
                'rules'     => 'required|valid_email|valid_emails',
                'errors'    => [
                    'required'  => 'Please Input Your Valid Email !',
                    'valid_email'   => 'The Email Must Be A Valid email',
                    'valid_emails'   => 'The Email Must Be A Valid email',
                ],
            ],
            'groups'     => [
                'rules'     => 'required|integer',
                'errors'    => [
                    'required'      => 'Please Select The groups !',
                    'integer'        => 'groups Must Be integer !',
                ],
            ],
            'cabang'    => [
                'rules'     => 'required|integer',
                'errors'    => [
                    'required'   => 'Please Select The cabang !',
                    'integer'  => 'cabang Must Be integer !',
                ],
            ],
        ]);

        if (!$validate) {
            return redirect()->to("/team/edit/$id")->withInput();
        }

        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $groups = $this->request->getVar('groups');
        $cabang = $this->request->getVar('cabang');


        $data = [
            'email'     => $email,
            'username'  => $username,
            'region'    => $cabang,
        ];

        $this->teamModel->update($id, $data);
        $this->groupModel->removeUserFromAllGroups($id);
        $this->groupModel->addUserToGroup($id, $groups);



        session()->setFlashData('success_update', 'User Data Successfully Updated !');
        return redirect()->to("/team");
    }

    public function getCabang()
    {
        $cabang = $this->cabangModel->findAll();
        return json_encode($cabang);
    }

    public function deleteTeam($id)
    {
        $deleted = $this->userModel->delete($id);
        $this->userModel->purgeDeleted();
        if ($deleted) {
            session()->setFlashData('success_deleted', 'Team Successfully Deleted');
            return redirect()->to('/team');
        }
    }

    public function refresh()
    {
        $this->db->query("UPDATE `users` SET `notify_birthday` = 0");
        return redirect()->to('/team');
    }
}
