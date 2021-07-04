<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\ChildrenModel;
use App\Models\ClassModel;
use App\Models\PembimbingsModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ChildrenController extends BaseController
{

    protected $childrenModel;
    protected $pembimbingModel;
    protected $cabangModel;
    protected $classModel;

    public function __construct()
    {
        $this->childrenModel = new ChildrenModel();
        $this->pembimbingModel = new PembimbingsModel();
        $this->cabangModel = new CabangModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {

        // mengambil penghitungan data
        $current_page = $this->request->getVar('page_children') ? $this->request->getVar('page_children') : 1;
        $class = $this->classModel->findAll();
        if (!in_groups('pusat')) {

            // konek to database withh model 
            $children_pageinate = $this->childrenModel->getChildren()->findAll();
            // $children_pageinate = $this->childrenModel->getChildren()->paginate(7, 'children');
            // $pager = $this->childrenModel->pager;

            $data = [
                'title'         => "Children's",
                // 'pager'         => $pager,
                'childrens'     => $children_pageinate,
                'current_page'  => $current_page,
                'class'         => $class,
            ];
        } else {
            $cabangs = $this->childrenModel->getPusatChildren()->select('nama_cabang')->get()->getResultArray();
            $cabang = [];

            foreach ($cabangs as $c) {
                $cabang[] = $c['nama_cabang'];
            }


            $children_pageinate = $this->childrenModel->getPusatChildren()->paginate(7, 'children');
            $pager = $this->childrenModel->pager;

            $data = [
                'title'         => "Children's",
                'pager'         => $pager,
                'childrens'     => $children_pageinate,
                'current_page'  => $current_page,
                'cabangs'       => array_unique($cabang),
                'class'         => $class,
            ];
        }


        return view('dashboard/children/children', $data);
    }

    public function getChildren()
    {
        $children =  $this->childrenModel->searchChildren();
        $dataChildren = $children->get()->getResultArray();
        return json_encode($dataChildren);
    }

    public function addChildren()
    {

        $dataPembimbing = $this->pembimbingModel->where('region_pembimbing', $this->region)->get()->getResultArray();

        $kelas = $this->classModel->findAll();
        $validation = \Config\Services::validation();
        $data = [
            'title'       => "Add Children",
            'pembimbings' => $dataPembimbing,
            'validation'  => $validation,
            'class'       => $kelas,
        ];

        return view('dashboard/children/add_children', $data);
    }

    public function insert()
    {
        $validate =  $this->validate([
            'children_name' => [
                'rules'     => 'string|required|max_length[255]',
                'errors'    => [
                    'required'  => 'Please Insert The Children Name !',
                    'is_unique' => 'The Children Name Already Exist Please Check The Name Correctly !'
                ],
            ],
            'code'          => [
                'rules'     => 'string|required|max_length[10]',
                'errors'    => [
                    'required'      => 'Please Insert The Children Code !',
                    'is_unique'     => 'The Children Code Already Exist Please Check The Code Correctly !',
                    'max_length'    => 'The Children Code Max Length 10 Please Check The Code !',
                ],
            ],
            'role'          => [
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'Please Select The Children Role !'
                ],
            ],
            'pembimbing'    => [
                'rules'     => 'string|required',
                'errors'    => [
                    'required'  => 'Please Select The Children Pembimbing !'
                ]
            ],
            'tgllhr'    => [
                'rules'     => 'required|valid_date[Y-m-d]',
                'errors'    => [
                    'valid_date'    => 'Date Must Be Valid Date',
                    'required'      => 'Please Select The Children Birth Day !'
                ]
            ],
        ]);

        if (!$validate) {
            return redirect()->to('/children/add')->withInput();
        };
        $this->childrenModel->save([
            'children_name' => $this->request->getVar('children_name'),
            'code'          => $this->request->getVar('code'),
            'id_pembimbing' => $this->request->getVar('pembimbing'),
            'role'          => $this->request->getVar('role'),
            'tanggal_lahir' => $this->request->getVar('tgllhr'),
            'created_by'    => user()->toArray()['id'],
        ]);

        session()->setFlashData('success_add', 'Children Success Fully Added');
        return redirect()->to('/children');
    }

    public function delete($id)
    {
        $this->childrenModel->update($id, [
            'deleted_by'    => user()->toArray()['id'],
        ]);
        $this->childrenModel->delete($id);
        session()->setFlashData('success_deleted', 'Children Success Fully Deleted');
        return redirect()->to('/children');
    }

    public function edit($id)
    {
        // get current Children Data
        $children = $this->childrenModel->join('kelas', 'kelas.id_class = childrens.role')->find($id);

        // get Current Children Pembimbing Data
        $id_pembimbing = $children['id_pembimbing'];
        $current_pebimbing = $this->pembimbingModel->find($id_pembimbing);

        // get All Pembimbing Data
        $pembimbings = $this->pembimbingModel->getPembimbings()->get()->getResultArray();

        // get All Class Data
        $kelas = $this->classModel->findAll();
        $data = [
            'title'                 => 'Edit Children',
            'id'                    => $id,
            'current_children'      => $children,
            'current_pembimbing'    => $current_pebimbing,
            'pembimbings'           => $pembimbings,
            'validation'            => \Config\Services::validation(),
            'class'                 => $kelas,
        ];

        return view('dashboard/children/edit_children', $data);
    }

    public function update($id)
    {

        $validate =  $this->validate([
            'children_name' => [
                'rules'     => 'string|required|is_unique[childrens.children_name,id_children,' . $id . ']|max_length[255]',
                'errors'    => [
                    'required'  => 'Please Insert The Children Name !',
                    'is_unique' => 'The Children Name Already Exist Please Check The Name Correctly !'
                ],
            ],
            'code'          => [
                'rules'     => 'string|required|is_unique[childrens.code,id_children,' . $id . ']|max_length[10]',
                'errors'    => [
                    'required'      => 'Please Insert The Children Code !',
                    'is_unique'     => 'The Children Code Already Exist Please Check The Code Correctly !',
                    'max_length'    => 'The Children Code Max Length 10 Please Check The Code !',
                ],
            ],
            'role'          => [
                'rules'     => 'required',
                'errors'    => [
                    'required'  => 'Please Select The Children Role !'
                ],
            ],
            'pembimbing'    => [
                'rules'     => 'string|required',
                'errors'    => [
                    'required'  => 'Please Select The Children Pembimbing !'
                ]
            ],
            'tgllhr'    => [
                'rules'     => 'required|valid_date[Y-m-d]',
                'errors'    => [
                    'valid_date'    => 'Date Must Be Valid Date',
                    'required'      => 'Please Select The Children Birth Day !'
                ]
            ],
        ]);

        if (!$validate) {
            return redirect()->to('/children/edit/' . $id)->withInput();
        };
        $this->childrenModel->save([
            'id_children'   => $id,
            'children_name' => $this->request->getVar('children_name'),
            'code'          => $this->request->getVar('code'),
            'id_pembimbing' => $this->request->getVar('pembimbing'),
            'role'          => $this->request->getVar('role'),
            'tanggal_lahir' => $this->request->getVar('tgllhr'),
            'updated_by'    => user()->toArray()['id'],
        ]);
        session()->setFlashData('success_update', 'Children Data Successfully Updated');
        return redirect()->to('/children');
    }

    public function export()
    {
        $spredsheet = new Spreadsheet();
        $sheet = $spredsheet->getActiveSheet();

        $arrChildren = $this->childrenModel->getChildren()->get()->getResultArray();

        $sheet->setCellValue('A1', 'Nama Anak');
        $sheet->setCellValue('B1', 'Code Anak');
        $sheet->setCellValue('C1', 'Role/Kelas');
        $sheet->setCellValue('D1', 'Nama Pembimbing');
        $sheet->setCellValue('E1', 'Tanggal Lahir (Tahun-Bulan-Tanggal)');

        $index = 2;
        foreach ($arrChildren as $children) {
            $sheet->setCellValue('A' . $index, $children['children_name']);
            $sheet->setCellValue('B' . $index, $children['code']);
            $sheet->setCellValue('C' . $index, $children['nama_kelas']);
            $sheet->setCellValue('D' . $index, $children['name_pembimbing']);
            $sheet->setCellValue('E' . $index, $children['tanggal_lahir'] == null ? "Belum Ditambahkan" : $children['tanggal_lahir']);
            $index++;
        }

        $spredsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $spredsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spredsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $spredsheet->getActiveSheet()->getColumnDimension('E')->setWidth(35);

        $spredsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spredsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(9);

        $writter = IOFactory::createWriter($spredsheet, 'Xlsx');

        $getCabangName = $this->cabangModel->getCabang(user()->toArray()['region'])['nama_cabang'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Daftar Anak ' . $getCabangName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writter->save('php://output');
        die;
    }

    public function addClass()
    {

        $data = [
            'title' => 'Add Children Class',
            'validation'    => \Config\Services::validation(),
        ];

        return view('dashboard/children/addClass', $data);
    }

    public function attemptClass()
    {

        $validate = $this->validate([
            'class_name' => [
                'rules'     => 'required|max_length[255]',
                'errors'    => [
                    'required'      => 'Please Insert Class Name !',
                    'max_length'    => 'Please Inser Class Name Max 255 length'
                ],
            ],
        ]);



        if (!$validate) {
            return redirect()->to('/pembimbing/add')->withInput();
        }

        $class_name = $this->request->getVar()['class_name'];

        $adding = $this->classModel->save([
            'nama_kelas'    => $class_name,
        ]);

        if ($adding) {
            session()->setFlashData('success_add', 'Class Successfully Added !');
            return redirect()->to('/children/addClass');
        }
    }

    public function addExcel()
    {
        return view('dashboard/children/import');
    }

    public function import()
    {

        $file_upload = $this->request->getFile('excel');

        // move file
        $file_upload->move('temp_excel');

        // mengambil nama
        $file_name = $file_upload->getName();

        // path file name
        $path_file = "../public/temp_excel/$file_name";
        $inputType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path_file);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputType);
        $spreadSheet = $reader->load($path_file);

        $data = $spreadSheet->getActiveSheet()->toArray();
        unlink($path_file);

        if ($data[0][0] != 'Nama Anak' || $data[0][1] != 'Code Anak' || $data[0][2] != 'Role/Kelas' || $data[0][3] != 'Nama Pembimbing') {
            session()->setFlashData('failed_import', 'Gagal Import Data Pastikan File Sesuai Dengan Ketentuan atau Template');
            return redirect()->to('/children');
        }

        $data = array_slice($data, 1, count($data) - 1);

        $data_clear = [];
        foreach ($data as $d) {
            if ($d[0] != ' ' || $d[0] != null) {
                $data_clear[] = $d;
            }
        }
        // upload database 
        $childrenArr = [];

        $nama_pembimbing = [];
        $data_pembimbing = [];

        foreach ($data_clear as $datak) {

            if ($datak[0] == null && $datak[1] == null && $datak[2] == null && $datak[3] == null) {
                continue;
            }
            $nama = trim(ucwords($datak[0]));
            $code = $datak[1] != null ? trim(strtoupper($datak[1])) : '-';
            $role = trim(ucwords($datak[2]));
            $pembimbing_name = trim(ucwords($datak[3]));
            $ultah = $datak[4] == null ? null : date('Y-m-d', strtotime($datak[4]));

            $nama_pembimbing[] = $pembimbing_name;

            $temp_arr = [
                'nama' => $nama,
                'code' => $code,
                'role' => $role,
                'pembimbing_name' => trim($pembimbing_name),
                'ultah'             => $ultah,
            ];

            $childrenArr[] = $temp_arr;
        }


        $kelas = $this->classModel->findAll();
        $fault = 0;
        foreach ($childrenArr as $temp) {
            foreach ($kelas as $k) {
                if ($temp['role'] == $k['nama_kelas']) {
                    $fault++;
                }
            }
        }

        if ($fault != count($childrenArr)) {
            session()->setFlashData('failed_import', 'Gagal Import Data Pastikan Kelas Sesuai dengan yang tersedia');
            return redirect()->to('/children/import');
        }

        $nama_pembimbing = array_unique($nama_pembimbing);

        foreach ($nama_pembimbing as $pembimbing) {
            $data = $this->pembimbingModel
                ->where('region_pembimbing', $this->region)
                ->where('name_pembimbing', $pembimbing)->first();

            if ($data != null) {
                $pembimbing_id = $data['id_pembimbing'];
            } else {
                $this->pembimbingModel->save([
                    'name_pembimbing'       => $pembimbing,
                    'region_pembimbing'     => user()->toArray()['region'],
                ]);

                $pembimbing_id = $this->pembimbingModel->getInsertID();
            }

            $data_pembimbing[$pembimbing] = $pembimbing_id;
        }


        foreach ($childrenArr as $child) {
            $children = $this->childrenModel
                ->join('pembimbings', 'pembimbings.id_pembimbing = childrens.id_pembimbing')
                ->where('children_name', $child['nama'])
                ->where('region_pembimbing', $this->region)
                ->first();

            $id_pembimbing = '';
            $class = $this->classModel->where('nama_kelas', $child['role'])->first()['id_class'];
            foreach ($data_pembimbing as $key => $value) {
                if ($key == $child['pembimbing_name']) {
                    $id_pembimbing = $value;
                }
            }

            if ($children == null) {
                $this->childrenModel->save([
                    'children_name' => $child['nama'],
                    'code'          => $child['code'],
                    'id_pembimbing' => $id_pembimbing,
                    'role'          => $class,
                    'tanggal_lahir' => $child['ultah'],
                    'created_by'    => user()->toArray()['id'],
                ]);
            } else {
                $this->childrenModel->update($children['id_children'], [
                    'children_name' => $child['nama'],
                    'code'          => $child['code'],
                    'id_pembimbing' => $id_pembimbing,
                    'role'          => $class,
                    'tanggal_lahir' => $child['ultah'],
                    'updated_by'    => user()->toArray()['id'],
                ]);
            }
        }
        session()->setFlashData('success_import', 'Success Fully Add Children Data');
        return redirect()->to('/children');
    }
}
