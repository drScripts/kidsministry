<?php 

namespace App\Models;
use CodeIgniter\Model;


class GroupsModel extends Model{
    protected $table      = 'auth_groups_users'; 
    
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['group_id','user_id'];

    protected $useTimestamps = false;

}