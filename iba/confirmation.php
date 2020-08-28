<?php

    session_start();

    if($_SESSION['logged_in'] !== 'logged_in') {
        header('Location: ../index.php');
    }

    require '../lang.php';

    $_SESSION['went_to_confirmation'] = true;

    require 'back_to_top_handling.php';


    $unixtime = strtotime($_SESSION['date']);

    $year = date('Y', $unixtime);
    $month = date('m', $unixtime);
    $date = date('d', $unixtime);

?>
<html>
<head>
    <?php require 'form-head.php';?>
</head>
<body>

    <div class="confirmation-container">
        <h2 class="ui header"><?php checkLang('User Name', '記入者');?>：<?php echo $_SESSION['name'];?></h2>

        <h2 class="ui header"><?php checkLang('Date', '日付');?>：<?php checkLang($month . '-' . $date . ', ' . $year, $year . '年' . $month . '月' . $date . '日');?></h2>

        <h2 class="ui header"><?php checkLang('Branch', '店舗名');?>：<?php echo $_SESSION['branch'];?></h2>

        <div>
            <table>
                <tr class="row-1">
                    <td class="item_name"><?php checkLang('Change', '釣り銭');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['change']);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td class="item_name"><?php checkLang('Breakdown', '内訳');?></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Cash Sale', '現金売上');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['earning']);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td class="item_name"><?php checkLang('Clients', '購入取引先名');?></td>
                    <td class="item_name"><?php checkLang('Items & Services', '明細');?></td>
                </tr>

                <?php if(isset($_SESSION['received_from'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Received', '入金');?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['total_received'][$i]);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                            <td><?php echo $_SESSION['received_from'][$i];?></td>
                            <td><?php echo $_SESSION['content_received'][$i];?></td>
                        </tr>
                    <?php endfor;?>

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
                    <?php for($i = 0; $i < 5; $i++) :?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Received', '入金');?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor ;?>
                <?php endif ;?>

                <?php if(isset($_SESSION['sent_to'])) :?>
                    <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                        <tr class="<?php 
                            if($i == 0){
                                echo "row-2 first-sent";
                            } else {
                                echo "row-2";
                            };
                        ?>">
                            <td class="item_name"><?php checkLang('Money Spent', '出金');?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['total_sent'][$i]);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                            <td><?php echo $_SESSION['sent_to'][$i];?></td>
                            <td><?php echo $_SESSION['content_sent'][$i];?></td>
                        </tr>
                    <?php endfor;?>

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
                    <?php for($i = 0; $i < 10; $i++) :?>
                        <tr class="row-2">
                            <td class="item_name"><?php checkLang('Money Spent', '出金');?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor ;?>
                <?php endif ;?>

                <?php
                    if(isset($_SESSION['total_sent'])) {
                        $sum_of_total_sent = array_sum($_SESSION['total_sent']);
                    } else {
                        $sum_of_total_sent = 0;
                    }
                ?>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Total Spent', '支払い計');?></td>
                    <td class="number_cell"><?php echo number_format($sum_of_total_sent);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                    if(isset($_SESSION['total_received'])) {
                        $sum_of_total_received = array_sum($_SESSION['total_received']);
                    } else {
                        $sum_of_total_received = 0;
                    }

                    $reji_zankei = $_SESSION['change'] + $_SESSION['earning'] 
                    + $sum_of_total_received - $sum_of_total_sent;
                ?>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Total Balance at Cashier', 'レジ残計');?></td>
                    <td class="number_cell"><?php echo number_format($reji_zankei);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                    $kabusoku = $reji_zankei - $_SESSION['jisen_total'];
                ?>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Deficiency & Excess', '現金過不足');?></td>
                    <td class="number_cell"><?php echo number_format($kabusoku);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Actual Total Balance', '実残合計');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['jisen_total']);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Next Day Change', '翌日つり銭');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_change']);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name"><?php checkLang('Next Day Deposit', '翌日預入');?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_deposit']);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <div><?php checkLang('The sum of Meal Tickets includes journal\'s meal tickets', '※食事券計は、ジャーナルの食事券計と合致すること。');?></div>

            <table>

                <?php
                if(isset($_SESSION['other_how_much'])){
                    $other_service_total = array_sum($_SESSION['other_how_much']);
                } else {
                    $other_service_total = 0;
                }
                    
                    
                    $shokuji = $_SESSION['prem_total'] + $_SESSION['for_selling_total'] +
                    $_SESSION['thousand_total'] + $_SESSION['five_total'] + 
                    $_SESSION['two_total'] + $other_service_total;
                ?>

                <tr class="table-2-row-1">
                    <td></td>
                    <td class="item_name"><?php checkLang('Total of Meal Tickets', '食事券計（その他含む）');?></td>
                    <td class="number_cell"><?php echo number_format($shokuji);?><?php if($lang !== 'eng'){ echo '円';}; ?></td>
                </tr>

                <tr class="table-2-row-2">
                    <td></td>
                    <td class="item_name"><?php checkLang('Premium', 'プレミアム食事券');?></td>
                    <td class="item_name"><?php checkLang('For Sale', '販売用回収');?></td>
                    <td class="item_name"><?php checkLang('Service', 'サービス用回収');?></td>
                </tr>

                <tr class="table-2-row-3">
                    <td class="item_name"><?php checkLang('$1,000 Ticket', '1000円券');?></td>
                    <td><?php echo $_SESSION['prem_count'];?><?php if($lang !== 'eng') echo '円'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['prem_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                    <td><?php echo $_SESSION['for_selling_count'];?><?php if($lang !== 'eng') echo '枚'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['for_selling_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                    <td><?php echo $_SESSION['thousand_count'];?><?php if($lang !== 'eng') echo '枚'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['thousand_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="table-2-row-4">
                    <td class="item_name"><?php checkLang('$500 Ticket', '500円券');?></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['five_count'];?><?php if($lang !== 'eng') echo '枚'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['five_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="table-2-row-5">
                    <td class="item_name"><?php checkLang('$200 Ticket', '200円券');?></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['two_count'];?><?php if($lang !== 'eng') echo '枚'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['two_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

            </table>
            
            <table>
            <div class="table-title"><?php checkLang('Other Meal Tickets', 'その他食事券');?></div>
            <?php if(isset($_SESSION['other_name'])) :?>
                <?php for($i = 0; $i < count($_SESSION['other_name']); $i++) :?>
                    <tr class="other_service_row">
                        <td class="other_name"><?php echo $_SESSION['other_name'][$i];?></td>
                        <td class="other_count"><?php echo $_SESSION['other_count'][$i];?></td>
                        <td><?php if($lang !== 'eng') echo '枚'; ?></td>
                        <td class="other_how_much"><?php echo $_SESSION['other_how_much'][$i];?></td>
                        <td><?php if($lang !== 'eng') echo '円'; ?></td>
                    </tr>
                <?php endfor;?>
            <?php else :?>
                <tr>
                    <td class="no_client"><?php checkLang('No Data', 'データなし');?></td>
                </tr>
            <?php endif ;?>
            </table>

            <table>
                <div class="table-title"><?php checkLang('Accounts Receivable-Trade', '売掛金');?></div>

                    <?php if(isset($_SESSION['client_name'])):?>
                        <?php for($i = 0; $i < count($_SESSION['client_name']); $i++):?>
                            <tr class="client-row">
                                <td><?php echo $_SESSION['client_name'][$i];?><?php if($lang !== 'eng') echo '様'; ?></td>
                                <td class="number_cell"><?php echo number_format($_SESSION['urikake_total'][$i]);?><?php if($lang !== 'eng') echo '円'; ?></td>
                            </tr>
                        <?php endfor;?>
                    <?php else:?>
                        <tr><td class="no_client"><?php checkLang('No Data', 'データなし');?></td></tr>
                    <?php endif ;?>
                
            </table>

            <div class="table-title"><?php checkLang('Others', 'その他');?></div>

            <table>
                <tr class="other-total">
                    <th><?php checkLang('Type', '種別');?></th>
                    <th><?php checkLang('Count', '件数');?></th>
                    <th><?php checkLang('Amount', '金額');?></th>
                </tr>
                        
                <?php if(isset($_SESSION['dc_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                        <tr class="other-total">
                            <td>DC</td>
                            <td>1<?php if($lang !== 'eng') echo '件'; ?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['dc_how_much'][$i]);?><?php if($lang !== 'eng') echo '円'; ?></td>
                        </tr>
                    <?php endfor;?>
                <?php endif ;?>

                <?php
                    if(isset($_SESSION['dc_how_much'])) {
                        $sum_of_dc = array_sum($_SESSION['dc_how_much']);
                        $count_of_dc = count($_SESSION['dc_how_much']);
                    } else {
                        $sum_of_dc = 0;
                        $count_of_dc = 0;
                    }
                ?>

                <tr class="other-total sum">
                    <td><?php checkLang('DC Total', 'DC合計');?></td>
                    <td><?php echo $count_of_dc;?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($sum_of_dc);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <?php if(isset($_SESSION['jcb_how_much'])): ?>
                    <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                        <tr class="other-total">
                            <td>JCB</td>
                            <td>>1<?php if($lang !== 'eng') echo '件'; ?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['jcb_how_much'][$i]);?><?php if($lang !== 'eng') echo '円'; ?></td>
                        </tr>
                    <?php endfor;?>
                <?php endif ;?>

                <?php
                    if(isset($_SESSION['jcb_how_much'])) {
                        $sum_of_jcb = array_sum($_SESSION['jcb_how_much']);
                        $count_of_jcb = count($_SESSION['jcb_how_much']);
                    } else {
                        $sum_of_jcb = 0;
                        $count_of_jcb = 0;
                    }
                ?>

                <tr class="other-total sum">
                    <td><?php checkLang('JCB Total', 'JCB合計');?></td>
                    <td><?php echo $count_of_jcb;?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($sum_of_jcb);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td>PayPay</td>
                    <td><?php echo $_SESSION['paypay_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['paypay_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">nanaco</td>
                    <td><?php echo $_SESSION['nanaco_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['nanaco_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">Edy</td>
                    <td><?php echo $_SESSION['edy_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['edy_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name"><?php checkLang('Transportation', '交通');?> IC</td>
                    <td><?php echo $_SESSION['transport_ic_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['transport_ic_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">Quick Pay</td>
                    <td><?php echo $_SESSION['quick_pay_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['quick_pay_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">WAON</td>
                    <td><?php echo $_SESSION['waon_count'];?><?php if($lang !== 'eng') echo '件'; ?></td>
                    <td class="number_cell"><?php echo number_format($_SESSION['waon_total']);?><?php if($lang !== 'eng') echo '円'; ?></td>
                </tr>

                <?php if($_SESSION['other_e_money_name']): ?>
                    <?php for($i = 0; $i < count($_SESSION['other_e_money_name']); $i++):?>
                        <tr class="other-total sum">
                            <td class="item_name"><?php echo $_SESSION['other_e_money_name'][$i];?></td>
                            <td><?php echo $_SESSION['other_e_money_count'][$i];?><?php if($lang !== 'eng') echo '件'; ?></td>
                            <td class="number_cell"><?php echo number_format($_SESSION['other_e_money_amount'][$i]);?><?php if($lang !== 'eng') echo '円'; ?></td>
                        </tr>
                    <?php endfor ;?>
                <?php endif;?>
            </table>
        </div>

        <div class="submit-container">
            <a href="q_16.php" class="back_to_q16"><?php checkLang('Back', '戻る');?></a>
            <a id="send-btn" class="send-data" href="submit.php"><?php checkLang('Send', '送信');?></a>
        </div>
        <?php require 'back_to_top.php';?>
    </div>

    <?php require 'back_to_top_modal.php';?>

</body>
</html>
