<?php 
namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model{    
    protected $table      = 'kelas'; 
    
	protected $primaryKey = 'id_class';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nama_kelas'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}