<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use function FastRoute\TestFixtures\all_options_cached;

require './api/vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        // Database connection settings
        "db" => [
            "host" => "127.0.0.1",
            "dbname" => "hermes",
            "user" => "root",
            "pass" => "usbw"
        ],
    ],
];

$app = new \Slim\App($config);

// DIC configuration
$container = $app->getContainer()
;
// PDO database library 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=utf8",
        $settings['user'],
        $settings['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// Code Group 4
$app->get('/get_test', function (Request $request, Response $response, array $args) {
    $sql = "select * from book_log bl
    join reservation_info r
    on bl.bl_reservation = r.resinfo_id
    join agency a
    on r.resinfo_agency = a.agency_id 
    join rooms rm
    on bl.bl_room = rm.room_id
    join room_type rt 
    on rm.room_type = rt.rtype_id
    join room_status rs
    on bl.bl_status = rs.rstatus_id
    join room_view rv 
    on rm.room_view = rv.rview_id
    join building b
    on rm.room_building = b.building_id
    left join guest_info gi
    on bl.bl_ginfo = gi.ginfo_id where bl.bl_id = 1";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/ShowReservation/{bl_id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $sql = "select * from book_log bl
    join reservation_info r
    on bl.bl_reservation = r.resinfo_id
    join agency a
    on r.resinfo_agency = a.agency_id 
    join rooms rm
    on bl.bl_room = rm.room_id
    join room_type rt 
    on rm.room_type = rt.rtype_id
    join room_status rs
    on bl.bl_status = rs.rstatus_id
    join room_view rv 
    on rm.room_view = rv.rview_id
    join building b
    on rm.room_building = b.building_id
    join guest_info gi
    on bl.bl_ginfo = gi.ginfo_id
    where bl.bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/updateReservation', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $fname = $params['display_firstname'];
    $lname = $params['display_lastname'];
    $telno = $params['display_telephone'];
    $email = $params['display_email'];
    $comment = $params['display_note'];
    $id = $params['display_id'];

    $sql = "UPDATE reservation_info SET
    resinfo_first_name = '$fname',
    resinfo_last_name = '$lname',
    resinfo_email = '$email',
    resinfo_telno = '$telno',
    resinfo_comments = '$comment'
    WHERE resinfo_id = $id";
    try {
        $this->db->query($sql);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }
});
$app->post('/updateGuest', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $fname = $params['display_guest_firstname'];
    $lname = $params['display_guest_lastname'];
    $telno = $params['display_guest_telephone'];
    $email = $params['display_guest_email'];
    $id = $params['display_guest_id'];

    $sql = "UPDATE guest_info 
    set ginfo_first_name = '$fname', 
    ginfo_last_name = '$lname', 
    ginfo_email = '$email', 
    ginfo_telno = '$telno'
    WHERE ginfo_id = $id";

    try {
        $this->db->query($sql);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }
});
// End Code Group 4

// End Code Group 3
$app->get('/addroom/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT *from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    WHERE bl.bl_id = $id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/room', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * from rooms r join room_status rs on r.room_status = rs.rstatus_id WHERE rs.rstatus_eng='Avaliable'";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/saveadd/{bl_id}/{room_id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $room_id = $args['room_id'];
    $sql = "SELECT *from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    WHERE bl.bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $resinfo_id = ($sth[0]['resinfo_id']);
    $bl_ginfo = ($sth[0]['bl_ginfo']);
    $sql1 = "INSERT INTO reservation_info (resinfo_code, resinfo_first_name, resinfo_last_name, resinfo_telno, resinfo_email, resinfo_comments, resinfo_bookdate, resinfo_agency, resinfo_number, resinfo_flag )
    SELECT resinfo_code, resinfo_first_name, resinfo_last_name, resinfo_telno, resinfo_email, resinfo_comments, resinfo_bookdate, resinfo_agency, resinfo_number, resinfo_flag
    FROM reservation_info WHERE resinfo_id = $resinfo_id";
    $this->db->query($sql1);

    $sql2 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin, bl_timestamp, bl_room, bl_status, bl_price, bl_incbreakfast, bl_breakfast, bl_comment)
    SELECT bl_reservation, bl_ginfo, bl_checkin, bl_timestamp, '$room_id', bl_status, bl_price, bl_incbreakfast, bl_breakfast, bl_comment
    FROM book_log WHERE bl_id = $bl_id";
    $this->db->query($sql2);

    $sql3 = "INSERT INTO guest_info (ginfo_title_name, ginfo_first_name, ginfo_last_name, ginfo_passport_id, ginfo_birthday, ginfo_sex, ginfo_company, ginfo_nation, ginfo_email, ginfo_telno, ginfo_mail_addr, ginfo_bill_addr, ginfo_comment, ginfo_flag, ginfo_room, ginfo_in, ginfo_out, ginfo_night, ginfo_price, ginfo_rateplan, ginfo_full_price, ginfo_status, ginfo_price_total, ginfo_passport_image, ginfo_selfie_image, ginfo_credit_card, ginfo_payment, ginfo_tax, ginfo_empfront, ginfo_update, ginfo_checkin, ginfo_checkout, ginfo_tax_id, ginfo_name_bill)
    SELECT ginfo_title_name, ginfo_first_name, ginfo_last_name, ginfo_passport_id, ginfo_birthday, ginfo_sex, ginfo_company, ginfo_nation, ginfo_email, ginfo_telno, ginfo_mail_addr, ginfo_bill_addr, ginfo_comment, ginfo_flag, $room_id, ginfo_in, ginfo_out, ginfo_night, ginfo_price, ginfo_rateplan, ginfo_full_price, ginfo_status, ginfo_price_total, ginfo_passport_image, ginfo_selfie_image, ginfo_credit_card, ginfo_payment, ginfo_tax, ginfo_empfront, ginfo_update, ginfo_checkin, ginfo_checkout, ginfo_tax_id, ginfo_name_bill
    FROM guest_info WHERE ginfo_id = $bl_ginfo";
    $this->db->query($sql3);

    $sql4 = "UPDATE rooms set room_status ='2'where room_id = '$room_id'";
    $this->db->query($sql4);
});
// End Code Group 3

// Code Group 5
$app->get('/getdb/{idcheck}', function (Request $request, Response $response, array $args) {
    $id = $args['idcheck'];
    $sql = "Select * from guest_info join rooms
            on ginfo_room = room_id 
            join room_type
            on room_type = rtype_id
            join building
            on room_building = building_id
            join room_view
            on room_view = rview_id
            join book_log
            on bl_ginfo = ginfo_id
            where ginfo_id=".$id;
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    return $this->response->withJson($sth);
});
$app->get('/getNewRoom/{idcheck}', function (Request $request, Response $response, array $args) {
    $id = $args['idcheck'];
    $sql = "Select * from rooms join room_type 
            on room_type = rtype_id
            join building
            on room_building = building_id
            join room_view 
            on room_view = rview_id
            where room_id ='".$id."'";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/getRoom', function (Request $request, Response $response, array $args) {
    $sql = "Select * from rooms r join room_status rs on r.room_status = rs.rstatus_id where rs.rstatus_eng='Avaliable'";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/updateRoom/{bl_id}/{old_room}/{new_room}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $old_room = $args['old_room'];
    // print_r($old_room);
    // exit();
    $new_room = $args['new_room'];
    $sql = "UPDATE rooms SET room_status = '1' WHERE room_name = '$old_room'";
    $this->db->query($sql);
    $sql2 = "UPDATE book_log SET bl_room = $new_room where bl_id = $bl_id";
    $this->db->query($sql2);
    $sql3 = "UPDATE rooms SET room_status = '2' WHERE room_id = '$new_room'";
    $this->db->query($sql3);
});
// End Code Group 5
$app->run();
