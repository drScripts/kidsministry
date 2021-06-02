<?php  
namespace App\Models;
use CodeIgniter\Model;

class GoogleTokenModel extends Model{

    protected $table      = 'google_token'; 
    
	protected $primaryKey = 'token_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['access_token','refresh_token','expires_in','scope','token_type','created'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; 


}




?>