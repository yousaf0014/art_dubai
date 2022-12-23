<?php
    // View: 
    $this->PhpExcel->createWorksheet(); 
    $this->PhpExcel->setDefaultFont('Calibri', 12); 

    // define table cells 
    $table = array( 
        array('label' => __('First Name'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Last Name'), 'width' => 'auto', 'filter' => true),
        array('label' => __('City'), 'width' => 'auto'), 
        // array('label' => __('Country'), 'width' => 50, 'wrap' => true),
        array('label' => __('Address'), 'width' => 50, 'wrap' => true),
        array('label' => __('Phone'), 'width' => 50, 'wrap' => true),
        array('label' => __('Mobile'), 'width' => 50, 'wrap' => true),
        array('label' => __('Fax'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Email'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Website'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Bar Code'), 'width' => 'auto'),
        array('label' => __('Guest Off'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Source'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Facebook'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Twitter'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Linedin'), 'width' => 'auto', 'filter' => true),
        array('label' => __('Instagram'), 'width' => 'auto', 'filter' => true),
    );

    // heading 
    $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true)); 

    // data 
    foreach ($contacts as $c) { 
        $this->PhpExcel->addTableRow(array( 
            $c['Contact']['first_name'],
            $c['Contact']['last_name'],
            $c['Contact']['city'],
            // $c['Country']['nicename'],
            $c['Contact']['address'],
            $c['Contact']['phone'],
            $c['Contact']['mobile'],
            $c['Contact']['fax'],
            $c['Contact']['email'],
            $c['Contact']['website'],
            $c['Contact']['bar_code'],
            $c['Contact']['guest_off'],
            $c['Contact']['source'],
            $c['Contact']['facebook'],
            $c['Contact']['twitter'],
            $c['Contact']['linkedin'],
            $c['Contact']['instagram']
        )); 
    } 

    $this->PhpExcel->addTableFooter();
    $this->PhpExcel->output('contact_list.xlsx');
?>