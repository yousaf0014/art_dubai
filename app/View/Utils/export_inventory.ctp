<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array( 
        array('label' => __('Item'), 'width' => 'auto', 'filter' => true), 
        array('label' => __('Quantity Out'), 'width' => 'auto'), 
        array('label' => __('Quantity In'), 'width' => 50, 'wrap' => true),
        array('label' => __('Assigned To'), 'width' => 50, 'wrap' => true),
        array('label' => __('Assigned Date'), 'width' => 50, 'wrap' => true),
        array('label' => __('Received Date'), 'width' => 50, 'wrap' => true)       
    );

    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($Items as $item) { 
        $this->PhpExcel->addTableRow(array( 
            $item['ItemCategory']['name'].' '.$item['ItemCategory']['name'],
            $item['InventoryOutItem']['qty_out'],
            $item['InventoryOutItem']['qty_in'],
            $item['Employee']['first_name'] . " " . $item['Employee']['last_name'],
            $item['InventoryOutItem']['assigned_date'],
            $item['InventoryOutItem']['received_date']            
        )); 
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output();
?>