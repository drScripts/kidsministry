<?php 

namespace App\Models;
use CodeIgniter\Model;


class AbsensiModel extends Model{
    protected $table      = 'absensis'; 
    
	protected $primaryKey = 'id_absensi';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['children_id', 'pembimbing_id','video','image','quiz','month','year','sunday_date','id_foto','id_video','updatedby','addedby','deletedby'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; 


    


    public function getAllDataFetch(){
        $date_name = $this->getDateName();
        $dateNames = explode(" ", $date_name);

        $month = $dateNames[1];
        $year = $dateNames[2];
        $user = user()->toArray()['region'];

        $tables = $this->table($this->table);
        $tables->where('month',$month);
        $tables->where('year', $year);
        $tables->where('region_pembimbing',$user);
        $tables->orderBy('absensis.created_at', 'DESC');
        $tables->join('pembimbings', "pembimbings.id_pembimbing = $this->table.pembimbing_id");
        $tables->join('childrens',"childrens.id_children = $this->table.children_id");
        return $tables;
    }

    public function getSingleData($id){
         
        $tables = $this->find($id);
        $id_pembimbing = $tables['pembimbing_id'];
        $id_children   = $tables['children_id'];
        
        $children_model = new ChildrenModel();
        $pembimbing_model = new PembimbingsModel();
        $children = $children_model->find($id_children);
        $pembimbing = $pembimbing_model->find($id_pembimbing);

        $data = [
            'absensi'       => $tables,
            'children'      => $children,
            'pembimbing'    => $pembimbing,
        ];

        return $data;
    }

    public function searchData(){
       
        
        $date_name = $this->getDateName();
        $dateNames = explode(" ", $date_name);
        $month = $dateNames[1];
        $user = user()->toArray()['region'];
        

        $tables = $this->table($this->table); 
        
        $tables->join('pembimbings', "pembimbings.id_pembimbing = $this->table.pembimbing_id");
        $tables->join('childrens',"childrens.id_children = $this->table.children_id");
        $tables->where('month', $month);
        $tables->where('region_pembimbing', $user);

        
        
        $result = $tables->get()->getResultArray();
        
        return $result;

    }

    public function getDateName(){

        $bulan = array (
                    1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );

        $sunday = strtotime('this sunday');
        $date = date('d',$sunday);
        $date = $date*=1;
        $sunday_month = date('m',$sunday );
        $sunday_month = $sunday_month*=1;
        $sunday_month = $bulan[$sunday_month];
        $sunday_year = date('Y',$sunday );
        $sunday = "$date $sunday_month $sunday_year";
        // today date
        $now = strtotime('now');
        $date_now = date('d',$now);
        $date_now = $date_now*=1;
        $now_month = date('m',$now);
        $now_month = $now_month*=1;
        $now_month = $bulan[$now_month];
        $now_year = date('Y',$now);
        $now_date = "$date_now $now_month $now_year";
        
        // thuesday date
        $tuesday = strtotime('next tuesday');
        $tuesday_date = date('d', $tuesday);
        $tuesday_date = $tuesday_date*=1;
        $tuesday_month = date('m',$tuesday);
        $tuesday_month = $tuesday_month*=1;
        $tuesday_month = $bulan[$tuesday_month];
        $this_tuesday = date('Y',$tuesday);
        $this_tuesday = "$tuesday_date $this_tuesday $this_tuesday";

        // last date
        $last_sunday = strtotime('last sunday');
        $last_date = date('d', $last_sunday);
        $last_date = $last_date*=1;
        $last_month = date('m',$last_sunday);
        $last_month = $last_month*=1;
        $last_month = $bulan[$last_month];
        $last_sundays = date('Y',$last_sunday);
        $las_sundays = "$last_date $last_month $last_sundays";
        
        $file_name = '';
        if($tuesday >= $now){
            if($date == $date_now){
                $file_name = $now_date;
            }elseif($date_now <= $date && $date_now<=$tuesday_date){
                $file_name = $las_sundays;
            }elseif($date_now == 31 && $las_sundays == 30 || $las_sundays == 31 ){
                $file_name = $las_sundays;
            }else{
                $file_name = $sunday;
            }
        } 

        return $file_name;
        
    }



    public function history(){
       $tables = $this->table($this->table);
       $tables->join('pembimbings', "pembimbings.id_pembimbing = $this->table.pembimbing_id");
       $tables->join('childrens', "childrens.id_children = $this->table.children_id");
       $tables->where('region_pembimbing', user()->toArray()['region']);
       return $tables;
    }


    public function chartAbsensi(){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        

       $year = date("Y");
       $datas = $this->history()->where('year',$year)->get()->getResultArray();
       
       $data_awal_bulan = [];
       foreach ($datas as $data) {
            $data_awal_bulan[] = $data['month'];
       }
       $data_bulan_jadi = [];

       $data_bulan = array_unique($data_awal_bulan);

       foreach ($bulan as $bln) {
        foreach ($data_bulan as $dbln) {
            if($bln == $dbln){
                $data_bulan_jadi[] = $dbln;
                break;
            }    
        }
       }
       
       $data_semua = [];

       foreach ($data_bulan_jadi as $month) {
           $datas = $this->history()->where('year',$year)->where('month',$month)->get()->getResultArray();
           $jumlah = count($datas);
           $data_semua[] = [
            'jumlah' => $jumlah,
            'bulan'  => $month,
           ];
       }

 

       return $data_semua;
    }
}





?>