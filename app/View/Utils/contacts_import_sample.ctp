<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array();
    foreach($fields as $key => $value ) {
        $table[] = array('label' => __(ucwords(str_replace('_', ' ', $value))), 'width' => 'auto', 'filter' => true);
    }
    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

    $count = count($fields) + 1;
    foreach($countries as $iso => $name) {
        $this->PhpExcel->addTableColumn($count,$name);
    }

    $this->PhpExcel->makeDropDown('D2');
    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output('sample.xlsx');
?>