<?php

namespace App\Controllers;

use App\Models\KunjunganModel;
use App\Models\PendaftaranModel;
use App\Controllers\BaseController;

class Kunjungan extends BaseController {
  protected $kunjunganModel;
  protected $pendaftaranModel;
  protected $jeniskunjunganOpts = [
    ['value' => 'baru', 'label' => 'Pasien Baru'],
    ['value' => 'lama', 'label' => 'Pasien Lama'],
  ];

  public function __construct(){
    $this->kunjunganModel = model(KunjunganModel::class);
    $this->pendaftaranModel = model(PendaftaranModel::class);
  }

  public function index(){
    $viewData['kunjungans'] = $kunjungans = $this->kunjunganModel
    ->join('pendaftaran','pendaftaran.id = pendaftaranpasienid','left')
    ->join('pasien','pasien.id = pendaftaran.pasienid','left')
    ->select([
      'kunjungan.id',
      'kunjungan.pendaftaranpasienid',
      'kunjungan.jeniskunjungan',
      'kunjungan.tglkunjungan',
      'pendaftaran.pasienid pendaftaran_pasienid',
      'pendaftaran.noregistrasi pendaftaran_noregistrasi',
      'pendaftaran.tglregistrasi pendaftaran_tglregistrasi',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->findAll();
    $viewData['jeniskunjunganOpts'] = $this->jeniskunjunganOpts;
    $viewData['pendaftarans'] = $this->pendaftaranModel
    ->join('pasien','pasien.id = pendaftaran.pasienid','left')
    ->select([
      'pendaftaran.*',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->findAll();
    return $this->view('kunjungan/view_kunjungan', $viewData);
  }

  public function save(){
    $id = $this->request->getPost('id');
    $id = $id ?: null;
    $pendaftaranpasienid = $this->request->getPost('pendaftaranpasienid');
    $jeniskunjungan = $this->request->getPost('jeniskunjungan');
    $tglkunjungan = !empty($tglkunjungan = $this->request->getPost('tglkunjungan')) ? $this->template->formatDate($tglkunjungan,'Y-m-d H:i') : null;
    $data = [
      'pendaftaranpasienid' => $pendaftaranpasienid,
      'jeniskunjungan' => $jeniskunjungan,
      'tglkunjungan' => $tglkunjungan,
    ];
    if($id){
      $data['id'] = $id;
      $save = $this->kunjunganModel->save($data);
    }else{
      $save = $this->kunjunganModel->save($data);
    }
    if($save){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal"]);
    }
  }

  public function getData($id){
    $kunjungan = $this->kunjunganModel->find($id);
    if(empty($kunjungan)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    return $this->response->setJSON(["result"=>1,"kunjungan"=>$kunjungan]);
  }
  
  public function delete($id){
    $delete = $this->kunjunganModel->delete($id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }

  public function detailModal($id){
    $viewData['kunjungan'] = $kunjungan = $this->kunjunganModel
    ->join('pendaftaran','pendaftaran.id = pendaftaranpasienid','left')
    ->join('pasien','pasien.id = pendaftaran.pasienid','left')
    ->select([
      'kunjungan.id',
      'kunjungan.pendaftaranpasienid',
      'kunjungan.jeniskunjungan',
      'kunjungan.tglkunjungan',
      'pendaftaran.pasienid pendaftaran_pasienid',
      'pendaftaran.noregistrasi pendaftaran_noregistrasi',
      'pendaftaran.tglregistrasi pendaftaran_tglregistrasi',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->find($id);
    if(empty($kunjungan)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    $html = $this->view('kunjungan/view_kunjungan_modal_detail', $viewData);
    return $this->response->setJSON(["result"=>1,"html"=>$html]);
  }
}