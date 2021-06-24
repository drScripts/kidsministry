<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\CabangModel;
use App\Models\ChildrenModel;

class TraceController extends BaseController
{
    protected $childrenModel;
    protected $cabangModel;
    protected $absensiModel;

    public function __construct()
    {
        $this->childrenModel = new ChildrenModel();
        $this->cabangModel = new CabangModel();
        $this->absensiModel = new AbsensiModel();
    }

    public function absensiGetYear($id)
    {
        return $this->absensiModel
            ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->where('region_pembimbing', $id);
    }

    public function index()
    {
        $data = [];
        $cabang = $this->cabangModel->find(user()->toArray()['region']);

        if ($cabang['nama_cabang'] == 'pusat') {
            $cabangTemp =  $this->cabangModel
                ->where('nama_cabang !=', 'pusat')
                ->findAll();
            foreach ($cabangTemp as $cabang) {
                $data[] = [
                    'nama_cabang'   => $cabang['nama_cabang'],
                    'id_cabang'     => $cabang['id_cabang'],
                ];
            }
        } else {
            $absenTemp = $this->absensiGetYear($cabang['id_cabang'])->select('year')->findAll();

            foreach ($absenTemp as $absen) {
                $data[] = $absen['year'];
            }
            $data = array_unique($data);
        }

        $data = [
            'data'  => $data,
            'title' => "Trace Children's",
        ];

        return view('dashboard/trace/index', $data);
    }

    public function getYear($id)
    {
        $year = [];
        $data = $this->absensiGetYear($id)->select('year')->findAll();
        foreach ($data as $d) {
            $year[] = $d['year'];
        }

        $year = array_unique($year);

        return json_encode($year);
    }

    public function getMonth($year, $id_cabang = null)
    {
        $cabang = $id_cabang == null ? user()->toArray()['region'] : $id_cabang;

        $months = [];
        $month = $this->absensiGetYear($cabang)
            ->where('year', $year)
            ->select('month')
            ->findAll();
        foreach ($month as $m) {
            $months[] = $m['month'];
        }

        $months = array_unique($months);
        return json_encode($months);
    }

    public function trace($year, $month, $id_cabang = null)
    {
        $cabang = $id_cabang == null ? user()->toArray()['region'] : $id_cabang;

        $datas = [];

        $children = $this->childrenModel
            ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->where('region_pembimbing', $cabang)
            ->orderBy('nama_kelas', 'ASC')
            ->findAll();

        foreach ($children as $child) {
            $nama = $child['children_name'];

            $jumlah = $this->absensiModel
                ->where('year', $year)
                ->where('month', $month)
                ->where('children_id', $child['id_children'])
                ->countAllResults();

            $datas["$jumlah-$nama"] = [
                'children' => $child,
                'jumlah'   => $jumlah,
            ];
        }
        krsort($datas);
        $data =  [
            'title' => "Tracing Children's",
            'data'  => $datas,
            'month' => $month,
            'year'  => $year,
        ];

        return view('dashboard/trace/trace', $data);
    }

    public function details($id, $month, $year)
    {
        $data = $this->absensiModel
            ->join('childrens', 'childrens.id_children = absensis.children_id')
            ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->where('children_id', $id)
            ->where('year', $year)
            ->where('month', $month)
            ->findAll();

        $nama = $data[0]['children_name'];

        $data = [
            'title'         => "Trace Details's",
            'data'          => $data,
            'children_name' => $nama,
        ];
        return view('dashboard/trace/details', $data);
    }
}
