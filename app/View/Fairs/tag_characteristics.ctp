<div class="panel panel-primary">
	<div class="panel-heading">
    	<h4 class="pull-left">Characteristics</h4>
        <a class="btn btn-default btn-sm mt5 pull-right" href="<?php echo $this->request->referer(); ?>"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<div class="col-lg-11 col-lg-offset-1">
        	<?php
            if(!empty($ccCount)) {
			?>
            <form method="post" action="<?php echo $this->base ?>/Fairs/tagCharacteristics?CONID=<?php echo $conID; ?>&CID=<?php echo $cid; ?>&FID=<?php echo $fid; ?>">
                <?php
                echo $this->Form->input('redirect_path',array(
                    'type' => 'hidden',
                    'div' => false,
                    'label' => false,
                    'value' => $this->request->referer()
                ));
                $counter = 1;
                foreach($characteristics as $characteristic) {
                    if(!empty($characteristic['ContactCharacteristic'])) {
                ?>
                <div class="col-lg-4">
                    <strong><?php echo $characteristic['ContactCategory']['name']; ?></strong>
                    <?php
                    foreach($characteristic['ContactCharacteristic'] as $contactCharacteristic) {
                    ?>
                    <div class="checkbox">
                        <label>
                            <input <?php echo isset($tagedCharacteristics[$contactCharacteristic['id']]) ? 'checked="checked"' : ''; ?> type="checkbox" name="data[ContactToContactCharacteristic][]" value="<?php echo $contactCharacteristic['id']; ?>" /> <?php echo $contactCharacteristic['name']; ?>
                        </label>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                    }
                    echo $counter % 3 == 0 ? '<div class="clearfix"></div>' : '';
                    $counter++;
                }
                ?>
                <div class="clearfix"></div>
                <div class="col-lg-1 col-lg-offset-11">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
                <div class="clearfix"></div>
            </form>
            <?php
			}else{
			?>
            <p class="text-danger">No characteristics defined. Please define contact characteristics first.</p>
            <?php
			}
			?>
        </div>
    </div>
</div>