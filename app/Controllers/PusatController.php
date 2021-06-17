<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\CabangModel;
use App\Models\ChildrenModel;
use App\Models\PembimbingsModel;
use App\Models\TempModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PusatController extends BaseController
{

    protected $absensiModel;
    protected $childrenModel;
    protected $pembimbingModel;
    protected $cabangModel;
    protected $quiz;
    protected $absensiController;
    protected $tempModel;
    protected $db;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->childrenModel = new ChildrenModel();
        $this->pembimbingModel = new PembimbingsModel();
        $this->cabangModel = new CabangModel();
        $this->quiz =  $this->cabangModel->find(user()->toArray()['region'])['quiz'];
        $this->absensiController = new AbsensiController();
        $this->tempModel = new TempModel();
        $this->db = \Config\Database::connect();
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
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->select('childrens.created_by as childrenAdd, childrens.updated_by as childrenUpdate,children_name,code,name_pembimbing,role,nama_cabang,username,email,childrens.created_at as childrenCreated,childrens.updated_at as childrenUpdated,nama_kelas')
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
            ->select('video,image,absensis.quiz as quis,sunday_date,absensis.created_at as absensiCreatedAt,children_name,name_pembimbing,nama_cabang,username,absensis.updated_at as absensiUpdatedAt,absensis.updated_by as absensiUpdateBy')
            ->find($id);
        $data = [
            'absensis'  => $data,
            'title'     => "Detail's Absensi",
            'quiz'      => $this->quiz,
        ];
        return view('dashboard/absensi/details', $data);
    }

    public function absensiHistory($cabang)
    {
        $dataAbsensi = [];
        $data = $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
            ->where('nama_cabang', $cabang)
            ->findAll();
        foreach ($data as $d) {
            $dataAbsensi[] = $d['month'] . '-' . $d['year'] . '-' . $d['nama_cabang'];
        }

        $dataAbsensi = array_unique($dataAbsensi);

        return json_encode($dataAbsensi);
    }

    public function trackingData($mode = null)
    {
        $data = [];
        if ($mode == null) {
            $current_page = $this->request->getVar('page_tracking') ? $this->request->getVar('page_tracking') : 1;
            $data = $this->absensiModel->onlyDeleted()
                ->join('childrens', 'childrens.id_children = absensis.children_id')
                ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
                ->join('users', 'users.id = absensis.deleted_by')
                ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
                ->select('children_name,absensis.deleted_at as absensiDeleted,username,email,name_pembimbing,nama_cabang')
                ->orderBy('absensis.deleted_at', 'ASC')
                ->paginate(7, 'tracking');
            $pager = $this->absensiModel->pager;
            $data = [
                'title'          => "Tracking Absensi",
                'datas'          => $data,
                'pager'          => $pager,
                'current_page'   => $current_page,
            ];
        } elseif ($mode == 'children') {
            $current_page = $this->request->getVar('pagetracking') ? $this->request->getVar('page_tracking') : 1;
            $data = $this->childrenModel->onlyDeleted()
                ->join('users', 'users.id = childrens.deleted_by')
                ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
                ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
                ->select('children_name,childrens.deleted_at as childrenDeleted,username,email,name_pembimbing,nama_cabang')
                ->orderBy('childrens.deleted_at', 'ASC')
                ->paginate(7, 'tracking');

            $pager = $this->childrenModel->pager;

            $data = [
                'title'         => "Tracking Children",
                'datas'         => $data,
                'pager'         => $pager,
                'current_page'   => $current_page,
            ];
        }

        return view('dashboard/tracking/index', $data);
    }

    public function historyExport($month, $year, $cabang)
    {
        $spredsheet = new Spreadsheet();
        $sheet = $spredsheet->getActiveSheet();

        $data =  $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')
            ->join('childrens', 'childrens.id_children = absensis.children_id')
            ->join('users', 'users.id = absensis.created_by')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->where('month', $month)
            ->where('year', $year)
            ->where('nama_cabang', $cabang)
            ->get()
            ->getResultArray();

        $sunday_date = [];
        $semua = [];

        foreach ($data as $d) {
            $sunday_date[] = $d['sunday_date'];
        }

        $sunday_date = array_unique($sunday_date);

        foreach ($sunday_date as $sd) {
            foreach ($data as $d) {
                if ($d['sunday_date'] == $sd) {
                    $semua[] = [
                        'Nama Anak'         => $d['children_name'],
                        'Kode Anak'         => $d['code'],
                        'Role Anak'         => $d['nama_kelas'],
                        'Nama Pembimbing'   => $d['name_pembimbing'],
                        'Absen Foto'        => $d['image'],
                        'Absen Video'       => $d['video'],
                        'Absen Quiz'        => $d['quiz'],
                        'Sunday Date'       => $d['sunday_date'],
                    ];
                }
            }

            $semua[] = [
                'Nama Anak'         => '',
                'Kode Anak'         => '',
                'Role Anak'         => '',
                'Nama Pembimbing'   => '',
                'Absen Foto'        => '',
                'Absen Video'       => '',
                'Absen Quiz'        => '',
                'Sunday Date'       => '',
            ];
        }

        array_pop($semua);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Anak');
        $sheet->setCellValue('C1', 'Code Anak');
        $sheet->setCellValue('D1', 'Kelas Anak');
        $sheet->setCellValue('E1', 'Nama Pembimbing');
        $sheet->setCellValue('F1', 'Absen Foto');
        $sheet->setCellValue('G1', 'Absen Video');
        $sheet->setCellValue('H1', 'Children Quiz');
        $sheet->setCellValue('I1', 'Tanggal Minggu');

        $no = 1;
        $index = 2;

        foreach ($semua as $data) {
            if ($data['Nama Anak'] != " ") {
                $sheet->setCellValue('A' . $index, $no++);
            } else {
                $sheet->setCellValue('A' . $index, ' ');
            }
            $sheet->setCellValue('B' . $index, $data['Nama Anak']);
            $sheet->setCellValue('C' . $index, $data['Kode Anak']);
            $sheet->setCellValue('D' . $index, $data['Role Anak']);
            $sheet->setCellValue('E' . $index, $data['Nama Pembimbing']);
            $sheet->setCellValue('F' . $index, $data['Absen Foto']);
            $sheet->setCellValue('G' . $index, $data['Absen Video']);
            $sheet->setCellValue('H' . $index, $data['Absen Quiz']);
            $sheet->setCellValue('I' . $index, $data['Sunday Date']);
            $index++;
        }

        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(30);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(13);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(20);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(20);

        $spredsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spredsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(9);

        $writter = new Xlsx($spredsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Absensi ' . $cabang . ' ' . $month . ' ' . $year . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writter->save('php://output');
    }

    public function settings()
    {
        $cabang = $this->cabangModel->find(user()->toArray()['region']);
        $quiz = $cabang['quiz'];
        $zoom = $cabang['zoom'];

        $data = [
            'title' => 'Settings',
            'quiz'  => boolval($quiz),
            'zoom'  => boolval($zoom),
        ];

        return view('dashboard/settings/index', $data);
    }

    public function attemptSettings($mode)
    {
        $respond = [];
        if ($mode == 'quiz') {
            $hasil = 0;
            $request = $this->request->getVar()['status'];


            if ($request == 'true') {
                $hasil = 1;

                $update = $this->cabangModel->update(user()->toArray()['region'], [
                    'quiz'  => $hasil,
                ]);

                if ($update) {
                    $respond = [
                        'success'  => 'Quiz Module Success Updated. Now Quiz module is Active',
                    ];
                } else {
                    $respond = [
                        'failed'  => 'Quiz Module Failed Updated',
                    ];
                }
            } else {
                $hasil = 0;
                $update = $this->cabangModel->update(user()->toArray()['region'], [
                    'quiz'  => $hasil,
                ]);

                if ($update) {
                    $respond = [
                        'success'  => 'Quiz Module Success Updated. Now Quiz Module is non Active',
                    ];
                } else {
                    $respond = [
                        'failed'  => 'Quiz Module Failed Updated',
                    ];
                }
            }
        } elseif ($mode == 'zoom') {
            $hasil = 0;
            $request = $this->request->getVar()['status'];


            if ($request == 'true') {
                $hasil = 1;

                $update = $this->cabangModel->update(user()->toArray()['region'], [
                    'zoom'  => $hasil,
                ]);

                if ($update) {
                    $respond = [
                        'success'  => 'Zoom Module Success Updated. Now Zoom module is Active',
                    ];
                } else {
                    $respond = [
                        'failed'  => 'Zoom Module Failed Updated',
                    ];
                }
            } else {
                $hasil = 0;
                $update = $this->cabangModel->update(user()->toArray()['region'], [
                    'zoom'  => $hasil,
                ]);

                if ($update) {
                    $respond = [
                        'success'  => 'Zoom Module Success Updated. Now Zoom Module is non Active',
                    ];
                } else {
                    $respond = [
                        'failed'  => 'Quiz Module Failed Updated',
                    ];
                }
            }
        }


        return json_encode($respond);
    }
}
