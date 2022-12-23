<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array( 
        array('label' => __('Name'), 'width' => 'auto', 'filter' => true), 
        array('label' => __('City'), 'width' => 'auto'), 
        array('label' => __('Country'), 'width' => 50, 'wrap' => true),
        array('label' => __('Address'), 'width' => 50, 'wrap' => true),
        array('label' => __('Phone'), 'width' => 50, 'wrap' => true),
        array('label' => __('Mobile'), 'width' => 50, 'wrap' => true),
        array('label' => __('Fax'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Email'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Website'), 'width' => 'auto', 'filter' => true)
    );

    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($companies as $c) { 
        $this->PhpExcel->addTableRow(array( 
            $c['Company']['name'],
            $c['Company']['city'],
            $c['Country']['nicename'],
            $c['Company']['address'],
            $c['Company']['phone'],
            $c['Company']['mobile'],
            $c['Company']['fax'],
            $c['Company']['email'],
            $c['Company']['website']
        )); 
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output();
?>