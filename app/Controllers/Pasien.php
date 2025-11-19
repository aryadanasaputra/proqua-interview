<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Controllers\BaseController;

class Pasien extends BaseController {
  protected $pasienModel;

  public function __construct(){
    $this->pasienModel = model(PasienModel::class);
  }

  public function index(){
    $viewData['pasiens'] = $pasiens = $this->pasienModel->findAll();
    return $this->view('pasien/view_pasien', $viewData);
  }

  public function save(){
    $id = $this->request->getPost('id');
    $id = $id ?: null;
    $nama = $this->request->getPost('nama');
    $norm = $this->request->getPost('norm');
    $alamat = $this->request->getPost('alamat');
    $data = [
      'nama' => $nama,
      'norm' => $norm,
      'alamat' => $alamat,
    ];
    if($id){
      $data['id'] = $id;
      $save = $this->pasienModel->save($data);
    }else{
      $save = $this->pasienModel->save($data);
    }
    if($save){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal"]);
    }
  }

  public function getData($id){
    $pasien = $this->pasienModel->find($id);
    if(empty($pasien)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    return $this->response->setJSON(["result"=>1,"pasien"=>$pasien]);
  }
  
  public function delete($id){
    $delete = $this->pasienModel->delete($id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }  

  public function importJson(){
    $file = $this->request->getFile('file');
    $json = file_get_contents($file->getTempName());
    $resDatas = json_decode($json, true);
    $datas = [];
    foreach($resDatas as $resData){
      $datas[] = [
        'nama' => $resData['name'] ?? "",
        'norm' => $resData['id'] ?? "",
        'alamat' => ($resData['address']['street'] ?? "")." ".($resData['address']['suite'] ?? "")." ".($resData['address']['city'] ?? "")." ".($resData['address']['zipcode'] ?? ""),
      ];
    }
    $insert = $this->pasienModel->insertBatch($datas);
    if($insert){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal"]);
    }
  }

  public function detailModal($id){
    $viewData['pasien'] = $pasien = $this->pasienModel->find($id);
    if(empty($pasien)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak valid !"]);
    }
    $html = $this->view('pasien/view_pasien_modal_detail', $viewData);
    return $this->response->setJSON(["result"=>1,"html"=>$html]);
  }
}