<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array( 
        array('label' => __('Name'), 'width' => 'auto', 'filter' => true), 
        array('label' => __('Description'), 'width' => 'auto'), 
    );

    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($contact_types as $c) { 
        $this->PhpExcel->addTableRow(array( 
            $c['ContactCategory']['name'],
            $c['ContactCategory']['description'],
        ));
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output();
?>