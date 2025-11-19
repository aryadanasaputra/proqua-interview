<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;
use App\Controllers\BaseController;

class Pendaftaran extends BaseController {
  protected $pendaftaranModel;
  protected $pasienModel;

  public function __construct(){
    $this->pendaftaranModel = model(PendaftaranModel::class);
    $this->pasienModel = model(PasienModel::class);
  }

  public function index(){
    $viewData['pendaftarans'] = $pendaftarans = $this->pendaftaranModel
    ->join('pasien','pasien.id = pasienid','left')
    ->select([
      'pendaftaran.id',
      'pendaftaran.pasienid',
      'pendaftaran.noregistrasi',
      'pendaftaran.tglregistrasi',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->findAll();
    $viewData['pasiens'] = $this->pasienModel->findAll();
    return $this->view('pendaftaran/view_pendaftaran', $viewData);
  }

  public function save(){
    $id = $this->request->getPost('id');
    $id = $id ?: null;
    $pasienid = $this->request->getPost('pasienid');
    $noregistrasi = $this->request->getPost('noregistrasi');
    $tglregistrasi = !empty($tglregistrasi = $this->request->getPost('tglregistrasi')) ? $this->template->formatDate($tglregistrasi,'Y-m-d H:i') : null;
    $data = [
      'pasienid' => $pasienid,
      'noregistrasi' => $noregistrasi,
      'tglregistrasi' => $tglregistrasi,
    ];
    if($id){
      $data['id'] = $id;
      $save = $this->pendaftaranModel->save($data);
    }else{
      $save = $this->pendaftaranModel->save($data);
    }
    if($save){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal"]);
    }
  }

  public function getData($id){
    $pendaftaran = $this->pendaftaranModel->find($id);
    if(empty($pendaftaran)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    return $this->response->setJSON(["result"=>1,"pendaftaran"=>$pendaftaran]);
  }
  
  public function delete($id){
    $delete = $this->pendaftaranModel->delete($id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }

  public function detailModal($id){
    $viewData['pendaftaran'] = $pendaftaran = $this->pendaftaranModel
    ->join('pasien','pasien.id = pasienid','left')
    ->select([
      'pendaftaran.id',
      'pendaftaran.pasienid',
      'pendaftaran.noregistrasi',
      'pendaftaran.tglregistrasi',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->find($id);
    if(empty($pendaftaran)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    $html = $this->view('pendaftaran/view_pendaftaran_modal_detail', $viewData);
    return $this->response->setJSON(["result"=>1,"html"=>$html]);
  }
}