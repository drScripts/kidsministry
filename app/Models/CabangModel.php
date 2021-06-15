<?php

namespace App\Models;

use CodeIgniter\Model;


class CabangModel extends Model
{
    protected $table      = 'cabang';

    protected $primaryKey = 'id_cabang';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_cabang', 'nama_cabang', 'quiz', 'zoom'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getCabang($id)
    {
        return $this->find($id);
    }
}
