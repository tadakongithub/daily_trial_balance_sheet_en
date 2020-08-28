<?php
session_start();

//push data to database
require '../db.php';


$date = $_SESSION['date'];
$branch = $_SESSION['branch'];
$name = $_SESSION['name'];
$change = $_SESSION['change'];
$earning = $_SESSION['earning'];
if(isset($_SESSION['received_from'])){
    $received_from = serialize($_SESSION['received_from']);
    $total_received = serialize($_SESSION['total_received']);
    $content_received = serialize($_SESSION['content_received']);
} else {
    $received_from = serialize(array());
    $total_received = serialize(array());
    $content_received = serialize(array());
}
if(isset($_SESSION['sent_to'])){
    $sent_to = serialize($_SESSION['sent_to']);
    $total_sent = serialize($_SESSION['total_sent']);
    $content_sent = serialize($_SESSION['content_sent']);
} else {
    $sent_to = serialize(array());
    $total_sent = serialize(array());
    $content_sent = serialize(array());
}

$next_day_change = $_SESSION['next_day_change'];
$jisen_total = $_SESSION['jisen_total'];
$next_day_deposit = $_SESSION['next_day_deposit'];
$prem_count = $_SESSION['prem_count'];
$prem_total = $_SESSION['prem_total'];
$for_selling_count = $_SESSION['for_selling_count'];
$for_selling_total = $_SESSION['for_selling_total'];
$thousand_count = $_SESSION['thousand_count'];
$thousand_total = $_SESSION['thousand_total'];
$five_count = $_SESSION['five_count'];
$five_total = $_SESSION['five_total'];
$two_count = $_SESSION['two_count'];
$two_total = $_SESSION['two_total'];
if(isset($_SESSION['other_name'])) {
    $other_name = serialize($_SESSION['other_name']);
    $other_count = serialize($_SESSION['other_count']);
    $other_how_much = serialize($_SESSION['other_how_much']);
} else {
    $other_name = serialize(array());
    $other_count = serialize(array());
    $other_how_much = serialize(array());
}
if(isset($_SESSION['dc_how_much'])){
    $dc_how_much = serialize($_SESSION['dc_how_much']);
} else {
    $dc_how_much = serialize(array());
}
if(isset($_SESSION['jcb_how_much'])){
    $jcb_how_much = serialize($_SESSION['jcb_how_much']);
} else {
    $jcb_how_much = serialize(array());
}

$paypay_count = $_SESSION['paypay_count'];
$paypay_total = $_SESSION['paypay_total'];
$nanaco_count = $_SESSION['nanaco_count'];
$nanaco_total = $_SESSION['nanaco_total'];
$edy_count = $_SESSION['edy_count'];
$edy_total = $_SESSION['edy_total'];
$transport_ic_count = $_SESSION['transport_ic_count'];
$transport_ic_total = $_SESSION['transport_ic_total'];
$quick_pay_count = $_SESSION['quick_pay_count'];
$quick_pay_total = $_SESSION['quick_pay_total'];
$waon_count = $_SESSION['waon_count'];
$waon_total = $_SESSION['waon_total'];
if(isset($_SESSION['other_e_money_name'])) {
    $other_e_money_name = serialize($_SESSION['other_e_money_name']);
    $other_e_money_count = serialize($_SESSION['other_e_money_count']);
    $other_e_money_amount = serialize($_SESSION['other_e_money_amount']);
} else {
    $other_e_money_name = serialize(array());
    $other_e_money_count = serialize(array());
    $other_e_money_amount = serialize(array());
}
if(isset($_SESSION['client_name'])) {
    $client_name = serialize($_SESSION['client_name']);
    $urikake_total = serialize($_SESSION['urikake_total']);
} else {
    $client_name = serialize(array());
    $urikake_total = serialize(array());
}

$time_created = time();

$query = "INSERT INTO okasato (branch,
    name, date, change1, earning,
    received_from, total_received, content_received,
    sent_to, total_sent, content_sent,
    next_day_change, jisen_total, next_day_deposit,
    prem_count, prem_total,
    for_selling_count, for_selling_total,
    thousand_count, thousand_total,
    five_count, five_total,
    two_count, two_total,
    other_name, other_count, other_how_much,
    dc_how_much, jcb_how_much,
    paypay_count, paypay_total,
    nanaco_count, nanaco_total,
    edy_count, edy_total,
    transport_ic_count, transport_ic_total,
    quick_pay_count, quick_pay_total,
    waon_count, waon_total,
    other_e_money_name, other_e_money_count, other_e_money_amount,
    client_name, urikake_total,
    time_created
) VALUES (:branch,
    :name, :date, :change, :earning,
    :received_from, :total_received, :content_received,
    :sent_to, :total_sent, :content_sent,
    :next_day_change, :jisen_total,:next_day_deposit,
    :prem_count, :prem_total,
    :for_selling_count, :for_selling_total,
    :thousand_count, :thousand_total,
    :five_count, :five_total,
    :two_count, :two_total,
    :other_name, :other_count, :other_how_much,
    :dc_how_much, :jcb_how_much,
    :paypay_count, :paypay_total,
    :nanaco_count, :nanaco_total,
    :edy_count, :edy_total,
    :transport_ic_count, :transport_ic_total,
    :quick_pay_count, :quick_pay_total,
    :waon_count, :waon_total,
    :other_e_money_name, :other_e_money_count, :other_e_money_amount,
    :client_name, :urikake_total,
    :time_created)";


$statement = $myPDO->prepare($query);
$statement->execute(array(
    ':branch' => $branch,
    ':name' => $name,
    ':date' => $date,
    ':change' => $change,
    ':earning' => $earning,
    ':received_from' => $received_from,
    ':total_received' => $total_received,
    ':content_received' => $content_received,
    ':sent_to' => $sent_to,
    ':total_sent' => $total_sent, 
    ':content_sent' => $content_sent,
    ':next_day_change' => $next_day_change,
    ':jisen_total' => $jisen_total,
    ':next_day_deposit' => $next_day_deposit,
    ':prem_count' => $prem_count,
    ':prem_total' => $prem_total,
    ':for_selling_count' => $for_selling_count,
    ':for_selling_total' => $for_selling_total,
    ':thousand_count' => $thousand_count,
    ':thousand_total' => $thousand_total,
    ':five_count' => $five_count,
    ':five_total' => $five_total,
    ':two_count' => $two_count,
    ':two_total' => $two_total,
    ':other_name' => $other_name,
    ':other_count' => $other_count,
    ':other_how_much' => $other_how_much,
    ':dc_how_much' => $dc_how_much,
    ':jcb_how_much' => $jcb_how_much,
    ':paypay_count' => $paypay_count,
    ':paypay_total' => $paypay_total,
    ':nanaco_count' => $nanaco_count,
    ':nanaco_total' => $nanaco_total,
    ':edy_count' => $edy_count,
    ':edy_total' => $edy_total,
    ':transport_ic_count' => $transport_ic_count,
    ':transport_ic_total' => $transport_ic_total,
    ':quick_pay_count' => $quick_pay_count,
    ':quick_pay_total' => $quick_pay_total,
    ':waon_count' => $waon_count,
    ':waon_total' => $waon_total,
    ':other_e_money_name' => $other_e_money_name,
    ':other_e_money_count' => $other_e_money_count,
    ':other_e_money_amount' => $other_e_money_amount,
    ':client_name' => $client_name,
    ':urikake_total' => $urikake_total,
    ':time_created' => $time_created
));

//destroy session
foreach($_SESSION as $key => $val)
{
    if ($key !== 'logged_in' && $key !== 'branch')
    {
      unset($_SESSION[$key]);
    }
}

//redirect to index.php
header('Location: ../success.php');

?>
