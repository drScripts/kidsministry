<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChildrenModel;
use App\Models\PembimbingsModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ChildrenController extends BaseController{
    
    protected $childrenModel;
    protected $pembimbingModel;
    
    public function __construct()
    {
        $this->childrenModel = new ChildrenModel();
        $this->pembimbingModel = new PembimbingsModel();
    }
    
    public function index(){     
        //// mendapatkan user login dengan user() (langsung aja)
         
        // konek to database withh model
        // $children_pageinate = $this->childrenModel->getChildren()->paginate(10,'children');
        $children_pageinate = $this->childrenModel->getChildren()->paginate(7,'children');
        $pager = $this->childrenModel->pager;
        
        // mengambil penghitungan data
        $current_page = $this->request->getVar('page_children') ? $this->request->getVar('page_children') : 1;
 
        $data = [
            'title'         => "Children's",
            'pager'         => $pager,
            'childrens'     => $children_pageinate,
            'current_page'  => $current_page,
        ];

        return view('dashboard/children/children', $data);
    }
 
    public function getChildren(){
        $children =  $this->childrenModel->searchChildren();
        $dataChildren = $children->get()->getResultArray(); 
        return json_encode($dataChildren);
    }

    public function addChildren(){
        $dataPembimbing = $this->pembimbingModel->where('region_pembimbing',user()->toArray()['region'])->get()->getResultArray();
        
        $validation = \Config\Services::validation(); 
        $data = [
            'title'       => "Add Children",
            'pembimbings' => $dataPembimbing, 
            'validation'  => $validation,
        ];

        return view('dashboard/children/add_children', $data);
    }

    public function insert(){  
        $validate =  $this->validate([
            'children_name' => [
                'rules'     => 'string|required|is_unique[childrens.children_name]|max_length[255]',
                'errors'    => [
                    'required'  => 'Please Insert The Children Name !',
                    'is_unique' => 'The Children Name Already Exist Please Check The Name Correctly !'
                ],
            ],
            'code'          => [
                'rules'     => 'string|required|is_unique[childrens.code]|max_length[10]',
                'errors'    => [
                    'required'      => 'Please Insert The Children Code !',
                    'is_unique'     => 'The Children Code Already Exist Please Check The Code Correctly !',
                    'max_length'    => 'The Children Code Max Length 10 Please Check The Code !',
                ],
            ],
            'role'          => [
                'rules'     => 'string|required',
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
        ]);

        if(!$validate){
            return redirect()->to('/children/add')->withInput();
        };

        $this->childrenModel->save([
            'children_name' => $this->request->getVar('children_name'),
            'code'          => $this->request->getVar('code'),
            'id_pembimbing' => $this->request->getVar('pembimbing'),
            'role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashData('success_add', 'Children Success Fully Added');
        return redirect()->to('/children');
    }

    public function delete($id){
 
        $this->childrenModel->delete($id);
        session()->setFlashData('success_deleted', 'Children Success Fully Deleted');
        return redirect()->to('/children');
    }

    public function edit($id){
        // get current Children Data
        $children = $this->childrenModel->find($id);

        // get Current Children Pembimbing Data
        $id_pembimbing = $children['id_pembimbing'];
        $current_pebimbing = $this->pembimbingModel->find($id_pembimbing);

        // get All Pembimbing Data
        $pembimbings = $this->pembimbingModel->getPembimbings()->get()->getResultArray();

        $data = [
            'title'                 => 'Edit Children',
            'id'                    => $id,
            'current_children'      => $children,
            'current_pembimbing'    => $current_pebimbing,
            'pembimbings'           => $pembimbings,
            'validation'            => \Config\Services::validation(),
        ];

        return view('dashboard/children/edit_children',$data);
    }

    public function update($id){ 

        $validate =  $this->validate([
            'children_name' => [
                'rules'     => 'string|required|is_unique[childrens.children_name,id_children,'.$id.']|max_length[255]',
                'errors'    => [
                    'required'  => 'Please Insert The Children Name !',
                    'is_unique' => 'The Children Name Already Exist Please Check The Name Correctly !'
                ],
            ],
            'code'          => [
                'rules'     => 'string|required|is_unique[childrens.code,id_children,'.$id.']|max_length[10]',
                'errors'    => [
                    'required'      => 'Please Insert The Children Code !',
                    'is_unique'     => 'The Children Code Already Exist Please Check The Code Correctly !',
                    'max_length'    => 'The Children Code Max Length 10 Please Check The Code !',
                ],
            ],
            'role'          => [
                'rules'     => 'string|required',
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
        ]);

        if(!$validate){
            return redirect()->to('/children/edit/' . $id)->withInput();
        };

        $this->childrenModel->save([
            'id_children'   => $id,
            'children_name' => $this->request->getVar('children_name'),
            'code'          => $this->request->getVar('code'),
            'id_pembimbing' => $this->request->getVar('pembimbing'),
            'role'          => $this->request->getVar('role'),
        ]);
        session()->setFlashData('success_update','Children Data Successfully Updated');
        return redirect()->to('/children');

    }

    public function import(){}

    public function export(){
        $spredsheet = new Spreadsheet();
        $sheet = $spredsheet->getActiveSheet();

        $arrChildren = $this->childrenModel->getChildren()->get()->getResultArray();

        $region = $arrChildren[0]['region_pembimbing'];

        $sheet->setCellValue('A1','Nama Anak');
        $sheet->setCellValue('B1','Code Anak');
        $sheet->setCellValue('C1','Role/Kelas');
        $sheet->setCellValue('D1','Nama Pembimbing');

        $index = 2;
        foreach ($arrChildren as $children) {
            $sheet->setCellValue('A'.$index,$children['children_name']);
            $sheet->setCellValue('B'.$index,$children['code']);
            $sheet->setCellValue('C'.$index,$children['role']);
            $sheet->setCellValue('D'.$index,$children['name_pembimbing']);
            $index++;
        }

        $spredsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $spredsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spredsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spredsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);

        $spredsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spredsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spredsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(9);

        $writer = new Xlsx($spredsheet);

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Daftar Anak '.$region.'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
    }
}