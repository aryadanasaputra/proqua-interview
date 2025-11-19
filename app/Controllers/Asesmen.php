<?php

namespace App\Controllers;

use App\Models\AsesmenModel;
use App\Models\KunjunganModel;
use App\Controllers\BaseController;

class Asesmen extends BaseController {
  protected $asesmenModel;
  protected $kunjunganModel;

  public function __construct(){
    $this->asesmenModel = model(AsesmenModel::class);
    $this->kunjunganModel = model(KunjunganModel::class);
  }

  public function index(){
    $viewData['asesmens'] = $asesmens = $this->asesmenModel
    ->join('kunjungan','kunjungan.id = kunjunganid','left')
    ->join('pendaftaran','pendaftaran.id = kunjungan.pendaftaranpasienid','left')
    ->join('pasien','pasien.id = pendaftaran.pasienid','left')
    ->select([
      'asesmen.id',
      'asesmen.kunjunganid',
      'asesmen.keluhan_utama',
      'asesmen.keluhan_tambahan',
      'kunjungan.tglkunjungan kunjungan_tglkunjungan',
      'kunjungan.jeniskunjungan kunjungan_jeniskunjungan',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->findAll();
    $viewData['kunjungans'] = $this->kunjunganModel
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
    return $this->view('asesmen/view_asesmen', $viewData);
  }

  public function save(){
    $id = $this->request->getPost('id');
    $id = $id ?: null;
    $kunjunganid = $this->request->getPost('kunjunganid');
    $keluhanUtama = $this->request->getPost('keluhan_utama');
    $keluhanTambahan = $this->request->getPost('keluhan_tambahan');
    $data = [
      'kunjunganid' => $kunjunganid,
      'keluhan_utama' => $keluhanUtama,
      'keluhan_tambahan' => $keluhanTambahan,
    ];
    if($id){
      $data['id'] = $id;
      $save = $this->asesmenModel->save($data);
    }else{
      $save = $this->asesmenModel->save($data);
    }
    if($save){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal"]);
    }
  }

  public function getData($id){
    $asesmen = $this->asesmenModel->find($id);
    if(empty($asesmen)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    return $this->response->setJSON(["result"=>1,"asesmen"=>$asesmen]);
  }
  
  public function delete($id){
    $delete = $this->asesmenModel->delete($id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }

  public function detailModal($id){
    $viewData['asesmen'] = $asesmen = $this->asesmenModel
    ->join('kunjungan','kunjungan.id = kunjunganid','left')
    ->join('pendaftaran','pendaftaran.id = kunjungan.pendaftaranpasienid','left')
    ->join('pasien','pasien.id = pendaftaran.pasienid','left')
    ->select([
      'asesmen.id',
      'asesmen.kunjunganid',
      'asesmen.keluhan_utama',
      'asesmen.keluhan_tambahan',
      'kunjungan.jeniskunjungan kunjungan_jeniskunjungan',
      'kunjungan.tglkunjungan kunjungan_tglkunjungan',
      'pendaftaran.pasienid pendaftaran_pasienid',
      'pendaftaran.noregistrasi pendaftaran_noregistrasi',
      'pendaftaran.tglregistrasi pendaftaran_tglregistrasi',
      'pasien.nama pasien_nama',
      'pasien.norm pasien_norm',
    ])
    ->find($id);
    if(empty($asesmen)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    $html = $this->view('asesmen/view_asesmen_modal_detail', $viewData);
    return $this->response->setJSON(["result"=>1,"html"=>$html]);
  }
}