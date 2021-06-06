<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\ChildrenModel;
use App\Models\PembimbingsModel;

class PusatController extends BaseController
{

    protected $absensiModel;
    protected $childrenModel;
    protected $pembimbingModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->childrenModel = new ChildrenModel();
        $this->pembimbingModel = new PembimbingsModel();
    }

    public function getHomeChartYear($cabang = null)
    {

        $bulan = [];
        $dataJumlah = [];

        if ($cabang == null) {

            $data = $this->absensiModel->getAllMonth()->findAll();

            foreach ($data as $d) {
                $bulan[] = $d['month'];
            }

            $bulan = array_unique($bulan);

            foreach ($bulan as $b) {
                $jumlah = $this->absensiModel->getAllCountByMonth($b);
                $dataJumlah[] = [
                    'bulan'     => $b,
                    'jumlah'    => $jumlah,
                ];
            }
        } else {

            $data = $this->absensiModel->getAllMonth($cabang)->findAll();

            foreach ($data as $d) {
                $bulan[] = $d['month'];
            }

            $bulan = array_unique($bulan);

            foreach ($bulan as $b) {
                $jumlah = $this->absensiModel->getAllCountByMonth($b, $cabang);
                $dataJumlah[] = [
                    'bulan'     => $b,
                    'jumlah'    => $jumlah,
                ];
            }
        }

        return json_encode($dataJumlah);
    }

    public function getHomeChartMonth($month, $cabang = null)
    {
        if ($cabang == null) {
            return json_encode($this->absensiModel->getAllCountMonthly($month));
        } else {
            return json_encode($this->absensiModel->getAllCountMonthly($month, $cabang));
        }
    }

    public function getChildrenByCabang($cabang)
    {
        $data = $this->childrenModel->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->where('nama_cabang', $cabang)->get()->getResultArray();
        return json_encode($data);
    }

    public function showAllChildren()
    {
        $childrens = $this->childrenModel->getPusatChildren()->findAll();
        return json_encode($childrens);
    }

    public function details($id)
    {
        $child = $this->childrenModel
            ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
            ->join('users', 'users.id = childrens.created_by')
            ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
            ->select('childrens.created_by as childrenAdd, childrens.updated_by as childrenUpdate,children_name,code,name_pembimbing,role,nama_cabang,username,email,childrens.created_at as childrenCreated,childrens.updated_at as childrenUpdated')
            ->find($id);


        $data = [
            'title'  => 'Detail Children',
            'childs' => $child,
        ];

        return view('dashboard/children/detail', $data);
    }

    public function getPembimbing($cabang = null)
    {
        $pembimbing = [];

        if ($cabang == null) {
            $pembimbing = $this->pembimbingModel->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->findAll();
        } else {
            $pembimbing = $this->pembimbingModel->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->where('nama_cabang', $cabang)->findAll();
        }

        return  json_encode($pembimbing);
    }

    public function getPusatSunday($cabang)
    {
        $date = $this->absensiModel->getDateName();
        $year = explode(' ', $date)[2];
        $month = explode(' ', $date)[1];

        $data = $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->where('year', $year)->where('month', $month)->where('nama_cabang', $cabang)->findAll();

        $sunday_date = [];

        foreach ($data as $d) {
            $sunday_date[] = $d['sunday_date'];
        }

        $sunday_date = array_unique($sunday_date);
        return json_encode($sunday_date);
    }

    public function getAbsensi($cabang = null, $sunday = null)
    {

        $date = $this->absensiModel->getDateName();
        $data = [];
        $year = explode(' ', $date)[2];
        $month = explode(' ', $date)[1];
        if ($cabang == 'null' && $sunday != null) {
            $data = $this->absensiModel->join('childrens', 'childrens.id_children = absensis.children_id')
                ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
                ->join('cabang', 'cabang.id_cabang = region_pembimbing')
                ->where('year', $year)
                ->where('month', $month)
                ->where('sunday_date', $sunday)
                ->findAll();
        } elseif ($cabang != null && $sunday == null) {
            $data = $this->absensiModel->join('childrens', 'childrens.id_children = absensis.children_id')
                ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
                ->join('cabang', 'cabang.id_cabang = region_pembimbing')
                ->where('year', $year)
                ->where('month', $month)
                ->orderBy('absensis.created_at', 'DESC')
                ->where('nama_cabang', $cabang)
                ->findAll();
        } else if ($cabang != null && $sunday != null) {
            $data = $this->absensiModel->join('childrens', 'childrens.id_children = absensis.children_id')
                ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
                ->join('cabang', 'cabang.id_cabang = region_pembimbing')
                ->where('year', $year)
                ->where('month', $month)
                ->where('nama_cabang', $cabang)
                ->where('sunday_date', $sunday)
                ->findAll();
        } else {

            $data = $this->absensiModel->join('childrens', 'childrens.id_children = absensis.children_id')
                ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
                ->join('cabang', 'cabang.id_cabang = region_pembimbing')
                ->where('year', $year)
                ->where('month', $month)
                ->orderBy('absensis.created_at', 'DESC')
                ->get()->getResultArray();
        }

        return json_encode($data);
    }

    public function detailsAbsen($id)
    {
        $data = $this->absensiModel->join('childrens', 'childrens.id_children = absensis.children_id')
            ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
            ->join('users', 'users.id = absensis.created_by')
            ->select('video,image,quiz,sunday_date,absensis.created_at as absensiCreatedAt,children_name,name_pembimbing,nama_cabang,username,absensis.updated_at as absensiUpdatedAt,absensis.updated_by as absensiUpdateBy')
            ->find($id);

            $data = [
                'absensis'  => $data,
                'title'     => "Detail's Absensi",
            ];
            return view('dashboard/absensi/details',$data);
    }

    public function absensiHistory($cabang){
           $dataAbsensi = [];
           $data = $this->absensiModel->join('pembimbings','pembimbings.id_pembimbing = absensis.pembimbing_id')
                               ->join('cabang','cabang.id_cabang = pembimbings.region_pembimbing')
                               ->where('nama_cabang',$cabang)
                               ->findAll();
            foreach ($data as $d ) {
                $dataAbsensi[] = $d['month'] . '-' . $d['year'] . '-' . $d['nama_cabang'];
            }

            $dataAbsensi = array_unique($dataAbsensi);

            return json_encode($dataAbsensi);
    }

    public function trackingData($mode = null){
        $data = [];
        if($mode == null){
           $current_page = $this->request->getVar('page_tracking') ? $this->request->getVar('page_tracking') : 1;
           $data = $this->absensiModel->onlyDeleted()
                                      ->join('childrens','childrens.id_children = absensis.children_id')
                                      ->join('pembimbings','pembimbings.id_pembimbing = absensis.pembimbing_id')
                                      ->join('users','users.id = absensis.deleted_by')
                                      ->join('cabang','cabang.id_cabang = pembimbings.region_pembimbing')
                                      ->select('children_name,absensis.deleted_at as absensiDeleted,username,email,name_pembimbing,nama_cabang')
                                      ->orderBy('absensis.deleted_at','ASC')
                                      ->paginate(7,'tracking');
           $pager = $this->absensiModel->pager;
           $data = [
               'title'          => "Tracking Absensi",
               'datas'          => $data,
               'pager'          => $pager,
               'current_page'   => $current_page,
           ];
           
        }elseif($mode == 'children'){
            $current_page = $this->request->getVar('pagetracking') ? $this->request->getVar('page_tracking') : 1;
            $data = $this->childrenModel->onlyDeleted()
                                        ->join('users','users.id = childrens.deleted_by')
                                        ->join('pembimbings','pembimbings.id_pembimbing = childrens.id_pembimbing')
                                        ->join('cabang','cabang.id_cabang = pembimbings.region_pembimbing')
                                        ->select('children_name,childrens.deleted_at as childrenDeleted,username,email,name_pembimbing,nama_cabang')
                                        ->orderBy('childrens.deleted_at','ASC')
                                        ->paginate(7,'tracking');

            $pager = $this->childrenModel->pager;

            $data = [
                'title'         => "Tracking Children",
                'datas'         => $data,
                'pager'         => $pager,
                'current_page'   => $current_page,
            ];
        }

        return view('dashboard/tracking/index',$data);
    }
}
