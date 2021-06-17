<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\CabangModel;
use App\Models\TempModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RankingController extends BaseController
{

    protected $absensiModel;
    protected $userRegion;
    protected $cabangModel;
    protected $tempModel;
    protected $db;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->userRegion = user()->toArray()['region'];
        $this->cabangModel = new CabangModel();
        $this->tempModel = new TempModel();
        $this->db = \Config\Database::connect();
    }


    public function index()
    {

        $data = [];

        if (!in_groups('pusat')) {
            $years = [];
            $year = $this->absensiModel->select('year')->findAll();
            foreach ($year as $y) {
                $years[] = $y['year'];
            }

            $year = array_unique($years);
            $data = [
                'title'  => 'Ranking',
                'years' => $year,
            ];
        } else {
            $cabang = $this->cabangModel->findAll();

            $data = [
                'title'  => 'Ranking',
                'cabang' => $cabang,
            ];
        }

        return view('dashboard/absensi/rangking', $data);
    }

    public function gettingYear($id_cabang)
    {

        $data = $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->where('region_pembimbing', $id_cabang)
            ->select('year')
            ->get()
            ->getResultArray();

        $year = [];

        foreach ($data as $d) {
            $year[] = $d['year'];
        }

        $year = array_unique($year);

        return json_encode($year);
    }

    public function getAbsensiDate($year, $id_cabang = null)
    {
        if ($id_cabang == null) {
            $id_cabang = $this->userRegion;
        }

        $date = [];
        $dates = [];
        $data = $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->where('region_pembimbing', $id_cabang)
            ->where('year', $year)
            ->findAll();
        foreach ($data as $d) {
            $date[] = $d['sunday_date'];
        }
        $date = array_unique($date);

        foreach ($date as $d) {
            $dates[] = $this->dateToTanggal($d);
        }

        return json_encode($dates);
    }

    public function getReport()
    {
        $cabang = $this->request->getVar('cabang');
        if ($cabang == null) {
            $cabang = $this->userRegion;
        }

        $year = $this->request->getVar('year');
        $start = $this->request->getVar('start');
        $end = $this->request->getVar('end');
        $type = $this->request->getVar('kelasRadio');
        $nama_cabang = $this->cabangModel->find($cabang)['nama_cabang'];

        $data =  $this->absensiModel->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->join('childrens', 'childrens.id_children = absensis.children_id')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->where('region_pembimbing', $cabang)
            ->where('year', $year)
            ->orderBy('children_name', 'ASC')
            ->findAll();

        $start = strtotime($start);
        $end = strtotime($end);
        $timedData = [];
        if ($type != 'costum') {
            foreach ($data as $d) {
                $thisTime = strtotime($this->dateToTanggal($d['sunday_date']));
                if ($thisTime >= $start && $thisTime <= $end) {
                    $timedData[] = $d;
                }
            }
        } else {
            $kelas = $this->request->getVar('kelas');
            foreach ($data as $d) {
                $thisTime = strtotime($this->dateToTanggal($d['sunday_date']));
                if ($thisTime >= $start && $thisTime <= $end) {
                    foreach ($kelas as $k) {
                        if ($d['nama_kelas'] == $k) {
                            $timedData[] = $d;
                        }
                    }
                }
            }
        }

        $tempDataPoint = [];
        $name = '';
        $tempPoint = 0;
        $finalData = [];

        // foto = 1, video = 1, quiz =1, zoom = 1
        foreach ($timedData as $data) {
            if ($name != $data['children_name']) {
                $name = '';
                $tempPoint = 0;
                $name = $data['children_name'];
                if ($data['image'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['video'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['quiz'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['zoom'] == 'yes') {
                    $tempPoint += 1;
                }
                $tempDataPoint[$data['children_name']] = [
                    'data_anak' => $data,
                    'point_anak' => $tempPoint
                ];
            } elseif ($name == $data['children_name']) {
                if ($data['image'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['video'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['quiz'] == 'yes') {
                    $tempPoint += 1;
                }

                if ($data['zoom'] == 'yes') {
                    $tempPoint += 1;
                }

                $tempDataPoint[$data['children_name']] = [
                    'data_anak' => $data,
                    'point_anak' => $tempPoint
                ];
            }
        }

        foreach ($tempDataPoint as $dataPoint) {
            $finalData[] = [
                'children_id'     => $dataPoint['data_anak']['children_id'],
                'point'             => $dataPoint['point_anak']
            ];
        }
        $this->db->query("DELETE FROM `temp`");

        foreach ($finalData as $fData) {
            $this->tempModel->save([
                'children_id' => $fData['children_id'],
                'point'       => $fData['point']
            ]);
        }

        if ($type == 'semuaKelas') {
            $this->semuaKelas($nama_cabang);
        } elseif ($type == 'pembagian') {
            $this->pembagian($nama_cabang);
        } else {
            $this->semuaKelas($nama_cabang, $type);
        }
    }

    public function dateToTanggal($date)
    {
        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


        $exploded = explode(' ', $date);
        $date_month = $exploded[0];
        $monthly = $exploded[1];
        $year = $exploded[2];
        for ($i = 0; $i < count($bulan); $i++) {
            if ($monthly == $bulan[$i]) {
                return $date_month . ' ' . $month[$i] . ' ' . $year;
            }
        }
    }

    public function getKelas($start, $end, $cabang = null)
    {
        if ($cabang == null) {
            $cabang = $this->userRegion;
        }

        $data = $this->absensiModel
            ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->join('childrens', 'childrens.id_children = absensis.children_id')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->where('region_pembimbing', $cabang)
            ->findAll();

        $selectedData = [];

        $start = strtotime($start);
        $end = strtotime($end);

        foreach ($data as $d) {
            $thisTime = strtotime($this->dateToTanggal($d['sunday_date']));
            if ($thisTime >= $start && $thisTime <= $end) {
                $selectedData[] = $d;
            }
        }

        $kelas = [];

        foreach ($selectedData as $data) {
            $kelas[] = $data['nama_kelas'];
        }

        $kelas = array_unique($kelas);

        return json_encode($kelas);
    }

    public function getMonthAbsensi($cabang, $year)
    {
        $data = $this->absensiModel
            ->join('pembimbings', 'pembimbings.id_pembimbing = absensis.pembimbing_id')
            ->where('year', $year)
            ->where('region_pembimbing', $cabang)
            ->findAll();
        $bulan = [];

        foreach ($data as $d) {
            $bulan[] = $d['month'];
        }

        $bulan = array_unique($bulan);
        dd($bulan);
        return json_encode($bulan);
    }

    public function semuaKelas($nama_cabang, $type = null)
    {
        $spredsheet = new Spreadsheet();
        $sheet = $spredsheet->getActiveSheet();

        //// disini 

        $data = $this->tempModel
            ->join('childrens', 'childrens.id_children = temp.children_id')
            ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->orderBy('point', 'DESC')
            ->findALl();

        $orderedData = [];

        foreach ($data as $d) {
            $orderedData[] = [
                'children_name'     => $d['children_name'],
                'pembimbing_name'   => $d['name_pembimbing'],
                'kelas'             => $d['nama_kelas'],
                'point'             => $d['point'],
            ];
        }

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Anak');
        $sheet->setCellValue('C1', 'Nama Pembimbing');
        $sheet->setCellValue('D1', 'Kelas Anak');
        $sheet->setCellValue('E1', 'Point');

        $index = 2;
        $no = 1;
        foreach ($orderedData as $data) {
            $sheet->setCellValue('A' . $index, $no++);
            $sheet->setCellValue('B' . $index, $data['children_name']);
            $sheet->setCellValue('C' . $index, $data['pembimbing_name']);
            $sheet->setCellValue('D' . $index, $data['kelas']);
            $sheet->setCellValue('E' . $index, $data['point']);
            $index++;
        }

        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(30);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(15);

        $spredsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spredsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(9);

        $writter = new Xlsx($spredsheet);

        $filename = '';

        if ($type == 'costum') {
            $filename = "Ranking Report Keseluruhan $nama_cabang $type";
        } else {
            $filename = "Ranking Report Keseluruhan $nama_cabang";
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writter->save('php://output');

        return redirect()->to('rank');
    }

    public function pembagian($nama_cabang)
    {
        $spredsheet = new Spreadsheet();
        $sheet = $spredsheet->getActiveSheet();
        $dataKelas = [];
        $data = $this->tempModel
            ->join('childrens', 'childrens.id_children = temp.children_id')
            ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
            ->join('kelas', 'kelas.id_class = childrens.role')
            ->orderBy('point', 'DESC')
            ->findALl();

        $tempKelas = '';
        foreach ($data as $d) {
            if ($tempKelas != $d['nama_kelas']) {
                $tempKelas = $d['nama_kelas'];
                $dataKelas[$d['nama_kelas']][] = $d;
            } else {
                $dataKelas[$d['nama_kelas']][] = $d;
            }
        }

        $index = 1;
        $no = 1;
        foreach ($dataKelas as $key => $value) {
            $spredsheet->getActiveSheet()->mergeCells('A' . $index . ':D' . $index . '');
            $sheet->setCellValue('A' . $index, 'Anak Kelas ' . $key);
            $spredsheet->getActiveSheet()->getStyle('A' . $index)->getFont()->setBold(9);
            $index++;
            $sheet->setCellValue('A' . $index . '', 'No');
            $sheet->setCellValue('B' . $index . '', 'Nama Anak');
            $sheet->setCellValue('C' . $index . '', 'Nama Pembimbing');
            $sheet->setCellValue('D' . $index . '', 'Point');
            $spredsheet->getActiveSheet()->getStyle('A' . $index . ':' . 'D' . $index)->getFont()->setBold(9);

            foreach ($value as $val) {
                $index++;
                $sheet->setCellValue('A' . $index . '', $no++);
                $sheet->setCellValue('B' . $index . '', $val['children_name']);
                $sheet->setCellValue('C' . $index . '', $val['name_pembimbing']);
                $sheet->setCellValue('D' . $index . '', $val['point']);
            }
            $index++;
            $sheet->setCellValue('A' . $index . '', '');
            $sheet->setCellValue('B' . $index . '', '');
            $sheet->setCellValue('C' . $index . '', '');
            $sheet->setCellValue('D' . $index . '', '');
            $index++;
            $no = 1;
        }
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25);
        $spredsheet->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15);

        $spredsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $writter = new Xlsx($spredsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Ranking Report Per Kelas ' . $nama_cabang . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writter->save('php://output');

        return redirect()->to('rank');
    }
}
