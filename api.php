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
    $g_id = $_POST['display_id_guest_contact'];

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
    WHERE bl.bl_id = $id";
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
        $sql1 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin,bl_timestamp, bl_room,bl_status,bl_price)
        SELECT bl_reservation, bl_ginfo,'$ginfo_in','', '$room_id','0',bl_price
        FROM book_log WHERE bl_id = $bl_id";
        $this->db->query($sql1);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false4'));
    }
});
//--------------------------------------------------------[ End Code Group 3 ] ------------------------------------







//--------------------------------------------------------[ Code Group 5 ] ------------------------------------
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
$app->post('/updateRoom', function (Request $request, Response $response, array $args) {
    $guest_id = (int)$_POST['ginfo_id'];
    $checkin = $_POST['gCheckIn'];
    $checkout = $_POST['gCheckOut'];
    $new_room = $_POST['gnewRoom'];
    $old_room = $_POST['goldRoom'];
    
    try {
        $sql = "UPDATE rooms SET room_status = '1' WHERE room_name = '$old_room'";
        $this->db->query($sql);
        $sql2 = "UPDATE rooms SET room_status = '2' WHERE room_id = '$new_room'";
        $this->db->query($sql2);
        $sql3 = "UPDATE book_log set bl_room = '$new_room', bl_status = '2' where bl_ginfo = $guest_id and bl_room = '$old_room' and bl_checkin between '$checkin' and '$checkout'";
        $this->db->query($sql3);
        $sql4 = "UPDATE guest_info set ginfo_room = '$new_room' where ginfo_id = $guest_id";
        $this->db->query($sql4);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }


});
//--------------------------------------------------------[ End Code Group 5 ] ------------------------------------






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
    try {
        $this->db->query($sql1);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }
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
//--------------------------------------------------------[ End Code Group 2 ] ------------------------------------





//--------------------------------------------------------[ Code Group 1 ] ------------------------------------
$app->get('/getdb', function (Request $request, Response $response, array $args) {
    $sql = "SELECT b.bl_id,g.ginfo_id,g.ginfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,re.resinfo_first_name
    FROM rooms r join book_log b on r.room_id=b.bl_room join reservation_info re on b.bl_reservation = re.resinfo_id
    join agency a on re.resinfo_agency=a.agency_id join guest_info g on b.bl_ginfo = g.ginfo_id
    where re.resinfo_flag = 0
    group by b.bl_id,re.resinfo_first_name,r.room_name";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/getdb/{keyword}', function (Request $request, Response $response, array $args) {
    $id = $args['keyword'];
    $sql = "SELECT b.bl_id,g.ginfo_id,g.ginfo_first_name,r.room_name,a.agency_name,re.resinfo_telno,b.bl_checkin,re.resinfo_bookdate,re.resinfo_first_name
    FROM rooms r join book_log b on r.room_id=b.bl_room join reservation_info re on b.bl_reservation = re.resinfo_id
    join agency a on re.resinfo_agency=a.agency_id join guest_info g on b.bl_ginfo = g.ginfo_id
    where g.ginfo_first_name ='$id' or r.room_name ='$id' or a.agency_name ='$id' or re.resinfo_telno =$id and re.resinfo_flag = 0
    group by b.bl_id,re.resinfo_first_name,r.room_name";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/getroomva/{checkin}/{checkout}', function (Request $request, Response $response, array $args) {
    $checkin = $args['checkin'];
    $checkout = $args['checkout'];
    $sql ="SELECT r.room_name FROM book_log bl join rooms r on bl.bl_room = r.room_id 
    where bl.bl_status != '1' and bl.bl_checkin  between '".$checkin."' AND '".$checkout."'
    group by r.room_name";
    $sth = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $sql9 = "SELECT rm.room_id,rm.room_name,b.building_name,rt.rtype_eng,rv.rview_eng,rm.room_price,rm.room_guest,rs.rstatus_eng from rooms rm
    join room_type rt 
    on rm.room_type = rt.rtype_id
    join room_status rs
    on rm.room_status = rs.rstatus_id
    join room_view rv 
    on rm.room_view = rv.rview_id
    join building b
    on rm.room_building = b.building_id 
    where rm.room_name != ''";
    foreach ( $sth as $value )
    {
        $sql9 .= "and rm.room_name != ".$value;
    }
    $ans = $this->db->query($sql9)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($ans);
});

$app->get('/getroomva/{roomm}', function (Request $request, Response $response, array $args) {
    $id = $args['roomm'];
    $sql = "SELECT room_name,room_price FROM rooms where room_id='".$id."' ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/saveRE/{code}/{first}/{last}/{phone}/{email}/{agency}/{checkin}/{checkout}/{price}/{bf}/{room}', function (Request $request, Response $response, array $args) {
    $code = $args['code'];
    $first = $args['first'];
    $last = $args['last'];
    $phone = $args['phone'];
    $email = $args['email'];
    $agency = $args['agency'];
    $checkin = $args['checkin'];
    $checkout = $args['checkout'];
    $price = $args['price'];
    $bf = $args['bf'];
    $room = $args['room'];

    $sql = "INSERT INTO reservation_info (resinfo_code,resinfo_first_name,resinfo_last_name,
        resinfo_telno,resinfo_email,resinfo_agency,resinfo_number)
        VALUES($code,'$first','$last',$phone,'$email',$agency,0)";
    $this->db->query($sql);
    $sql2 ="INSERT INTO guest_info (ginfo_first_name,ginfo_last_name,ginfo_email, 
            ginfo_telno,ginfo_in,ginfo_out,ginfo_tax_id,ginfo_name_bill)
            VALUES('$first','$last','$email',$phone,'$checkin','$checkout','','')";
    $this->db->query($sql2);
});

$app->get('/savebook/{re}/{gu}/{checkin}/{room}/{price}/{bf}', function (Request $request, Response $response, array $args) {
    $re = $args['re'];
    $gu = $args['gu'];
    $checkin = $args['checkin'];
    $room = $args['room'];
    $price = $args['price'];
    $bf = $args['bf'];
    $sql4 ="INSERT INTO book_log(bl_reservation, bl_ginfo,bl_checkin,bl_room,bl_status,bl_price,bl_incbreakfast)
            VALUES($re,$gu,'$checkin',$room,2,$price,$bf)";
    $this->db->query($sql4)->fetchAll(PDO::FETCH_ASSOC);
});

$app->get('/getagency/{agency}', function (Request $request, Response $response, array $args) {
    $id = $args['agency'];
    $sql = "SELECT agency_name FROM agency where agency_id='".$id."' ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/maxGU', function (Request $request, Response $response, array $args) {
    $sql = "SELECT max(ginfo_id) as ginfo_id  from guest_info";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/maxRE', function (Request $request, Response $response, array $args) {
    $sql = "SELECT max(resinfo_id) as resinfo_id from reservation_info";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

//--------------------------------------------------------[ End Code Group 1 ] ------------------------------------

$app->run();
