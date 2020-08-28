<?php

require 'db.php';


if($_POST) {
    $yearMonth = $_POST['yearMonth'];
    $statement = $myPDO->prepare('SELECT * FROM okasato WHERE branch = :branch AND date like :yearMonth' . '"%"');
    $statement->execute(array(
        ':branch' => $_POST['branch'],
        ':yearMonth' => $_POST['yearMonth']
    ));
    $matchedArray = $statement->fetchAll();
    if(count($matchedArray) === 0) {
        echo '<p style="font-size: 3rem;">選択した月のデータが見つかりませんでした。</p>';
        return;
    }
}



require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//ワークブックを作る
$spreadsheet = new Spreadsheet();

//日付ごとループ

for($i = 0; $i < count($matchedArray); $i++) {
    $record = $matchedArray[$i];
    if($i == 0) {
        $spreadsheet->getActiveSheet()->setTitle($record['date']);
    } else {
        $spreadsheet->createSheet()->setTitle($record['date']);
    }

    //現在のシートを変数にする
    $activeSheet = $spreadsheet->getSheet($i);


    //1 ~ 5行目
    $activeSheet
    ->setCellValue('J1', '記入者')
    ->setCellValue('K1', $record['name'])
    ->setCellValue('A2', '日付')
    ->mergeCells('C2:C2')
    ->setCellValue('B2', $record['date'])
    ->setCellValue('J3', '店舗名')
    ->setCellValue('K3', $_POST['branch'])
    ->setCellValue('A4', 'つり銭')
    ->mergeCells('A4:C4')
    ->mergeCells('D4:G4')
    ->setCellValue('D4', $record['change1'])
    ->mergeCells('H4:M4')
    ->setCellValue('H4', '内訳')
    ->mergeCells('A5:C5')
    ->setCellValue('A5', '現金売上')
    ->mergeCells('D5:G5')
    ->setCellValue('D5', $record['earning'])
    ->mergeCells('H5:J5')
    ->setCellValue('H5', '取引・購入先名')
    ->mergeCells('K5:M5')
    ->setCellValue('K5', '明細')
    ;

    //1 ~ 2行目スタイル
    $activeSheet
        ->getStyle('K1')->getBorders()->getBottom()
        ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('B2')
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('B2')
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('B2')
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('B2')
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('C2')
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('C2')
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('C2')
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeSheet
        ->getStyle('C2')
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    

    
    //入金のデータを配列に戻す
    $received_from_array = unserialize($record['received_from']);
    $total_received_array = unserialize($record['total_received']);
    $content_received_array = unserialize($record['content_received']);

    //入金の個数（回数）
    $received_count = count($received_from_array);


    //A列のセルを結合「入金」
    if($received_count >= 5) {
        $activeSheet
        ->mergeCells("A6:A".(5+$received_count))
        ->setCellValue('A6', '入金');
    } else if($received_count < 5) {
        $activeSheet
        ->mergeCells("A6:A10")
        ->setCellValue('A6', '入金');
    }

    $activeSheet
    ->getStyle('A6')->getAlignment()->setHorizontal('center')->setVertical('center');
    
    
    //入金のデータ入力
        for($j = 0; $j < $received_count; $j++) {
            $activeSheet
                ->mergeCells('B'.(6+$j).':C'.(6+$j))
                ->setCellValue('B'.(6+$j), $total_received_array[$j])
                ->mergeCells('D'.(6+$j).':G'.(6+$j))
                ->mergeCells('H'.(6+$j).':J'.(6+$j))
                ->setCellValue('H'.(6+$j), $received_from_array[$j])
                ->mergeCells('K'.(6+$j).':M'.(6+$j))
                ->setCellValue('K'.(6+$j), $content_received_array[$j]);
        }

        //入金の列最低5
        if($received_count < 5) {
            $received_blank_num = 5 - $received_count;
            for($j = 0; $j < $received_blank_num; $j++) {
                $activeSheet
                ->mergeCells('B'.(6+$received_count+$j).':C'.(6+$received_count+$j))
                ->mergeCells('D'.(6+$received_count+$j).':G'.(6+$received_count+$j))
                ->mergeCells('H'.(6+$received_count+$j).':J'.(6+$received_count+$j))
                ->mergeCells('K'.(6+$received_count+$j).':M'.(6+$received_count+$j));
            }
        }
    //最終的な入金の列の数
    $final_received_num;
    if($received_count >= 5) {
        global $final_received_num;
        $final_received_num = $received_count;
    } else if($received_count < 5) {
        global $final_received_num;
        $final_received_num = 5;
    }
    
    //出金のデータを配列に戻す
    $sent_to_array = unserialize($record['sent_to']);
    $total_sent_array = unserialize($record['total_sent']);
    $content_sent_array = unserialize($record['content_sent']);

    //出金の個数（回数）
    $sent_count = count($sent_to_array);

    //A列のセルを結合「出金」
    
        if($sent_count >= 10) {
            $activeSheet
            ->mergeCells("A".(6+$final_received_num).":A".(6+$final_received_num+$sent_count-1))
            ->setCellValue('A'.(6+$received_count), '出金');
        } else if($sent_count < 10) {
            $activeSheet
            ->mergeCells("A".(6+$final_received_num).":A".(6+$final_received_num+9))
            ->setCellValue('A'.(6+$final_received_num), '出金');
        }
    
        $activeSheet
        ->getStyle('A'.(6+$final_received_num))->getAlignment()->setHorizontal('center')->setVertical('center');
        

    //出金のデータ入力
        for($j = 0; $j < $sent_count; $j++) {
            $activeSheet
                ->mergeCells('B'.(6+$final_received_num+$j).':C'.(6+$final_received_num+$j))
                ->setCellValue('B'.(6+$final_received_num+$j), $total_sent_array[$j])
                ->mergeCells('D'.(6+$final_received_num+$j).':G'.(6+$final_received_num+$j))
                ->mergeCells('H'.(6+$final_received_num+$j).':J'.(6+$final_received_num+$j))
                ->setCellValue('H'.(6+$final_received_num+$j), $sent_to_array[$j])
                ->mergeCells('K'.(6+$final_received_num+$j).':M'.(6+$final_received_num+$j))
                ->setCellValue('K'.(6+$final_received_num+$j), $content_sent_array[$j]);
        }

        //値が入ってる出金の最後の列
        $last_sent_row_with_value = 6 + $final_received_num + $sent_count - 1;

        //出金の列最低10
        if($sent_count < 10) {
            $sent_blank_num = 10 - $sent_count;
            for($j = 0; $j < $sent_blank_num; $j++) {
                $activeSheet
                ->mergeCells('B'.($last_sent_row_with_value+1+$j).':C'.($last_sent_row_with_value+1+$j))
                ->mergeCells('D'.($last_sent_row_with_value+1+$j).':G'.($last_sent_row_with_value+1+$j))
                ->mergeCells('H'.($last_sent_row_with_value+1+$j).':J'.($last_sent_row_with_value+1+$j))
                ->mergeCells('K'.($last_sent_row_with_value+1+$j).':M'.($last_sent_row_with_value+1+$j));
            }
        }
    
    //出金の最後の行
    $lastRow;
    if($sent_count >= 10) {
        global $lastRow;
        $lastRow = 5 + $final_received_num + $sent_count;
    } else if ($sent_count < 10) {
        global $lastRow;
        $lastRow = 5 + $final_received_num + 10;
    }
    
    //出金までのスタイル
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    
    $activeSheet->getStyle('A4:M'.$lastRow)->applyFromArray($styleArray);

    //出金までの外枠などスタイル
    $activeSheet
        ->getStyle('A4:M4')
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('A4:A'.$lastRow)
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('M4:M'.$lastRow)
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('A'.$lastRow.':M'.$lastRow)
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('A'.(6+$final_received_num).':M'.(6+$final_received_num))
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        

    //現時点で最終行を変数に入れ、「支払計」〜「翌日預け入れ」までの
    //行番号を変数に格納する
    $shiharai = $lastRow + 1;
    $reji = $lastRow + 2;
    $genkin = $lastRow + 3;
    $jissen = $lastRow + 4;
    $tsuri = $lastRow + 5;
    $azuke = $lastRow + 6;

    $received_sum = array_sum($total_received_array);
    $sent_sum = array_sum($total_sent_array);
    $reji_zan = $record['change1'] + $record['earning'] + $received_sum - $sent_sum;
    $kabusoku = $reji_zan - $record['jisen_total'];

    //「支払い」〜「翌日預け入れ」項目名
    $activeSheet
        ->mergeCells('A'.$shiharai.':C'.$shiharai)
        ->mergeCells('A'.$reji.':C'.$reji)
        ->mergeCells('A'.$genkin.':C'.$genkin)
        ->mergeCells('A'.$jissen.':C'.$jissen)
        ->mergeCells('A'.$tsuri.':C'.$tsuri)
        ->mergeCells('A'.$azuke.':C'.$azuke)
        ->setCellValue('A'.$shiharai, '支払計')
        ->setCellValue('A'.$reji, 'レジ残計')
        ->setCellValue('A'.$genkin, '現金過不足')
        ->setCellValue('A'.$jissen, '実残合計')
        ->setCellValue('A'.$tsuri, '翌日つり銭')
        ->setCellValue('A'.$azuke, '翌日預け入れ')
        ->setCellValue('D'.$shiharai, $sent_sum)
        ->setCellValue('D'.$reji, $reji_zan)
        ->setCellValue('D'.$genkin, $kabusoku)
        ->setCellValue('D'.$jissen, $record['jisen_total'])
        ->setCellValue('D'.$tsuri, $record['next_day_change'])
        ->setCellValue('D'.$azuke, $record['next_day_deposit']);

    //「支払計」〜「翌日預け入れ」値を入れる部分
    
    $activeSheet
        ->mergeCells('D'.$shiharai.':G'.$shiharai)
        ->mergeCells('D'.$reji.':G'.$reji)
        ->mergeCells('D'.$genkin.':G'.$genkin)
        ->mergeCells('D'.$jissen.':G'.$jissen)
        ->mergeCells('D'.$tsuri.':G'.$tsuri)
        ->mergeCells('D'.$azuke.':G'.$azuke)

        ->setCellValue('J'.$shiharai, '本部記入欄')
        ->setCellValue('J'.$reji, '8%')
        ->setCellValue('J'.$genkin, '10%')
        ->setCellValue('J'.$jissen, '計')
        ->setCellValue('J'.$tsuri, 'クーポン計')
        ->setCellValue('J'.$azuke, 'クーポン差額')

        ->mergeCells('K'.$shiharai.':M'.$shiharai)
        ->mergeCells('K'.$reji.':M'.$reji)
        ->mergeCells('K'.$genkin.':M'.$genkin)
        ->mergeCells('K'.$jissen.':M'.$jissen)
        ->mergeCells('K'.$tsuri.':M'.$tsuri)
        ->mergeCells('K'.$azuke.':M'.$azuke);
    
    //「支払い」〜「翌日預け入れ」スタイル
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    
    $activeSheet->getStyle('A'.$shiharai.':G'.$azuke)->applyFromArray($styleArray);

    //出金のしたのA~Gのborderbottom
    $activeSheet
        ->getStyle('A'.$shiharai.':G'.$shiharai)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

    //本部記入欄のスタイル
    $activeSheet->getStyle('J'.$shiharai.':J'.$azuke)->getAlignment()
    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

    $styleArray = [
        'borders' => [
            'horizontal' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    
    $activeSheet->getStyle('K'.$reji.':M'.$azuke)->applyFromArray($styleArray);

    $activeSheet->getStyle('K'.$azuke.':M'.$azuke)->getBorders()->getBottom()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);

    //食事券らんの行番号
    $ticketRow1 = $azuke + 2;
    $ticketRow2 = $ticketRow1 + 1;
    $ticketRow3 = $ticketRow2 + 1;
    $ticketRow4 = $ticketRow3 + 1;
    $ticketRow5 = $ticketRow4 + 1;

    //食事券のらん
    $other_how_much = unserialize($record['other_how_much']);

    $shokuji_total = $record['prem_total'] + $record['for_selling_total']
    + $record['thousand_total'] + $record['five_total'] + $record['two_total'] + array_sum($other_how_much);
    $activeSheet
        ->mergeCells('A'.$ticketRow1.':G'.$ticketRow1)
        ->mergeCells('H'.$ticketRow1.':I'.$ticketRow1)
        ->mergeCells('J'.$ticketRow1.':L'.$ticketRow1)
        ->mergeCells('B'.$ticketRow2.':E'.$ticketRow2)
        ->mergeCells('F'.$ticketRow2.':I'.$ticketRow2)
        ->mergeCells('J'.$ticketRow2.':M'.$ticketRow2)
        ->setCellValue('A'.$ticketRow1, '※食事券計は、ジャーナルの食事券計と合致すること。')
        ->setCellValue('H'.$ticketRow1, '食事券計(その他含む')
        ->setCellValue('J'.$ticketRow1, $shokuji_total)
        ->setCellValue('M'.$ticketRow1, '円')
        ->setCellValue('B'.$ticketRow2, 'プレミアム食事券')
        ->setCellValue('F'.$ticketRow2, '販売用回収')
        ->setCellValue('J'.$ticketRow2, 'サービス用回収')
        ->setCellValue('A'.$ticketRow3, '千円券')
        ->setCellValue('B'.$ticketRow3, $record['prem_count'])
        ->setCellValue('C'.$ticketRow3, '枚')
        ->setCellValue('D'.$ticketRow3, $record['prem_total'])
        ->setCellValue('E'.$ticketRow3, '円')
        ->setCellValue('F'.$ticketRow3, $record['for_selling_count'])
        ->setCellValue('G'.$ticketRow3, '枚')
        ->setCellValue('H'.$ticketRow3, $record['for_selling_total'])
        ->setCellValue('I'.$ticketRow3, '円')
        ->setCellValue('J'.$ticketRow3, $record['thousand_count'])
        ->setCellValue('K'.$ticketRow3, '枚')
        ->setCellValue('L'.$ticketRow3, $record['thousand_total'])
        ->setCellValue('M'.$ticketRow3, '円')
        ->setCellValue('J'.$ticketRow4, $record['five_count'])
        ->setCellValue('K'.$ticketRow4, '枚')
        ->setCellValue('L'.$ticketRow4, $record['five_total'])
        ->setCellValue('M'.$ticketRow4, '円')
        ->setCellValue('J'.$ticketRow5, $record['two_count'])
        ->setCellValue('K'.$ticketRow5, '枚')
        ->setCellValue('L'.$ticketRow5, $record['two_total'])
        ->setCellValue('M'.$ticketRow5, '円')
        ->setCellValue('A'.$ticketRow4, '500円')
        ->setCellValue('A'.$ticketRow5, '200円');
    
    //食事券スタイル
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    
    $activeSheet->getStyle('H'.$ticketRow1.':M'.$ticketRow1)->applyFromArray($styleArray);

    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];

    
    $activeSheet->getStyle('A'.$ticketRow2.':M'.$ticketRow5)->applyFromArray($styleArray);

    $activeSheet
        ->getStyle('H'.$ticketRow1.':M'.$ticketRow1)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('H'.$ticketRow1)
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('M'.$ticketRow1.':M'.$ticketRow5)
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('A'.$ticketRow2.':M'.$ticketRow2)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('A'.$ticketRow3.':M'.$ticketRow3)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('A'.$ticketRow2.':A'.$ticketRow5)
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('A'.$ticketRow2.':A'.$ticketRow5)
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('F'.$ticketRow2.':F'.$ticketRow5)
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('J'.$ticketRow1.':J'.$ticketRow5)
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $activeSheet
        ->getStyle('A'.$ticketRow5.':M'.$ticketRow5)
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $activeSheet
        ->getStyle('H'.$ticketRow1.':M'.$ticketRow1)
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

    $activeSheet->getStyle('B'.$ticketRow2.':M'.$ticketRow2)->getAlignment()
    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $activeSheet->getStyle('B'.$ticketRow4.':I'.$ticketRow5)
    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
    $activeSheet->getStyle('B'.$ticketRow4.':I'.$ticketRow5)
    ->getFill()->getStartColor()->setARGB('dddddd');

    //その他食事券
    $other_service_row1 = $ticketRow5 + 2;
    $activeSheet->setCellValue('A'.$other_service_row1, 'その他');
        $other_name = unserialize($record['other_name']);
        $other_count = unserialize($record['other_count']);
        $other_how_much = unserialize($record['other_how_much']);
        for($j = 0; $j < count($other_name); $j++){
            $current_other_service_row = $other_service_row1 + 1 + $j;
            $activeSheet
                ->setCellValue('A'.$current_other_service_row, $other_name[$j])
                ->setCellValue('B'.$current_other_service_row, $other_count[$j])
                ->setCellValue('C'.$current_other_service_row, '枚')
                ->setCellValue('D'.$current_other_service_row, $other_how_much[$j])
                ->setCellValue('E'.$current_other_service_row, '円');
        }
    
    if($record['other_name']){
        $last_other_service_row = $other_service_row1 + count($other_name);
    } else {
        $last_other_service_row = $other_service_row1;
    }

    
    //売掛の名前と金額の配列
    $client_name_array = unserialize($record['client_name']);
    $urikake_total_array = unserialize($record['urikake_total']);
    //売掛の数
    $urikake_count = count($client_name_array);
    //売掛金らん
    $urikakeRow1 = $last_other_service_row + 3;

    $activeSheet
        ->mergeCells('A'.$urikakeRow1.':B'.$urikakeRow1)
        ->setCellValue('A'.$urikakeRow1, '売掛金');

        for($j = 0; $j < $urikake_count; $j++) {
            $activeSheet
                ->mergeCells('C'.($urikakeRow1+$j).':D'.($urikakeRow1+$j))
                ->setCellValue('C'.($urikakeRow1+$j), $client_name_array[$j].'様')
                ->mergeCells('E'.($urikakeRow1+$j).':F'.($urikakeRow1+$j))
                ->setCellValue('E'.($urikakeRow1+$j), $urikake_total_array[$j].'円');
        }

    //DC,JCBの値を配列に戻す
    $dc_how_much = unserialize($record['dc_how_much']);
    $jcb_how_much = unserialize($record['jcb_how_much']);

    //dc,jcbの数
    $dc_count = count($dc_how_much);
    $jcb_count = count($jcb_how_much);
    $dcRow1 = $urikakeRow1 + $urikake_count + 1;
    $activeSheet
        ->mergeCells('A'.$dcRow1.':B'.$dcRow1)
        ->mergeCells('E'.$dcRow1.':F'.$dcRow1)
        ->mergeCells('G'.$dcRow1.':H'.$dcRow1)
        ->mergeCells('K'.$dcRow1.':L'.$dcRow1)

        ->setCellValue('A'.$dcRow1, 'DC売上内訳')
        ->setCellValue('G'.$dcRow1, 'JCB売上内訳');

        for($j = 0; $j < $dc_count; $j++) {
            if($j == 0) {
                $activeSheet
                ->setCellValue('E'.($dcRow1+$j), $dc_how_much[$j].'円');
            } else {
                $activeSheet
                    ->mergeCells('E'.($dcRow1+$j).':F'.($dcRow1+$j))
                    ->setCellValue('E'.($dcRow1+$j), $dc_how_much[$j].'円');
            }
            
        }

        for($j = 0; $j < $jcb_count; $j++) {
            if($j == 0) {
                $activeSheet
                ->setCellValue('K'.($dcRow1+$j), $jcb_how_much[$j].'円');
            } else {
                $activeSheet
                    ->mergeCells('K'.($dcRow1+$j).':L'.($dcRow1+$j))
                    ->setCellValue('K'.($dcRow1+$j), $jcb_how_much[$j].'円');
            }
        }

    //dc,jcb合計の行
    $dc_jcb_total_row;
    if($dc_count > $jcb_count) {
        $dc_jcb_total_row = $dcRow1 + $dc_count;
    } else {
        $dc_jcb_total_row = $dcRow1 + $jcb_count;
    }

    $activeSheet
        ->mergeCells('A'.$dc_jcb_total_row.':B'.$dc_jcb_total_row)
        ->mergeCells('C'.$dc_jcb_total_row.':D'.$dc_jcb_total_row)
        ->mergeCells('E'.$dc_jcb_total_row.':F'.$dc_jcb_total_row)
        ->mergeCells('G'.$dc_jcb_total_row.':H'.$dc_jcb_total_row)
        ->mergeCells('I'.$dc_jcb_total_row.':J'.$dc_jcb_total_row)
        ->mergeCells('K'.$dc_jcb_total_row.':L'.$dc_jcb_total_row)

        ->setCellValue('A'.$dc_jcb_total_row, 'DC売上合計')
        ->setCellValue('C'.$dc_jcb_total_row, $dc_count.'件')
        ->setCellValue('E'.$dc_jcb_total_row, array_sum($dc_how_much).'円')
        ->setCellvalue('G'.$dc_jcb_total_row, 'JCB売上合計')
        ->setCellValue('I'.$dc_jcb_total_row, $jcb_count.'件')
        ->setCellValue('K'.$dc_jcb_total_row, array_sum($jcb_how_much).'円');

    //paypay
    $paypayRow = $dc_jcb_total_row + 3;

    $activeSheet
        ->mergeCells('A'.$paypayRow.':B'.$paypayRow)
        ->mergeCells('C'.$paypayRow.':D'.$paypayRow)
        ->mergeCells('E'.$paypayRow.':F'.$paypayRow)
        ->setCellValue('A'.$paypayRow, 'PAYPAY売上合計')
        ->setCellValue('C'.$paypayRow, $record['paypay_count'].'件')
        ->setCellValue('E'.$paypayRow, $record['paypay_total'].'円');

    //others
    $othersRow1 = $paypayRow + 3;
    $othersRow2 = $othersRow1 + 1;
    $othersRow3 = $othersRow2 + 1;
    $othersRow4 = $othersRow3 + 1;
    $othersRow5 = $othersRow4 + 1;

    $activeSheet
        ->mergeCells('A'.$othersRow1.':B'.$othersRow1)
        ->mergeCells('C'.$othersRow1.':D'.$othersRow1)
        ->mergeCells('E'.$othersRow1.':F'.$othersRow1)
        ->mergeCells('G'.$othersRow1.':H'.$othersRow1)
        ->mergeCells('I'.$othersRow1.':J'.$othersRow1)
        ->mergeCells('K'.$othersRow1.':L'.$othersRow1)
        ->mergeCells('A'.$othersRow2.':B'.$othersRow2)
        ->mergeCells('C'.$othersRow2.':D'.$othersRow2)
        ->mergeCells('E'.$othersRow2.':F'.$othersRow2)
        ->mergeCells('G'.$othersRow2.':H'.$othersRow2)
        ->mergeCells('I'.$othersRow2.':J'.$othersRow2)
        ->mergeCells('K'.$othersRow2.':L'.$othersRow2)
        ->mergeCells('A'.$othersRow3.':B'.$othersRow3)
        ->mergeCells('C'.$othersRow3.':D'.$othersRow3)
        ->mergeCells('E'.$othersRow3.':F'.$othersRow3)
        ->mergeCells('G'.$othersRow3.':H'.$othersRow3)
        ->mergeCells('I'.$othersRow3.':J'.$othersRow3)
        ->mergeCells('K'.$othersRow3.':L'.$othersRow3)
        ->mergeCells('A'.$othersRow4.':B'.$othersRow4)
        ->mergeCells('C'.$othersRow4.':D'.$othersRow4)
        ->mergeCells('E'.$othersRow4.':F'.$othersRow4)
        ->mergeCells('G'.$othersRow4.':H'.$othersRow4)
        ->mergeCells('I'.$othersRow4.':J'.$othersRow4)
        ->mergeCells('K'.$othersRow4.':L'.$othersRow4)
        ->mergeCells('A'.$othersRow5.':B'.$othersRow5)
        ->mergeCells('C'.$othersRow5.':D'.$othersRow5)
        ->mergeCells('E'.$othersRow5.':F'.$othersRow5)
        ->mergeCells('G'.$othersRow5.':H'.$othersRow5)
        ->mergeCells('I'.$othersRow5.':J'.$othersRow5)
        ->mergeCells('K'.$othersRow5.':L'.$othersRow5)
        ->setCellValue('A'.$othersRow1, 'nanaco')
        ->setCellValue('C'.$othersRow1, $record['nanaco_count'].'件')
        ->setCellValue('E'.$othersRow1, $record['nanaco_total'].'円')
        ->setCellValue('A'.$othersRow2, 'edy')
        ->setCellValue('C'.$othersRow2, $record['edy_count'].'件')
        ->setCellValue('E'.$othersRow2, $record['edy_total'].'円')
        ->setCellValue('A'.$othersRow3, '交通IC')
        ->setCellValue('C'.$othersRow3, $record['transport_ic_count'].'件')
        ->setCellValue('E'.$othersRow3, $record['transport_ic_total'].'円')
        ->setCellValue('A'.$othersRow4, 'Quick Pay')
        ->setCellValue('C'.$othersRow4, $record['quick_pay_count'].'件')
        ->setCellValue('E'.$othersRow4, $record['quick_pay_total'].'円')
        ->setCellValue('A'.$othersRow5, 'WAON')
        ->setCellValue('C'.$othersRow5, $record['waon_count'].'件')
        ->setCellValue('E'.$othersRow5, $record['waon_total'].'円');
    
    //他の電子マネー
    $other_e_money_name = unserialize($record['other_e_money_name']);
    $other_e_money_count = unserialize($record['other_e_money_count']);
    $other_e_money_amount = unserialize($record['other_e_money_amount']);

    if(is_array($other_e_money_name)) {
        for($j = 0; $j < count($other_e_money_name); $j++) {
            $row = $othersRow5 + $j + 1;
            $activeSheet
                ->mergeCells('A'.$row.':B'.$row)
                ->mergeCells('C'.$row.':D'.$row)
                ->mergeCells('E'.$row.':F'.$row)
                ->mergeCells('G'.$row.':H'.$row)
                ->mergeCells('I'.$row.':J'.$row)
                ->mergeCells('K'.$row.':L'.$row)
                ->setCellValue('A'.$row, $other_e_money_name[$j])
                ->setCellValue('C'.$row, $other_e_money_count[$j].'件')
                ->setCellValue('E'.$row, $other_e_money_amount[$j].'円');
        }
    }


    //メモらん
    if(is_array($other_e_money_name)) {
        $noteTitleRow = $othersRow5 + count($other_e_money_name) + 2;
    } else {
        $noteTitleRow = $othersRow5 + 2;
    }
    
    $noteRow = $noteTitleRow + 1;

    $activeSheet
        ->mergeCells('A'.$noteTitleRow.':C'.$noteTitleRow)
        ->mergeCells('A'.$noteRow.':L'.($noteRow+4))
        ->setCellValue('A'.$noteTitleRow, 'メモ、伝達事項：');

    //メモらんスタイル
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    
    $activeSheet->getStyle('A'.$noteRow.':L'.($noteRow+4))->applyFromArray($styleArray);

}

$writer = new Xlsx($spreadsheet);
$writer->save($yearMonth.'.xlsx');


//test to download with php header
$file = $yearMonth.'.xlsx';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

?>
