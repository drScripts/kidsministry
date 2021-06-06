<?php 
namespace App\Models;

use CodeIgniter\Model;

class ChildrenModel extends Model{
    protected $table      = 'childrens'; 
    
	protected $primaryKey = 'id_children';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['children_name', 'code','id_pembimbing','role','created_by','updated_by','deleted_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; 

    public function getChildren(){ 

        return $this->table('childrens')
        ->join('pembimbings', "pembimbings.id_pembimbing = $this->table.id_pembimbing")->where('region_pembimbing',user()->toArray()['region']);
    }

    public function searchChildren(){ 
        return $this->table('childrens')->join('pembimbings',"pembimbings.id_pembimbing = $this->table.id_pembimbing")->where('region_pembimbing',user()->toArray()['region']);    
    }

    public function getSingleChildren($id){
        return $this->find($id);
    }

    public function getPusatChildren(){
        return $this->table('childrens')
        ->join('pembimbings', "pembimbings.id_pembimbing = $this->table.id_pembimbing")->join('cabang','cabang.id_cabang = pembimbings.region_pembimbing')->orderBy('nama_cabang', 'ASC');;
    }
    
}

