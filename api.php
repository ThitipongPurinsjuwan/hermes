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
$container = $app->getContainer();


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

$app->get('/get', function (Request $request, Response $response, array $args) {
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
// DisplayRoom card 5
$app->get('/DisplayRoom/{id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['id'];
    $sql="SELECT * from book_log bl join guest_info g
    on bl.bl_ginfo = g.ginfo_id
    where bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $ginfo_first_name = $sth['ginfo_first_name'];
    $ginfo_last_name = $sth['ginfo_last_name'];
    $sql1 = "SELECT g.ginfo_room,r.room_name FROM hermes.guest_info g join rooms r
    on g.ginfo_room = r.room_id
    where g.ginfo_first_name = '$ginfo_first_name' AND g.ginfo_last_name ='$ginfo_last_name'";
    $sth1 = $this->db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth1);
});
// end DisplayRoom card 5 
// gard 12
$app->get('/ShowCheckin/{bl_id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $sql = "SELECT * FROM book_log bl
            join guest_info gi
            on bl.bl_ginfo = gi.ginfo_id
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
            where bl.bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});


$app->post('/AddCheckinGuest', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    // echo ("<pre>");
    // print_r($params);
    // print_r($_POST);
    // echo ("<pre>");
    // exit;
    $bl_id = $params['bl_id_add'];
    $ginfo_first_name = $params['display_firstname_checkinguest'];
    $ginfo_last_name = $params['display_lastname_checkinguest'];
    $ginfo_telno = $params['display_phone_checkinguest'];
    $ginfo_passport_id = $params['display_passport_checkinguest'];
    $ginfo_birthday = $params['display_HBD_checkinguest'];
    $ginfo_nation = $params['display_nation_checkinguest'];
    $ginfo_email = $params['display_email_checkinguest'];
    $ginfo_sex = $params['display_sex_checkinguest'];
    $bl_incbreakfast = $params['display_incbreakfast_checkinguest'];
    $bl_breakfast = $params['display_breakfast_checkinguest'];
    $bl_price = $params['display_price_checkinguest'];

    try {
        $sql = "SELECT * from guest_info g
                join book_log bl
                on  g.ginfo_id = bl.bl_ginfo
                WHERE bl.bl_id = $bl_id";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $ginfo_id = $sth['ginfo_id'];
        $sql1 = "INSERT INTO guest_info(ginfo_first_name, ginfo_last_name, ginfo_telno, ginfo_passport_id, ginfo_birthday, ginfo_nation, ginfo_email, ginfo_sex)
                VALUES ('$ginfo_first_name', '$ginfo_last_name', '$ginfo_telno', '$ginfo_passport_id', '$ginfo_birthday', '$ginfo_nation', '$ginfo_email', '$ginfo_sex')
                WHERE ginfo_id = $ginfo_id";
        $this->db->query($sql1);

        $sql2 = "INSERT INTO book_log(bl_incbreakfast, bl_breakfast, bl_price)
            VALUES ('$bl_incbreakfast', '$bl_breakfast', '$bl_price')
            WHERE bl_id = $bl_id";
        $this->db->query($sql2);

        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }
});

// end gard 12




// code group 3
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

    $sql4 = "UPDATE rooms set room_status ='0'where room_id = '$room_id'";
    $this->db->query($sql4);
});


$app->run();
