<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells
    $tableHaders = array();
    $tableHaders[] = array('label' => __('Characteristics'), 'width' => 'auto', 'filter' => true);
    foreach ($fields as $key => $value) {
        if($value == 'fair_id'){
            $tableHaders[] = array('label' => __('Fairs'), 'width' => 'auto', 'filter' => true);
        }else{
            $tableHaders[] = array('label' => __(ucwords(str_replace('_', ' ', $value))), 'width' => 'auto', 'filter' => true);
        }
    }
    $table = $tableHaders;
    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($contacts as $c) {
        $characteristics = '';
        if(!empty($c['ContactCharacteristic'])) {
            $characteristics = Set::extract('/name',$c['ContactCharacteristic']);
            $characteristics = implode(', ', $characteristics);
        }
        $tableRow = array($characteristics);
        foreach ($fields as $key => $value) {
            if($value == 'fair_id'){
                $fair_names = '';
                if(!empty($c['Fair'])) {
                    $fair_names = Set::extract('/name',$c['Fair']);
                    $fair_names = implode(', ', $fair_names);
                }
                $tableRow[] = $fair_names;
            }
            elseif($value == 'created_by') {
                $tableRow[] = $c['CreatedBy']['first_name'].' '.$c['CreatedBy']['last_name'];
            }
            elseif($value == 'updated_by') {
                $tableRow[] = $c['UpdatedBy']['first_name'].' '.$c['UpdatedBy']['last_name'];
            }else{
                $tableRow[] = $c['Contact'][$value];
            }
        }
        $this->PhpExcel->addTableRow($tableRow);
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output();
?>