<?php 
namespace App\Models;

use CodeIgniter\Model;

class PembimbingsModel extends Model{    
    protected $table      = 'pembimbings'; 
    
	protected $primaryKey = 'id_pembimbing';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name_pembimbing','region_pembimbing'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function getPembimbings(){
       return $this->table($this->table)->where('region_pembimbing',user()->toArray()['region']);
    }


}