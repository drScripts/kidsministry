<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembimbingsModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PembimbingController extends BaseController
{

    protected $pembimbing_model;

    public function __construct()
    {
        $this->pembimbing_model = new PembimbingsModel();
    }

    public function index()
    {
        // mengambil penghitungan data
        $current_page = $this->request->getVar('page_pembimbing') ? $this->request->getVar('page_pembimbing') : 1;
        if (!in_groups('pusat')) {
            $pembimbings = $this->pembimbing_model->where('region_pembimbing', user()->toArray()['region'])->paginate(7, 'pembimbing');


            $pager = $this->pembimbing_model->pager;

            $data = [
                'title'        => 'Pembimbing',
                'pembimbings'  => $pembimbings,
                'pager'        => $pager,
                'current_page' => $current_page,
            ];
        } else {
            $cabang = [];

            $data = $this->pembimbing_model->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->findAll();
            $pembimbings = $this->pembimbing_model->join('cabang', 'cabang.id_cabang = pembimbings.region_pembimbing')->orderby('nama_cabang', 'ASC')->paginate(7, 'pembimbing');

            foreach ($data as $pembimbing) {
                $cabang[] = $pembimbing['nama_cabang'];
            }

            $cabang = array_unique($cabang);

            $pager = $this->pembimbing_model->pager;

            $data = [
                'title'        => 'Pembimbing',
                'pembimbings'  => $pembimbings,
                'pager'        => $pager,
                'cabangs'      => $cabang,
                'current_page' => $current_page,
            ];
        }


        return view('dashboard/pembimbing/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Pembimbing',
            'validation' => \Config\Services::validation(),
        ];
        return view('dashboard/pembimbing/add', $data);
    }

    public function insert()
    {
        $validate = $this->validate([
            'pembimbing_name' => [
                'rules'     => 'required|is_unique[pembimbings.name_pembimbing]|max_length[255]',
                'errors'    => [
                    'required'  => 'Please Insert Pembimbing Name !',
                    'is_unique' => "Pembimbing Already Exists Please Check The Name Correctly !",
                ],
            ],
        ]);

        if (!$validate) {
            return redirect()->to('/pembimbing/add')->withInput();
        }

        $this->pembimbing_model->save([
            'name_pembimbing'   => $this->request->getVar('pembimbing_name'),
            'region_pembimbing' => $this->region,
        ]);
        session()->setFlashData('success_add', 'Pembimbing Successfully Added !');
        return redirect()->to('/pembimbing');
    }

    public function delete($id)
    {
        $this->pembimbing_model->delete($id);
        session()->setFlashData('success_delete', 'Pembimbing Data Successfully Deleted !');
        return redirect()->to('/pembimbing');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pembimbing',
            'id'    => $id,
            'pembimbing'    => $this->pembimbing_model->find($id),
            'validation'    => \Config\Services::validation(),
        ];

        return view('dashboard/pembimbing/edit', $data);
    }

    public function update($id)
    {
        $validate = $this->validate([
            'pembimbing_name' => [
                'rules'     => 'required|string|is_unique[pembimbings.name_pembimbing,id_pembimbing,' . $id . ']',
                'errors'    => [
                    'is_unique' => 'Children Name Already Exists Please Check The Input Correctly',
                    'required'  => 'Please Input Pembimbing Name',
                ],
            ],
        ]);

        if (!$validate) {
            return redirect()->to('/pembimbing/edit/' . $id)->withInput();
        }

        $this->pembimbing_model->save([
            'id_pembimbing'     => $id,
            'name_pembimbing'   => $this->request->getVar('pembimbing_name'),
        ]);

        session()->setFlashData('success_update', 'Pembimbing Data Successfully Updated');
        return redirect()->to('/pembimbing');
    }

    public function searchPembimbings()
    {
        $pembimbings = $this->pembimbing_model->getPembimbings();
        $data = $pembimbings->get()->getResultArray();
        return json_encode($data);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $pembimbings = $this->pembimbing_model->getPembimbings()->get()->getResultArray();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Pembimbing Name');

        $index = 2;
        $no = 1;
        foreach ($pembimbings as $pembimbing) {
            $sheet->setCellValue("A$index", $no++);
            $sheet->setCellValue("B$index", $pembimbing['name_pembimbing']);
            $index++;
        }
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);

        $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(9);

        $writter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Daftar Pembimbing ' . user()->toArray()['region'] . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writter->save('php://output');
        die;
    }
}
