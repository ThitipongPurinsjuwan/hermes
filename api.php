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




//--------------------------------------------------------[ Code Group 4 ] ------------------------------------
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
$app->get('/Show_detail_room_guest/{room_id}', function (Request $request, Response $response, array $args) {
    $room_id = $args['room_id'];
    $sql = "SELECT * FROM rooms r join building b
    on r.room_building = b.building_id
    join room_type rt
    on r.room_type =  rt.rtype_id
    join room_view rv
    on r.room_view = rv.rview_id
    join room_status rs
    on r.room_status = rs.rstatus_id
    where r.room_id = $room_id";
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
    $check_in = $params['display_check_in'];
    $check_out = $params['display_check_out'];
    $agency_reservation = $params['agency_reservation'];
    $id = $params['display_id'];
    $g_id = $_POST['display_guest_id'];

    $sql_update_reservation = "UPDATE reservation_info SET
    resinfo_first_name = '$fname',
    resinfo_last_name = '$lname',
    resinfo_email = '$email',
    resinfo_telno = '$telno',
    resinfo_comments = '$comment',
    resinfo_agency = $agency_reservation
    WHERE resinfo_id = $id";

    $sql_update_ginfo = "UPDATE guest_info SET
    ginfo_in = '$check_in',
    ginfo_out = '$check_out'
    WHERE ginfo_id = $g_id";
    try {
        $this->db->query($sql_update_reservation);
        $this->db->query($sql_update_ginfo);
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
$app->get('/get_agency', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * from agency;";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/show_room_guest', function (Request $request, Response $response, array $args) {
    $ginfo_id = (int) $_POST['ginfo_id'];
    $gCheckIn = $_POST['gCheckIn'];
    $gCheckOut = $_POST['gCheckOut'];
    $sql = "SELECT * from book_log bl join guest_info g
    on bl.bl_ginfo = g.ginfo_id
    join rooms r
    on bl.bl_room = r.room_id
    where g.ginfo_id = $ginfo_id AND bl.bl_checkin between '$gCheckIn'  and '$gCheckOut'
    group by bl.bl_room";
    $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($result);
    // try {
    //     $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    //     return $this->response->withJson($result);
    // } catch (PDOException $e) {
    //     return $this->response->withJson(array('message' => 'false'));
    // }
});
// End Code Group 4




//--------------------------------------------------------[ Code Group 3 ] ------------------------------------
$app->get('/addroom/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT *from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    WHERE re.resinfo_id = $id
    group by re.resinfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/room/{id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['id'];
    $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl.bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $bl_ginfo = ($sth[0]['bl_ginfo']);
    $ginfo_in = ($sth[0]['ginfo_in']);
    $ginfo_out = ($sth[0]['ginfo_out']);
    $sql1 = "SELECT r.room_name from book_log bl join guest_info g
        on bl.bl_ginfo = g.ginfo_id
        join rooms r
        on bl.bl_room = r.room_id
        where bl.bl_ginfo = $bl_ginfo AND bl.bl_checkin between '$ginfo_in' and '$ginfo_out'
        group by bl.bl_room";
    $sth1 = $this->db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
    $sql2 = "SELECT room_name ,room_id from rooms where room_name != ''";
    if (count($sth1) > 0) {
        foreach ($sth1 as $key) {
            $sql2 .= " And room_name != " . $key['room_name'];
        }
    }
    $sth2 = $this->db->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth2);
});
$app->post('/saveadd', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $bl_id = $params['id_bl_save'];
    $room_id = $params['select'];
    try {
        $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl_id = $bl_id";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $bl_ginfo = ($sth[0]['bl_ginfo']);
        $ginfo_in = ($sth[0]['ginfo_in']);
        // $ginfo_checkout = ($sth[0]['ginfo_checkout']);
        $sql1 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin,bl_timestamp, bl_room,bl_status)
        SELECT bl_reservation, bl_ginfo,'$ginfo_in','', '$room_id','0'
        FROM book_log WHERE bl_id = $bl_id";
        $this->db->query($sql1);

        $sql2 = "INSERT INTO guest_info ( ginfo_first_name, ginfo_last_name,ginfo_tax_id, ginfo_name_bill)
        SELECT ginfo_first_name, ginfo_last_name, ginfo_tax_id, ginfo_name_bill
        FROM guest_info WHERE ginfo_id = $bl_ginfo";
        $this->db->query($sql2);
        
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false4'));
    }
});
//--------------------------------------------------------[ End Code Group 3 ] ------------------------------------







//--------------------------------------------------------[ Code Group 5 ] ------------------------------------
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
            where ginfo_id=" . $id;
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
            where room_id ='" . $id . "'";
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




//--------------------------------------------------------[ Code Group 2 ] ------------------------------------
$app->get('/cancel/{bl_id}/{comments}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $resinfo_comments = $args['comments'];
    $sql = "SELECT resinfo_id from reservation_info join book_log on resinfo_id = bl_reservation where bl_id = $bl_id ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $resinfo_id = $sth[0]['resinfo_id'];
    $sql1 = "update reservation_info 
    set resinfo_comments = '$resinfo_comments' , resinfo_flag= 1
    where resinfo_id = $resinfo_id ";
    $this->db->query($sql1);
});

$app->get('/guest/{bl_id}/{comments}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['bl_id'];
    $ginfo_comment = $args['comments'];
    $sql = "SELECT ginfo_id from guest_info join book_log on ginfo_id = bl_ginfo where bl_id = $bl_id ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $ginfo_id = $sth[0]['ginfo_id'];
    $sql1 = "update guest_info
    set ginfo_comment = '$ginfo_comment' , ginfo_flag= 1
    where ginfo_id = $ginfo_id ";
    $this->db->query($sql1);
});
// End Code Group 2
$app->run();
