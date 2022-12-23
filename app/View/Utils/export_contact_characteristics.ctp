<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array( 
        array('label' => __('Name'), 'width' => 'auto', 'filter' => true), 
        array('label' => __('Contact Type'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Fair Category'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Description'), 'width' => 'auto'), 
    );

    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($contactCharacteristics as $c) { 
        $this->PhpExcel->addTableRow(array( 
            $c['ContactCharacteristic']['name'],
            $c['ContactCategory']['name'],
            $c['FairCategory']['name'],
            $c['ContactCharacteristic']['description'],
        ));
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output();
?>