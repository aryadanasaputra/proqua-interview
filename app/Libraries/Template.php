<?php

namespace App\Libraries;

use Config\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Template{
  private $_services;
  
  public function __construct() {
    $this->_services = new Services();
  }

  function response(
    string $data,
    int $code=200
  ) : void {
    $this->_services::response()->setStatusCode($code)->setBody($data)->send();
    exit;
  }
  
  function saveBase64Image(
    string $base64Image,
    string $filePath
  ) {
    $image = str_replace(['data:image/png;base64,',' ','[removed]'], ['','+',''], $base64Image);
    $image = base64_decode($image);
    $directory = dirname($filePath);
    if(!is_dir($directory)){
      mkdir($directory, 0755, true);
    }
    file_put_contents($filePath, $image);
  }

  function rotateImage(
    string $filePath,
    float $angle
  ) {
    $source = imagecreatefromjpeg($filePath);
    $rotated = imagerotate($source, -$angle, 0);
    imagejpeg($rotated, $filePath);
    imagedestroy($source);
    imagedestroy($rotated);
  }

  function initialString(
    string $delimiter,
    string $string
  ) : string {
    $arrString = explode($delimiter, $string);
    $initial = implode("", array_map(function($el){ return substr(strtolower($el), 0, 1); }, $arrString));
    return $initial;
  }

  function randomColor() : string {
    $randColor = "#";
    for($i=0;$i<3;$i++){
      $randColor .= str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT);
    }
    return $randColor;
  }

  function createDate(string $date="") : string {
    date_default_timezone_set('Asia/Jakarta');
    if(empty($date)){
      $date = date("Y-m-d H:i:s");
    }else{
      $date = date_create($date);
    }
    return $date;
  }

  function getXChars(
    string $text,
    int $limit=18
  ) : string {
    $res = $text;
    if(strlen($text) > $limit){
      $res = substr($text,0,$limit)." ...";
    }
    return $res;
  }

  function getXWords(
    string $string,
    int $x=200
  ) : string {
    $parts = explode(' ',$string);
    if (sizeof($parts)>$x) {
      $parts = array_slice($parts,0,$x);
      $parts[] = " ...";
    }
    return implode(' ',$parts);
  }

  function print2pdf(
    $view,
    array $data=[]
  ) : void {
    $data['template'] = $this;
    $pdf = $data['pdf'] = new \TCPDF();
    $pdf->SetTitle($data['title'] ?? $_SERVER['REQUEST_URI']);
    $pdf->SetAuthor('');
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $fileName = $data['fileName'] ?? 'Cetak PDF.pdf';
    
    $orientation = $data['orientation'] ?? 'P'; /** paperSize = [Panjang,Lebar] dalam mm */
    $paperSize = $data['paperSize'] ?? 'A4';
    $marginLeft = $data['marginLeft'] ?? 10;
    $marginTop = $data['marginTop'] ?? 10;
    $marginRight = $data['marginRight'] ?? 10;
    $fontType = $data['fontType'] ?? 'dejavusans';
    $fontSize = $data['fontSize'] ?? 9;
    
    if(is_array($view)){
      foreach($view as $rView){
        if(isset($rView['view'])){
          $vOrientation = $rView['data']['orientation'] ?? $orientation;
          $vPaperSize = $rView['data']['paperSize'] ?? $paperSize;
          $vMarginLeft = $rView['data']['marginLeft'] ?? $marginLeft;
          $vMarginTop = $rView['data']['marginTop'] ?? $marginTop;
          $vMarginRight = $rView['data']['marginRight'] ?? $marginRight;
          $vFontType = $rView['data']['fontType'] ?? $fontType;
          $vFontSize = $rView['data']['fontSize'] ?? $fontSize;

          $pdf->AddPage($vOrientation,$vPaperSize);
          $pdf->SetMargins($vMarginLeft,$vMarginTop,$vMarginRight);
          $pdf->SetFont($vFontType, '', $vFontSize, '', 'false');

          $content = view($rView['view'], $data);
          $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
        }
      }
    }else{
      $pdf->AddPage($orientation,$paperSize);
      $pdf->SetMargins($marginLeft,$marginTop,$marginRight);
      // $pdf->SetFillColor(255,255,255);
      $pdf->SetFont($fontType, '', $fontSize, '', 'false');

      $content = view($view, $data);
      $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
    }
    // $js = 'print(true);';
    // $pdf->IncludeJS($js);
    $pdf->Output($fileName);
    exit;
  }

  function print2pdfInfiniteHeight(
    string $view,
    array $data=[]
  ) : void {
    $data['template'] = $this;
    $pdf = $data['pdf'] = new \TCPDF();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTitle($data['title'] ?? $_SERVER['REQUEST_URI']);
    $pdf->SetAuthor('');
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    
    $pdf->startTransaction();

    $width = $data['width'] ?? $pdf->getPageWidth(); /** dalam mm */
    $pdf->AddPage('P',[$width,19000]);
    $pdf->SetMargins(($data['marginLeft'] ?? 10),($data['marginTop'] ?? 10),($data['marginRight'] ?? 10),true);
    $pdf->SetFont(($data['fontType'] ?? 'dejavusans'), '', ($data['fontSize'] ?? 9), '', 'false');
    
    $content = view($view, $data);
    $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

    $pdf->getMargins();
    $newheight = $pdf->GetY();
    $newheight = $newheight < $width ? $width : $newheight;
    
    $pdf->rollbackTransaction(true);
    $pdf->SetMargins(($data['marginLeft'] ?? 10),($data['marginTop'] ?? 10),($data['marginRight'] ?? 10),true);
    $pdf->SetFont(($data['fontType'] ?? 'dejavusans'), '', ($data['fontSize'] ?? 9), '', 'false');
    $pdf->addPage('P', [$width, $newheight]);
    $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
    $pdf->commitTransaction();
    
    $pdf->Output($data['fileName'] ?? "Cetak PDF.pdf");
    exit;
  }

  function exportExcel(
    array $rowHeaders,
    array $rowDatas,
    string $filename,
    array $dataOptions=null,
    array $dataProperties=null,
  ) : void {
    $colRanges = [];
    $letter = 'A';
    while($letter !== 'CA'){
      $colRanges[] = $letter++;
    }
    if(!empty($rowHeaders)){
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
      $spreadsheet->getProperties()
        ->setCreator("")
        ->setLastModifiedBy("")
        ->setTitle("Data Export Excel");

      $sheet = $spreadsheet->getActiveSheet();
      $row=0;
      if($dataProperties){
        foreach($dataProperties as $varProperti=>$valProperti){
          $row++;
          $sheet->setCellValue("A".$row, $varProperti);
          $sheet->setCellValue("B".$row, $valProperti);
          $sheet->getStyle("B".$row)->getFont()->setBold(true);
        }
      }
      if($row > 0){
        $row++;
      }
      
      $headers = [];
      foreach($rowHeaders as $k=>$rowHeader){
        $headers[$colRanges[$k]] = $rowHeader;
      }

      $row++;
      foreach($headers as $k=>$header){
        $sheet->setCellValue($k.$row, $header);
        $sheet->getStyle($k.$row)->getFont()->setBold(true);
        $sheet->getColumnDimension($k)->setWidth(25);
      }
      
      foreach($rowDatas as $rowData){
        $row++;
        foreach($rowData as $k=>$objData){
          if(isset($dataOptions[$k]['is_string'])){
            $sheet->setCellValueExplicit($colRanges[$k].$row, $objData, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          }else{
            $sheet->setCellValue($colRanges[$k].$row, $objData);
          }
        }
      }

      $filename = urlencode($filename);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename='.$filename);
      header('Cache-Control: max-age=0');
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }
  
  function importExcel(
    $file,
    int $indexSheet=0
  ) : array {
    $reader = match(strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
      'csv' => new \PhpOffice\PhpSpreadsheet\Reader\Csv(),
      'xls' => new \PhpOffice\PhpSpreadsheet\Reader\Xls(),
      default => null
    };
    
    $spreadsheet = $reader ? $reader->load($file) : \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    
    if($indexSheet > 0) {
      $spreadsheet->setActiveSheetIndex($indexSheet);
    }
    $worksheet = $spreadsheet->getActiveSheet();
    $resDatas = [];
    foreach($worksheet->getRowIterator() as $i => $row){
      if($i == 1) continue;
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false);
      $data = [];
      foreach($cellIterator as $cell){
        $data[] = trim($cell->getValue());
      }
      if(!empty(array_filter($data))){
        $resDatas[] = $data;
      }
    }
    return $resDatas;
  }

  function logging(
    string $filePath="log.txt",
    string $message=""
  ) : void {
    $filePath = WRITEPATH.'logs/'.$filePath;
    file_put_contents($filePath, $message.PHP_EOL, FILE_APPEND);
  }

  function terbilang(int $nilai) : string {
    $terbilang = "";
    $terbilang = ($nilai < 0 ? "minus " : "");
    $nilai = abs($nilai);
    $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $terbilang .= match(true) {
      $nilai < 12 => " ".$huruf[$nilai],
      $nilai < 20 => $this->terbilang($nilai - 10)." belas ",
      $nilai < 100 => $this->terbilang($nilai/10)." puluh ".$this->terbilang($nilai % 10),
      $nilai < 200 => " seratus ".$this->terbilang($nilai - 100),
      $nilai < 1000 => $this->terbilang($nilai/100)." ratus ".$this->terbilang($nilai % 100),
      $nilai < 2000 => " seribu ".$this->terbilang($nilai - 1000),
      $nilai < 1000000 => $this->terbilang($nilai/1000)." ribu ".$this->terbilang($nilai % 1000),
      $nilai < 1000000000 => $this->terbilang($nilai/1000000)." juta ".$this->terbilang($nilai % 1000000),
      $nilai < 1000000000000 => $this->terbilang($nilai/1000000000)." miliar ".$this->terbilang(fmod($nilai,1000000000)),
      $nilai < 1000000000000000 => $this->terbilang($nilai/1000000000000)." triliun ".$this->terbilang(fmod($nilai,1000000000000)),
      $nilai < 1000000000000000000 => $this->terbilang($nilai/1000000000000000)." kuardriliun ".$this->terbilang(fmod($nilai,1000000000000000)),
      default => "",
    };
    return trim($terbilang);
  }

  public function removeUnexistFileFromDir(
    string $dirPath,
    array $filePathExists
  ) : bool {
    foreach(array_diff(scandir($dirPath), ['.', '..', 'index.html']) as $file){
      $file = $dirPath.$file;
      if(!in_array($file, $filePathExists)){
        @unlink($file);
      }
    }
    return true;
  }

  function formatDate(
    $date,
    string $format,
    string $modify = ""
  ) : string {
    $dateFormat = "";
    if(!empty($date)){
      if(strtotime('0000-00-00') != strtotime($date)){
        try {
          $dateObj = new \DateTime($date);
          if($modify){
            $dateObj->modify($modify);
          }
          $dateFormat = $dateObj->format($format);
        } catch (\Exception $e) {
          // Invalid date string, return empty
          $dateFormat = "";
        }
      }
    }
    return $dateFormat;
  }

  function getDateIndonesia(
    $date,
    string $format = "%j %m %y"
  ) : string {
    $dateId = "";
    if(!empty($date)){
      if(strtotime('0000-00-00') != strtotime($date)){
        $bulans = [1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"];
        $hari = [1=>"Senin",2=>"Selasa",3=>"Rabu",4=>"Kamis",5=>"Jum'at",6=>"Sabtu",7=>"Ahad"];
        $date = new \DateTime($date);
        /** Bulan */
        $m = $date->format('n');
        $m = $bulans[$m];
        /** Hari */
        $d = $date->format('N');
        $d = $hari[$d];
        $dateId = str_replace([
          '%j',
          '%d',
          '%m',
          '%y',
          '%H',
          '%i',
          '%s'
        ],[
          $date->format('j'),
          $d,
          $m,
          $date->format('Y'),
          $date->format('H'),
          $date->format('i'),
          $date->format('s')
        ],$format);
      }
    }
    return $dateId;
  }

  function getDurationTime(
    $startTime,
    $dueTime
  ) : string {
    $ret = "";
    if(!empty($startTime) && !empty($dueTime)){
      if(!empty(strtotime($startTime)) && !empty(strtotime($dueTime))){
        $timeCalc = strtotime($dueTime)-strtotime($startTime);
        $hours = floor($timeCalc / (60*60));
        $minutes = floor(($timeCalc - $hours * 60*60) / 60);
        $secound = floor($timeCalc - $hours * 60*60 - $minutes * 60);
        $ret =  sprintf("%'02d", $hours).":".sprintf("%'02d", $minutes).":".sprintf("%'02d", $secound);
      }
    }
    return $ret;
  }

  function getDurationTimeString(
    $startTime,
    $dueTime
  ){
    $ret = "";
    if(!empty($startTime) && !empty($dueTime)){
      if(!empty(strtotime($startTime)) && !empty(strtotime($dueTime))){
        $timeCalc = $dueTime > $startTime ? strtotime($dueTime)-strtotime($startTime) : strtotime($startTime)-strtotime($dueTime);
        if($dueTime >= $startTime){
          $timeCalc = strtotime($dueTime)-strtotime($startTime);
        }else{
          $timeCalc = strtotime($startTime)-strtotime($dueTime);
          $ret = "- ";
        }
        $days = floor($timeCalc / (60 * 60 * 24));
        $hours = floor(($timeCalc - ($days * 60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($timeCalc - ($days * 60 * 60 * 24) - ($hours * 60 * 60)) / 60);
        $secound = floor($timeCalc - ($days * 60 * 60 * 24) - ($hours * 60 * 60) - ($minutes * 60));
        $ret .= ($days ? $days." Hari " : "").($hours ? $hours." Jam " : "").($minutes ? $minutes." Menit " : "").($secound ? $secound." Detik" : "");
      }
    }
    return $ret;
  }

  function getAge(
    $date,
    string $format='%y Th %m Bl %d Hr'
  ) : string {
    $age = "";
    if(!empty($date)){
      if(!empty(strtotime($date))){
        $date = new \DateTime($date);
        $now = new \DateTime();
        $interval = $now->diff($date);
        $age = $interval->format($format);
      }
    }
    return $age;
  }

  function dateRange(
    $dateBegin,
    $dateEnd
  ) : array {
    $dates = [];
    $dateBegin = new \DateTime($dateBegin);
    $dateEnd = new \DateTime($dateEnd);
    for($date = $dateBegin; $date <= $dateEnd; $date->modify('+1 day')){
      $dates[] = $date->format('Y-m-d');
    }
    return $dates;
  }

  function generateQrCode(
    string $data,
    string $path=''
  ) : string {
    $qrcode = new chillerlan\QRCode\QRCode;
    if($path){
      $img = $qrcode->render($data,$path);
    }else{
      $img = $qrcode->render($data);
    }
    return $img;
  }

  /**
   * JWT
   */
  function jwt(
    array $payload,
    string $key
  ) : string {
    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
  }

  function jwtDecode(
    string $jwt,
    string $key
  ) : object {
    try{
      $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
      return $decoded;
    }catch(Exception $e){
      return (object)[];
    }
  }

  /**
   * Tree
   */
  function buildCleanTree(array &$elements){
    $elements = $this->buildTree($elements);
    $this->cleanTree($elements);
  }

  function buildTree(
    array $elements,
    $parentId = 0
  ) : array {
    $branch = [];
  
    foreach($elements as $element){
      if($element->parent_id == $parentId){
        $children = $this->buildTree($elements, $element->id);
        $element->childs = $children ? $children : null;
        $branch[] = $element;
      }
    }
  
    return $branch;
  }
  
  function cleanTree(array &$tree){
    $changed = true;
    do{
      $changed = false;
      foreach($tree as $key => &$node){
        if($node->childs !== null){
          $this->cleanTree($node->childs);
          if(empty($node->childs)){
            $node->childs = null;
            $changed = true;
          }
        }
        if($node->isparent && $node->childs === null){
          unset($tree[$key]);
          $changed = true;
        }
      }
    }while($changed);
  
    foreach($tree as $key => &$node){
      if($node->isparent && $node->childs === null){
        unset($tree[$key]);
      }
    }
  }

  function getLabelByValue(
    array $array,
    string $value,
    string $valueKey='value',
    string $labelKey='label',
    string $default='',
  ) : string  {
    foreach ($array as $item) {
      if ($item[$valueKey] === $value) {
        return $item[$labelKey];
      }
    }
    return $default;
  }


}