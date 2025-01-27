<?php
    //update stock status of stock
    
    $conn->query("
        UPDATE `batch`
        SET `batch`.`expiration_status` = '0'
        WHERE `batch`.`archive_status` = '0';
    ");
    $conn->query("
        UPDATE `batch`
        SET `batch`.`expiration_status` = '1'
        WHERE `batch`.`archive_status` = '0' AND CURDATE() < (DATE_ADD(`batch`.`expiration_date`, INTERVAL -1 MONTH));
    ");
    $conn->query("
        UPDATE `batch`
        SET `batch`.`expiration_status` = '2'
        WHERE `batch`.`archive_status` = '0' AND CURDATE() >= (DATE_ADD(`batch`.`expiration_date`, INTERVAL -1 MONTH)) AND CURDATE() < `expiration_date`;
    ");
    $conn->query("
        UPDATE `batch`
        SET `batch`.`expiration_status` = '3'
        WHERE `batch`.`archive_status` = '0' AND CURDATE() >= `batch`.`expiration_date`;
    ");
    $conn->query("
        UPDATE `batch`
        SET `batch`.`expiration_status` = '0'
        WHERE `batch`.`archive_status` = '0' AND `expiration_date` = NULL;
    ");

?>