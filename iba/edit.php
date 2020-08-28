<?php

    session_start();
    require '../db.php';
    require '../lang.php';

    if($_SESSION['logged_in'] !== 'logged_in') {
        header('Location: ../index.php');
    }

    //日付セッションがないか、ブランチセッションがない場合はトップページに
    if(!$_SESSION['date'] || !$_SESSION['branch']) {
        session_destroy();
        header('Location: ../index.php');
    }


    //当店舗と日付セッションを両方含んでいるデータがデータベースにない場合はトップページに
    $stmt = $myPDO->prepare("SELECT * FROM okasato WHERE date = :date AND branch = :branch");
    $stmt->execute(array(
        ':date' => $_SESSION['date'],
        ':branch' => $_SESSION['branch']
    ));
    $matchedRowsArray = $stmt->fetchAll();//データを配列にする
    $rowCount = count($matchedRowsArray);


    if($rowCount == 0) {

        session_destroy();
        header('Location: ../index.php');

    } else {

        //データがある場合は、一番最近入力したデータを探す
        $record;
        $time_created = 0;
        foreach($matchedRowsArray as $row) {
            global $record;
            global $time_created;
            if($row['time_created'] > $time_created) {
                $time_created = $row['time_created'];
                $record = $row;
            }
        }
    

        //表示する項目のデータをセッションにする。最初にページがされたとき
        if(empty($_POST['from_edit_form'])) {

        $_SESSION['name'] = $record['name'];

        $unixtime = strtotime($_SESSION['date']);
        $_SESSION['year'] = date('Y', $unixtime);
        $_SESSION['month'] = date('m', $unixtime);
        $_SESSION['displayDate'] = date('d', $unixtime);


        $_SESSION['change'] = $record['change1'];
        $_SESSION['earning'] = $record['earning'];

        $_SESSION['received_from'] = unserialize($record['received_from']);
        $_SESSION['total_received'] = unserialize($record['total_received']);
        $_SESSION['content_received'] = unserialize($record['content_received']);

        $_SESSION['sent_to'] = unserialize($record['sent_to']);
        $_SESSION['total_sent'] = unserialize($record['total_sent']);
        $_SESSION['content_sent'] = unserialize($record['content_sent']);

        $_SESSION['next_day_change'] = $record['next_day_change'];
        $_SESSION['jisen_total'] = $record['jisen_total'];
        $_SESSION['next_day_deposit'] = $record['next_day_deposit'];
        $_SESSION['prem_count'] = $record['prem_count'];
        $_SESSION['prem_total'] = $record['prem_total'];
        $_SESSION['for_selling_count'] = $record['for_selling_count'];
        $_SESSION['for_selling_total'] = $record['for_selling_total'];
        $_SESSION['thousand_count'] = $record['thousand_count'];
        $_SESSION['thousand_total'] = $record['thousand_total'];
        $_SESSION['five_count'] = $record['five_count'];
        $_SESSION['five_total'] = $record['five_total'];
        $_SESSION['two_count'] = $record['two_count'];
        $_SESSION['two_total'] = $record['two_total'];

        $_SESSION['other_name'] = unserialize($record['other_name']);
        $_SESSION['other_count'] = unserialize($record['other_count']);
        $_SESSION['other_how_much'] = unserialize($record['other_how_much']);

        $_SESSION['client_name'] = unserialize($record['client_name']);
        $_SESSION['urikake_total'] = unserialize($record['urikake_total']);

        $_SESSION['dc_how_much'] = unserialize($record['dc_how_much']);
        $_SESSION['jcb_how_much'] = unserialize($record['jcb_how_much']);

        $_SESSION['paypay_count'] = $record['paypay_count'];
        $_SESSION['paypay_total'] = $record['paypay_total'];
        $_SESSION['nanaco_count'] = $record['nanaco_count'];
        $_SESSION['nanaco_total'] = $record['nanaco_total'];
        $_SESSION['edy_count'] = $record['edy_count'];
        $_SESSION['edy_total'] = $record['edy_total'];
        $_SESSION['transport_ic_count'] = $record['transport_ic_count'];
        $_SESSION['transport_ic_total'] = $record['transport_ic_total'];
        $_SESSION['quick_pay_count'] = $record['quick_pay_count'];
        $_SESSION['quick_pay_total'] = $record['quick_pay_total'];
        $_SESSION['waon_count'] = $record['waon_count'];
        $_SESSION['waon_total'] = $record['waon_total'];

        $_SESSION['other_e_money_name'] = unserialize($record['other_e_money_name']);
        $_SESSION['other_e_money_count'] = unserialize($record['other_e_money_count']);
        $_SESSION['other_e_money_amount'] = unserialize($record['other_e_money_amount']);
        }
    }

    //編集画面から送信したデータがある場合、セッションに置き換える

    //名前を編集する編集画面
    if(isset($_POST['name'])) {
        $_SESSION['name'] = $_POST['name'];
    }

    //first modalの編集画面
    if(isset($_POST['first_modal'])) {
        
        $_SESSION['change'] = $_POST['change'];

        $_SESSION['earning'] = $_POST['earning'];
    
        $_SESSION['received_from'] = isset($_POST['received_from']) ? $_POST['received_from'] : null;
    
        $_SESSION['total_received'] = isset($_POST['total_received']) ? $_POST['total_received'] : null;
    
        $_SESSION['content_received'] = isset($_POST['content_received']) ? $_POST['content_received'] : null;
    
        $_SESSION['sent_to'] = isset($_POST['sent_to']) ? $_POST['sent_to'] : null;
    
        $_SESSION['total_sent'] = isset($_POST['total_sent']) ? $_POST['total_sent'] : null;
        
        $_SESSION['content_sent'] = isset($_POST['content_sent']) ? $_POST['content_sent'] : null;
    
        $_SESSION['next_day_change'] = $_POST['next_day_change'];
    
        $_SESSION['jisen_total'] = $_POST['jisen_total'];
    
        $_SESSION['next_day_deposit'] = $_POST['next_day_deposit'];

    }

    if(isset($_POST['second_modal'])) {

        $_SESSION['prem_count'] = $_POST['prem_count'];
    
        $_SESSION['prem_total'] = $_POST['prem_total'];
    
        $_SESSION['for_selling_count'] = $_POST['for_selling_count'];
    
        $_SESSION['for_selling_total'] = $_POST['for_selling_total'];
    
        $_SESSION['thousand_count'] = $_POST['thousand_count'];
        $_SESSION['thousand_total'] = $_POST['thousand_count'] * 1000;
    
        $_SESSION['five_count'] = $_POST['five_count'];
        $_SESSION['five_total'] = $_POST['five_count'] * 500;
    
        $_SESSION['two_count'] = $_POST['two_count'];
        $_SESSION['two_total'] = $_POST['two_count'] * 200;

        $_SESSION['other_name'] = isset($_POST['other_name']) ? $_POST['other_name'] : null;
        $_SESSION['other_count'] = isset($_POST['other_count']) ? $_POST['other_count'] : null;
        $_SESSION['other_how_much'] = isset($_POST['other_how_much']) ? $_POST['other_how_much'] : null;

    }
    
    if(isset($_POST['third_modal'])) {
        $_SESSION['client_name'] = isset($_POST['client_name']) ? $_POST['client_name'] : null;
        $_SESSION['urikake_total'] = isset($_POST['urikake_total']) ? $_POST['urikake_total'] : null;
    }

    if(isset($_POST['fourth_modal'])) {

        $_SESSION['dc_how_much'] = isset($_POST['dc_how_much']) ? $_POST['dc_how_much'] : null;

        $_SESSION['jcb_how_much'] = isset($_POST['jcb_how_much']) ? $_POST['jcb_how_much'] : null;

        $_SESSION['paypay_count'] = $_POST['paypay_count'];
        $_SESSION['paypay_total'] = $_POST['paypay_total'];
        $_SESSION['nanaco_count'] = $_POST['nanaco_count'];
        $_SESSION['nanaco_total'] = $_POST['nanaco_total'];
        $_SESSION['edy_count'] = $_POST['edy_count'];
        $_SESSION['edy_total'] = $_POST['edy_total'];
        $_SESSION['transport_ic_count'] = $_POST['transport_ic_count'];
        $_SESSION['transport_ic_total'] = $_POST['transport_ic_total'];
        $_SESSION['quick_pay_count'] = $_POST['quick_pay_count'];
        $_SESSION['quick_pay_total'] = $_POST['quick_pay_total'];
        $_SESSION['waon_count'] = $_POST['waon_count'];
        $_SESSION['waon_total'] = $_POST['waon_total'];

        $_SESSION['other_e_money_name'] = isset($_POST['other_e_money_name']) ? $_POST['other_e_money_name'] : null;
        $_SESSION['other_e_money_count'] = isset($_POST['other_e_money_count']) ? $_POST['other_e_money_count'] : null;
        $_SESSION['other_e_money_amount'] = isset($_POST['other_e_money_amount']) ? $_POST['other_e_money_amount'] : null;

    }

?>
<html>
<head>
<?php require './form-head.php';?>
</head>
<body>

    <div class="confirmation-container">
        <h2 class="ui header">
            <span class="item-name"><?php checkLang('User Name', '記入者');?>：</span>
            <span class="item-value"><?php echo $_SESSION['name'];?></span>
            <button class="edit name" id="edit-btn"><?php checkLang('Edit', '編集'); ?></button>
        </h2>

        <h2 class="ui header">
            <span class="item-name"><?php checkLang('Date', '日付');?>：</span>
            <span><?php checkLang($_SESSION['month'] . '-' . $_SESSION['displayDate'] . ', ' . $_SESSION['year'], $_SESSION['year'] . '年' . $_SESSION['month'] . '月' . $_SESSION['displayDate'] . '日');?></span>
        </h2>

        <h2 class="ui header"><?php checkLang('Branch', '店舗名');?>：<?php echo $_SESSION['branch'];?></h2>

        <div>

            <table>
                <tr class="row-1">
                    <td class="item_name"><?php checkLang('Change', '釣り銭');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['change']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="item_name"><?php checkLang('Breakdown', '内訳');?></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Cash Sale', '現金売上');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['earning']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="item_name"><?php checkLang('Clients', '購入取引先名');?></td>
                    <td class="item_name"><?php checkLang('Items & Services', '明細');?></td>
                </tr>

                <?php if(isset($_SESSION['received_from'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Received', '入金');?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['total_received'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                            <td><?php echo $_SESSION['received_from'][$i];?></td>
                            <td><?php echo $_SESSION['content_received'][$i];?></td>
                        </tr>
                    <?php endfor;?>
                    <!-- 入金の列が５より少ない場合、列の数が５になるまで追加-->
                    <?php
                        if(count($_SESSION['received_from']) < 5) {
                            $num_of_blank_received_rows = 5 - count($_SESSION['received_from']);
                            for($i = 0; $i < $num_of_blank_received_rows; $i++) { ?>
                                <tr class="row-2">
                                    <td class="item_name"><?php checkLang('Money Received', '入金');?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                <?php else :?>
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Received', '入金');?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>                      
                    <?php endfor; ?>

                <?php endif; ?>

                <?php if(isset($_SESSION['sent_to'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                        <tr class="<?php 
                            if($i == 0){
                                echo "row-2 first-sent";
                            } else {
                                echo "row-2";
                            };
                        ?>">
                            <td class="item_name"><?php checkLang('Money Spent', '出金');?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['total_sent'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                            <td><?php echo $_SESSION['sent_to'][$i];?></td>
                            <td><?php echo $_SESSION['content_sent'][$i];?></td>
                        </tr>
                    <?php endfor;?>
                    <!-- 出金の列が１０より少ない場合、列の数が１０になるまで追加-->
                    <?php
                        if(count($_SESSION['sent_to']) < 10) {
                            $num_of_blank_sent_to = 10 - count($_SESSION['sent_to']);
                            for($i = 0; $i < $num_of_blank_sent_to; $i++) { ?>
                                <tr class="row-2">
                                    <td class="item_name"><?php checkLang('Money Spent', '出金');?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                <?php else :?>
                    <?php for($i = 0; $i < 10; $i++): ?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Spent', '出金');?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                <?php endif; ?>


                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Total Spent', '支払い計');?></td>
                    <td class="number_cell"><?php echo number_format(isset($_SESSION['total_sent']) ? array_sum($_SESSION['total_sent']) : 0);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                $sum_of_received = isset($_SESSION['total_received']) ? array_sum($_SESSION['total_received']) : 0;
                $sum_of_sent = isset($_SESSION['total_sent']) ? array_sum($_SESSION['total_sent']) : 0;

                $reji_zankei = $_SESSION['change'] + $_SESSION['earning'] + $sum_of_received - $sum_of_sent;
                ?>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Total Balance at Cashier', 'レジ残計');?></td>
                    <td class="number_cell"><?php echo number_format($reji_zankei);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                    $kabusoku = $reji_zankei - $_SESSION['jisen_total'];
                ?>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Deficiency & Excess', '現金過不足');?></td>
                    <td class="number_cell"><?php echo number_format($kabusoku);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Actual Total Balance', '実残合計');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['jisen_total']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Next Day Change', '翌日つり銭');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_change']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Next Day Deposit', '翌日預入');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_deposit']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="edit-button-container">
                <button class="edit firstTable" id="edit-section-btn"><?php checkLang('Edit', 'ここまで編集');?></button>
            </div>


            <table>
            <?php
                    
                $other_service_total = isset($_SESSION['other_how_much']) ? array_sum($_SESSION['other_how_much']) : 0;
                    
                $shokuji = $_SESSION['prem_total'] + $_SESSION['for_selling_total'] +
                $_SESSION['thousand_total'] + $_SESSION['five_total'] + 
                $_SESSION['two_total'] + $other_service_total;
                ?>

                <tr class="table-2-row-1">
                    <td></td>
                    <td class="item_name"><?php checkLang('Total', '食事券計（その他含む）');?></td>
                    <td class="number_cell"><?php echo number_format($shokuji);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="table-2-row-2">
                    <td></td>
                    <td class="item_name"><?php checkLang('Premium', 'プレミアム食事券');?></td>
                    <td class="item_name"><?php checkLang('For Sale', '販売用回収');?></td>
                    <td class="item_name"><?php checkLang('Service', 'サービス用回収');?></td>
                </tr>

                <tr class="table-2-row-3">
                    <td class="item_name"><?php checkLang('$1,000 Tickets', '千円券');?></td>
                    <td><?php echo $_SESSION['prem_count'];?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['prem_total']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td><?php echo $_SESSION['for_selling_count'];?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['for_selling_total']);?><?php if($lang === 'jp') echo '円';?></td>
                    <td><?php echo $_SESSION['thousand_count'];?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['thousand_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="table-2-row-4">
                    <td class="item_name"><?php checkLang('$500 Tickets', '500円券');?></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['five_count'];?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['five_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="table-2-row-5">
                    <td class="item_name"><?php checkLang('$200 Tickets', '200円券');?></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['two_count'];?><?php if($lang === 'jp') echo '円';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['two_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

            </table>

            <table>
            <div class="table-title"><?php checkLang('Other Meal Tickets', 'その他食事券');?></div>
            <?php if(is_null($_SESSION['other_name']) || empty($_SESSION['other_name'])) :?>
                <tr>
                    <td class="no_client"><?php checkLang('No Data', 'データなし');?></td>
                </tr>
            <?php else :?>
                <?php for($i = 0; $i < count($_SESSION['other_name']); $i++) :?>
                    <tr class="other_service_row">
                        <td class="other_name"><?php echo $_SESSION['other_name'][$i]; ?></td>
                        <td class="other_count"><?php echo $_SESSION['other_count'][$i]; ?></td>
                        <td><?php if($lang === 'jp') echo '枚';?></td>
                        <td class="other_how_much"><?php echo $_SESSION['other_how_much'][$i]; ?></td>
                        <td><?php if($lang === 'jp') echo '円';?></td>
                    </tr>
                <?php endfor; ?>
            <?php endif ;?>
            </table>


            <div class="edit-button-container">
            <button class="edit secondTable" id="edit-section-btn"><?php checkLang('Edit', 'ここまで編集');?></button>
            </div>


            <table>
                <div class="table-title"><?php checkLang('Accounts Receivable-Trade', '売掛金');?></div>

                <?php if(is_null($_SESSION['client_name']) || empty($_SESSION['client_name'])): ?>
                    <tr><td class="no_client"><?php checkLang('No Data', 'データなし');?></td></tr>
                <?php else:?>
                    <?php for($i = 0; $i < count($_SESSION['client_name']); $i++):?>
                        <tr class="client-row">
                            <td><?php echo $_SESSION['client_name'][$i];?><?php if($lang === 'jp') echo '様';?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['urikake_total'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                        </tr>
                    <?php endfor;?>
                <?php endif ;?>
                
            </table>
            <div class="edit-button-container">
            <button class="edit thirdTable" id="edit-section-btn"><?php checkLang('Edit', 'ここまで編集');?></button>
            </div>


            <table>
            <tr class="other-total">
                    <th><?php checkLang('Type', '種別');?></th>
                    <th><?php checkLang('Count', '件数');?></th>
                    <th><?php checkLang('Amount', '金額');?></th>
                </tr>
                
                <?php if(isset($_SESSION['dc_how_much']) && !empty($_SESSION['dc_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                        <tr class="other-total">
                            <td>DC</td>
                            <td>1<?php if($lang === 'jp') echo '件';?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['dc_how_much'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                        </tr>
                    <?php endfor;?>
                <?php endif; ?>

                <?php
                    $count_of_dc = is_null($_SESSION['dc_how_much']) ? 0 : count($_SESSION['dc_how_much']);
                    $sum_of_dc = is_null($_SESSION['dc_how_much']) ? 0 : array_sum($_SESSION['dc_how_much']);
                ?>

                <tr class="other-total sum">
                    <td><?php checkLang('DC Total', 'DC合計');?></td>
                    <td><?php echo $count_of_dc; ?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($sum_of_dc); ?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <?php if(isset($_SESSION['jcb_how_much']) && !empty($_SESSION['jcb_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                        <tr class="other-total">
                            <td>JCB</td>
                            <td>1<?php if($lang === 'jp') echo '件';?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['jcb_how_much'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                        </tr>
                    <?php endfor;?>
                <?php endif; ?>

                <?php
                    $count_of_jcb = is_null($_SESSION['jcb_how_much']) ? 0 : count($_SESSION['jcb_how_much']);
                    $sum_of_jcb = is_null($_SESSION['jcb_how_much']) ? 0 : array_sum($_SESSION['jcb_how_much']);
                ?>

                <tr class="other-total sum">
                    <td><?php checkLang('JCB Total', 'JCB合計');?></td>
                    <td><?php echo $count_of_jcb; ?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($sum_of_jcb);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td>PayPay</td>
                    <td><?php echo $_SESSION['paypay_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['paypay_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">nanaco</td>
                    <td><?php echo $_SESSION['nanaco_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['nanaco_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">edy</td>
                    <td><?php echo $_SESSION['edy_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['edy_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name"><?php checkLang('Transportation', '交通');?> IC</td>
                    <td><?php echo $_SESSION['transport_ic_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['transport_ic_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">Quick Pay</td>
                    <td><?php echo $_SESSION['quick_pay_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['quick_pay_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">WAON</td>
                    <td><?php echo $_SESSION['waon_count'];?><?php if($lang === 'jp') echo '件';?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['waon_total']);?><?php if($lang === 'jp') echo '円';?></td>
                </tr>

                <?php if(isset($_SESSION['other_e_money_name'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['other_e_money_name']); $i++): ?>
                        <tr class="other-total sum">
                            <td class="item_name"><?php echo $_SESSION['other_e_money_name'][$i];?></td>
                            <td><?php echo $_SESSION['other_e_money_count'][$i];?><?php if($lang === 'jp') echo '件';?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['other_e_money_amount'][$i]);?><?php if($lang === 'jp') echo '円';?></td>
                        </tr>
                    <?php endfor; ?>
                <?php endif; ?>
            </table>
            <div class="edit-button-container">
            <button class="edit fifthTable center" id="edit-section-btn"><?php checkLang('Edit', 'ここまで編集');?></button>
            </div>

        </div>

        <div class="submit-container">
        <a href="date.php" class="back_to_date"><?php checkLang('Back', '戻る');?></a>
        <a href="submit.php" id="send-btn" class="send-data"><?php checkLang('Send', '送信');?></a>
        </div>

    </div>



    <!-- modal for name -->
    <div class="ui modal name">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            <?php checkLang('User Name', '記入者');?>
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="field">
                    <input type="text" name="name" value="<?php echo $_SESSION['name'];?>" required>
                </div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <button class="ui button" type="submit"><?php checkLang('Save Changes', '編集を完了');?></button>
            </form>
        </div>
    </div>

    <!-- modal for first-table -->
    <div class="ui modal firstTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            <?php checkLang('Change - Next Day Deposit', '釣り銭〜翌日預け入れ');?>
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="edit_section">
                    <div class="field">
                        <label for="change"><?php checkLang('Change', '釣り銭');?></label>
                        <input type="number" name="change" id="change" value="<?php echo $_SESSION['change'];?>" required>
                    </div>
                    <div class="field">
                        <label for="earning"><?php checkLang('Cash Sale', '現金売上');?></label>
                        <input type="number" name="earning" id="earning" value="<?php echo $_SESSION['earning'];?>" required>
                    </div>
                </div>
                
                <div class="received_form_container edit_section">
                <?php if(isset($_SESSION['received_from'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="total_received"><?php checkLang('Amount of Money Received', '入金額');?></label>
                                <input type="number" id="total_received" name="total_received[]" value="<?php echo $_SESSION['total_received'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="received_from"><?php checkLang('Client', '入金相手');?></label>
                                <input type="text" id="received_from" name="received_from[]" value="<?php echo $_SESSION['received_from'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="content_received"><?php checkLang('Items & Services', '入金内容');?></label>
                                <input type="text" id="content_received" name="content_received[]" value="<?php echo $_SESSION['content_received'][$i];?>" required>
                            </div>
                            <img class="delete_received" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                <?php endif; ?>
                </div>
                <div><button class="add-received"><?php checkLang('Add', '入金を追加');?></button></div>
                <div class="sent-form-container edit_section">
                <?php if(isset($_SESSION['sent_to'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="total_sent"><?php checkLang('Money Spent', '出金額');?></label>
                                <input type="number" id="total_sent" name="total_sent[]" value="<?php echo $_SESSION['total_sent'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="sent-to"><?php checkLang('Where Purchase Was Made', '出金先');?></label>
                                <input type="text" id="sent_to" name="sent_to[]" value="<?php echo $_SESSION['sent_to'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="content_sent"><?php checkLang('Items & Services', '出金内容');?></label>
                                <input type="text" id="content_sent" name="content_sent[]" value="<?php echo $_SESSION['content_sent'][$i];?>" required>
                            </div>
                            <img class="delete_sent" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                <?php endif; ?>
                </div>
                <div><button class="add-sent"><?php checkLang('Add', '出金を追加');?></button></div>
                <div class="edit_section">
                    <div class="field">
                        <label for="next_day_change"><?php checkLang('Next Day Change', '翌日つり銭');?></label>
                        <input type="number" id="next_day_change" name="next_day_change" value="<?php echo $_SESSION['next_day_change'];?>" required>
                    </div>
                    <div class="field">
                        <label for="jisen_total"><?php checkLang('Actual Total Balance', '実践合計');?></label>
                        <input type="number" id="jisen_total" name="jisen_total" value="<?php echo $_SESSION['jisen_total'];?>" required>
                    </div>
                    <div class="field">
                        <label for="next_day_deposit"><?php checkLang('Next Day Deposit', '翌日預入');?></label>
                        <input type="number" id="next_day_deposit" name="next_day_deposit" value="<?php echo $_SESSION['next_day_deposit'];?>" required>
                    </div>
                    </div>

                    <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                    <input type="hidden" name="first_modal" value="<?php echo true;?>">
                
                <button class="ui button" type="submit"><?php checkLang('Save Changes', '編集を完了');?></button>
            </form>
        </div>
    </div>

    <!-- modal for secondTable -->
    <div class="ui modal secondTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            <?php checkLang('Meal Tickets', '食事券');?>
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="edit_section">
                    <div class="field">
                        <label for="prem_count"><?php checkLang('Premium Count', 'プレミアム枚数');?></label>
                        <input type="number" name="prem_count" value="<?php echo $_SESSION['prem_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="prem_total"><?php checkLang('Premium Total', 'プレミアム金額');?></label>
                        <input type="number" name="prem_total" value="<?php echo $_SESSION['prem_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="for_selling_count"><?php checkLang('For Sale Count', '販売用枚数');?></label>
                        <input type="number" name="for_selling_count" value="<?php echo $_SESSION['for_selling_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="for_selling_total"><?php checkLang('For Sale Total', '販売用金額');?></label>
                        <input type="number" name="for_selling_total" value="<?php echo $_SESSION['for_selling_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="thousand_count"><?php checkLang('$1,000 Ticket Count', 'サービス1000円枚数');?></label>
                        <input type="number" name="thousand_count" value="<?php echo $_SESSION['thousand_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="five_count"><?php checkLang('$500 Ticket Count', 'サービス500円枚数');?></label>
                        <input type="number" name="five_count" value="<?php echo $_SESSION['five_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="two_count"><?php checkLang('$200 Ticket Count', 'サービス200円枚数');?></label>
                        <input type="number" name="two_count" value="<?php echo $_SESSION['two_count'];?>" required>
                    </div>
                </div>
                <h3 class="ui header"><?php checkLang('Other Meal Tickets', 'その他の食事券');?><h3>
                <div class="other_service_container edit_section">
                <?php if(isset($_SESSION['other_name'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['other_name']); $i++): ?>
                        <div class="each_section">
                            <div class="field">
                                <label for="other_name"><?php checkLang('Ticket Name', '項目名');?></label>
                                <input type="text" id="other_name" name="other_name[]" value="<?php echo $_SESSION['other_name'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_count"><?php checkLang('Count', '枚数');?></label>
                                <input type="number" id="other_count" name="other_count[]" value="<?php echo $_SESSION['other_count'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_how_much"><?php checkLang('Total', '金額');?></label>
                                <input type="text" id="other_how_much" name="other_how_much[]" value="<?php echo $_SESSION['other_how_much'][$i];?>" required>
                            </div>
                            <img class="delete_other_service" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                <?php endif; ?>
                </div>
                <div><button class="add-other-service"><?php checkLang('Add Other Meal Ticket', 'その他食事券を追加');?></button></div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <input type="hidden" value=<?php echo true;?> name="second_modal">
                <button class="ui button" type="submit"><?php checkLang('Save Changes', '編集を完了');?></button>
            </form>
        </div>
    </div>

    <!-- modal for thirdTable -->
    <div class="ui modal thirdTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            <?php checkLang('Accounts Receivable-Trade', '売掛金');?>
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="client_form_container">
                <?php if(isset($_SESSION['client_name'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['client_name']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="client_name"><?php checkLang('Client', 'お客様');?></label>
                                <input type="text" name="client_name[]" id="client_name" value="<?php echo $_SESSION['client_name'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="urikake_total"><?php checkLang('Amount', '金額');?></label>
                                <input type="number" name="urikake_total[]" id="urikake_total" value="<?php echo $_SESSION['urikake_total'][$i];?>" required>
                            </div>
                            <img class="delete_client" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                <?php endif; ?>
                </div>
                <div><button  class="add_client"><?php checkLang('Add', '追加');?></button></div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <input type="hidden" name="third_modal" value="<?php echo true;?>">
                <button class="ui button" type="submit"><?php checkLang('Save Changes', '編集を完了');?></button>
            </form>
        </div>
    </div>

    

    <!-- modal for fourthTable -->
    <div class="ui modal fifthTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            <?php checkLang('Others', 'その他');?>
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="dc_form_container edit_section">
                <?php if(isset($_SESSION['dc_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                        <div class="field">
                        <img class="delete_dc" src="https://img.icons8.com/ios-glyphs/30/000000/multiply.png"/>
                            <label for="dc_how_much">DC</label>
                            <input type="number" name="dc_how_much[]" value="<?php echo $_SESSION['dc_how_much'][$i];?>" required>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
                </div>
                <div><button class="edit_add_dc"><?php checkLang('Add DC', 'DCを追加');?></button></div>
                <div class="jcb_form_container edit_section">
                <?php if(isset($_SESSION['jcb_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                        <div class="field">
                            <img class="delete_jcb" src="https://img.icons8.com/ios-glyphs/30/000000/multiply.png"/>
                            <label for="jcb_how_much">JCB</label>
                            <input type="number" name="jcb_how_much[]" value="<?php echo $_SESSION['jcb_how_much'][$i];?>" required>
                        </div>
                    <?php endfor;?>
                <?php endif; ?>
                </div>
                <div><button class="edit_add_jcb"><?php checkLang('Add JCB', 'JCBを追加');?></button></div>
                <div class="edit_section">
                    <div class="field">
                        <label for="paypay_count">PAYPAY <?php checkLang('Count', '件数');?></label>
                        <input type="number" id="paypay_count" name="paypay_count" value="<?php echo $_SESSION['paypay_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="paypay_total">PAYPAY <?php checkLang('Total', '合計額');?></label>
                        <input type="number" id="paypay_total" name="paypay_total" value="<?php echo $_SESSION['paypay_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="nanaco_count">nanaco <?php checkLang('Count', '件数');?></label>
                        <input type="number" name="nanaco_count" id="nanaco_count" value="<?php echo $_SESSION['nanaco_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="nanaco_total">nanaco <?php checkLang('Total', '金額');?></label>
                        <input type="number" name="nanaco_total" id="nanaco_total" value="<?php echo $_SESSION['nanaco_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="edy_count">edy <?php checkLang('Count', '件数');?></label>
                        <input type="number" name="edy_count" id="edy_count" value="<?php echo $_SESSION['edy_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="edy_total">edy <?php checkLang('Total', '金額');?></label>
                        <input type="number" name="edy_total" id="edy_total" value="<?php echo $_SESSION['edy_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="transport_ic_count"><?php checkLang('Transportation IC Count', '交通IC件数');?></label>
                        <input type="number" name="transport_ic_count" id="transport_ic_count" value="<?php echo $_SESSION['transport_ic_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="transport_ic_total"><?php checkLang('Transportation IC Total', '交通IC金額');?></label>
                        <input type="number" name="transport_ic_total" id="transport_ic_total" value="<?php echo $_SESSION['transport_ic_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="quick_pay_count">Quick Pay <?php checkLang('Count', '件数');?></label>
                        <input type="number" name="quick_pay_count" id="quick_pay_count" value="<?php echo $_SESSION['quick_pay_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="quick_pay_total">Quick Pay <?php checkLang('Total', '金額');?></label>
                        <input type="number" name="quick_pay_total" id="quick_pay_total" value="<?php echo $_SESSION['quick_pay_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="waon_count">WAON <?php checkLang('Count', '件数');?></label>
                        <input type="number" name="waon_count" id="waon_count" value="<?php echo $_SESSION['waon_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="waon_total">WAON <?php checkLang('Total', '金額');?></label>
                        <input type="number" name="waon_total" id="waon_total" value="<?php echo $_SESSION['waon_total'];?>" required>
                    </div>
                </div>
                <div class="other_e_money_edit_container edit_section">
                <?php if(isset($_SESSION['other_e_money_name'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['other_e_money_name']); $i++):?>
                        <div class="each_section">
                            <img class="delete_other_e_money" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                            <div class="field">
                                <label for="other_e_money_name"><?php checkLang('E Money Name', '電子マネー名');?></label>
                                <input type="text" id="other_e_money_name" name="other_e_money_name[]" value="<?php echo $_SESSION['other_e_money_name'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_e_money_count"><?php checkLang('Count', '枚数');?></label>
                                <input type="number" id="other_e_money_count" name="other_e_money_count[]" value="<?php echo $_SESSION['other_e_money_count'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="other_e_money_amount"><?php checkLang('Total', '金額');?></label>
                                <input type="number" id="other_e_money_amount" name="other_e_money_amount[]" value="<?php echo $_SESSION['other_e_money_amount'][$i];?>" required>
                            </div>
                        </div>
                    <?php endfor ;?>
                <?php endif; ?>
                </div>
                
                <div><button class="add_other_e_money"><?php checkLang('Add E Money', '電子マネーを追加');?></button></div>

                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <input type="hidden" name="fourth_modal" value="<?php echo true;?>">
                
                <button class="ui button" type="submit"><?php checkLang('Save Changes', '編集を完了');?></button>
            </form>
        </div>
    </div>


    <script>

        $(document).ready(function(){
            var edit = $(".edit");

            $(edit).on('click', function(e){
                e.preventDefault();

                if($(this).hasClass('name')){
                    $('.ui.modal.name').modal('show');
                } else if($(this).hasClass('firstTable')) {
                    $('.ui.modal.firstTable').modal('show');
                } else if($(this).hasClass('secondTable')) {
                    $('.ui.modal.secondTable').modal('show');
                } else if($(this).hasClass('thirdTable')) {
                    $('.ui.modal.thirdTable').modal('show');
                } else if($(this).hasClass('fourthTable')) {
                    $('.ui.modal.fourthTable').modal('show');
                } else if($(this).hasClass('fifthTable')) {
                    $('.ui.modal.fifthTable').modal('show');
                }

            });

            /*指定言語で表示変える*/
            var lang = '<?php echo $lang; ?>';
            

            /*received editing*/
            var amountReceived = lang === 'eng' ? 'Amount of Money Received' : '入金額';
            var receivedFrom = lang === 'eng' ? 'Client' : '入金先';
            var receivedContent = lang === 'eng' ? 'Items & Services' : '入金内容';

            var add_received = $(".add-received");
            var received_form_container = $(".received_form_container");
            $(add_received).on('click', function(e){
                e.preventDefault();
                $(received_form_container).append(
                    '<div class="each_section">' +
                        '<div class="field">' +
                            '<label for="total_received">' + amountReceived + '</label>' +
                            '<input type="number" id="total_received" name="total_received[]" required>' +
                        '</div>' +
                        '<div class="field">' +
                            '<label for="received_from">' + receivedFrom + '</label>' +
                            '<input type="text" id="received_from" name="received_from[]" required>' +
                        '</div>' +
                        '<div class="field">' +
                            '<label for="content_received">' + receivedContent + '</label>' +
                            '<input type="text" id="content_received" name="content_received[]" required>' +
                        '</div>'+
                        '<img class="delete_received" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>'
                );
            });

            $(received_form_container).on('click', '.delete_received', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });

            /*sent editing*/
            var amountSent = lang === 'eng' ? 'Amount of Money Sent' : '出金額';
            var sentTo = lang === 'eng' ? 'Where Purchase Was Made' : '出金先';
            var contentSent = lang === 'eng' ? 'Items & Services' : '出金内容';

            var add_sent = $(".add-sent");
            var sent_form_container = $(".sent-form-container");
            $(add_sent).on('click', function(e){
                e.preventDefault();
                $(sent_form_container).append(
                    '<div class="each_section">' +
                            '<div class="field">' +
                                '<label for="total_sent">' + amountSent + '</label>' +
                                '<input type="number" id="total_sent" name="total_sent[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="sent-to">' + sentTo + '</label>' +
                                '<input type="text" id="sent_to" name="sent_to[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="content_sent">' + contentSent + '</label>' +
                                '<input type="text" id="content_sent" name="content_sent[]" required>' +
                            '</div>' +
                            '<img class="delete_sent" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>' 
                );
            });

            $(sent_form_container).on('click', '.delete_sent', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });

            /*other service editing*/
            var otherTicketName  = lang === 'eng' ? 'Ticket Name' : '項目名';
            var otherTicketCount = lang === 'eng' ? 'Count' : '枚数';
            var otherTicketTotal = lang === 'eng' ? 'Total' : '金額';

            var add_other_service = $(".add-other-service");
            var other_service_container = $(".other_service_container");
            $(add_other_service).on('click', function(e){
                e.preventDefault();
                $(other_service_container).append(
                    '<div class="each_section">' +
                            '<div class="field">' +
                                '<label for="other_name">' + otherTicketName + '</label>' +
                                '<input type="text" id="other_name" name="other_name[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="other_count">' + otherTicketCount + '</label>' +
                                '<input type="number" id="other_count" name="other_count[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="other_how_much">' + otherTicketTotal + '</label>' +
                                '<input type="text" id="other_how_much" name="other_how_much[]" required>' +
                            '</div>' +
                            '<img class="delete_other_service" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                        '</div>'
                );
            });

            $(other_service_container).on('click', '.delete_other_service', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });

            //client editing
            var clientName = lang === 'eng' ? 'Client' : 'お客様';
            var clientTotal = lang === 'eng' ? 'Amount' : '金額';

            var add_client = $(".add_client");
            var client_form_container = $(".client_form_container");
            $(add_client).on('click', function(e) {
                e.preventDefault();
                $(client_form_container).append(
                    '<div class="each_section">' +
                        '<div class="field">' +
                            '<label for="client_name">' + clientName + '</label>' +
                            '<input type="text" name="client_name[]" id="client_name" required>' +
                        '</div>' +
                        '<div class="field">' +
                           '<label for="urikake_total">' + clientTotal + '</label>' +
                            '<input type="number" name="urikake_total[]" id="urikake_total" required>' +
                        '</div>'  +
                        '<img class="delete_client" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>'
                );
            });

            $(client_form_container).on('click', '.delete_client', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            })

            //dc editing
            var add_dc = $('.edit_add_dc');
            var dc_form_container = $('.dc_form_container');
            $(add_dc).on('click', function(e) {
                e.preventDefault();
                $(dc_form_container).append(
                    '<div class="field">' +
                        '<label for="dc_how_much">DC</label>' +
                        '<img class="delete_dc" src="https://img.icons8.com/ios-glyphs/25/000000/multiply.png"/>' +
                        '<input type="number" name="dc_how_much[]" required>' +
                    '</div>'
                );
            });

            $(dc_form_container).on('click', '.delete_dc', function(e){
                e.preventDefault();
                $(this).parent('.field').remove();
            });

            //jcb editing
            var add_jcb = $('.edit_add_jcb');
            var jcb_form_container = $('.jcb_form_container');
            $(add_jcb).on('click', function(e) {
                e.preventDefault();
                $(jcb_form_container).append(
                    '<div class="field">' +
                            '<label for="jcb_how_much">JCB</label>' +
                            '<img class="delete_jcb" src="https://img.icons8.com/ios-glyphs/25/000000/multiply.png"/>' +
                            '<input type="number" name="jcb_how_much[]" required>' +
                        '</div>'
                );
            });

            $(jcb_form_container).on('click', '.delete_jcb', function(e){
                e.preventDefault();
                $(this).parent('.field').remove();
            });

            /*other e money editing*/
            var eMoneyName = lang === 'eng' ? 'E Money Name' : '電子マネー名';
            var eMoneyCount = lang === 'eng' ? 'Count' : '枚数';
            var eMoneyTotal = lang === 'eng' ? 'Total' : '金額';

            var add_other_e_money = $(".add_other_e_money");
            var other_e_money_edit_container = $(".other_e_money_edit_container");
            $(add_other_e_money).on('click', function(e){
                e.preventDefault();
                $(other_e_money_edit_container).append(
                    `<div class="each_section">
                        <img class="delete_other_e_money" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        <div class="field">
                            <label for="other_e_money_name">${eMoneyName}</label>
                            <input type="text" id="other_e_money_name" name="other_e_money_name[]" required>
                        </div>
                        <div class="field">
                            <label for="other_e_money_count">${eMoneyCount}</label>
                            <input type="number" id="other_e_money_count" name="other_e_money_count[]" required>
                        </div>
                        <div class="field">
                            <label for="other_e_money_amount">${eMoneyTotal}</label>
                            <input type="number" id="other_e_money_amount" name="other_e_money_amount[]" required>
                        </div>
                    </div>`
                );
            });

            $(other_e_money_edit_container).on('click', '.delete_other_e_money', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });


        });

        

    </script>
</body>
</html>
<?php
$_SESSION['previousURI'] = $_SERVER['REQUEST_URI'];
?>
