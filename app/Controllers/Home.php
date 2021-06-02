<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Home extends BaseController
{ 

	protected $absensiModel;
	public function __construct()
	{
		$this->absensiModel = new AbsensiModel();
	}

	public function dashboard(){
		$date = date('Y');
		$region = user()->toArray()['region'];
		
		$datas = $this->absensiModel->join('pembimbings', "pembimbings.id_pembimbing = absensis.pembimbing_id")->where('region_pembimbing',$region)->where('year',$date)->get()->getResultArray();

		$month = []; 

		foreach ($datas as $data) {
			$month[] = $data['month']; 
		}

		$data = [
			'month' => array_unique($month),
			'title' => 'Home Dashboard',
		];

		return view('dashboard/index', $data);
	}

	public function getChartWeek($month){
		
		$date = date('Y');
		$region = user()->toArray()['region'];
		
		$datas = $this->absensiModel->join('pembimbings', "pembimbings.id_pembimbing = absensis.pembimbing_id")->where('region_pembimbing',$region)->where('year',$date)->where('month',$month)->get()->getResultArray();
		
 
		$week = [];

		foreach ($datas as $w) {
			$week[] = $w['sunday_date'];
		}

		$fixed_week = array_unique($week);

		$data = [];

		foreach ($fixed_week as $f) {
			$data_temp = $this->absensiModel->join('pembimbings', "pembimbings.id_pembimbing = absensis.pembimbing_id")->where('region_pembimbing',$region)->where('sunday_date',$f)->countAllResults();

			if($data_temp != 0){
				$data[] =[
					'week'	 => $f,
					'jumlah' => $data_temp,
				];
			}
		}

		return json_encode($data);

	}
}
