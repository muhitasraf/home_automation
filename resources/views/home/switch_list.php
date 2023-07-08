<div class="rounded d-flex justify-content-center pt-5">
    <div class="col-md-4 col-sm-12 shadow-sm  bg-light">
        <div class="p-3">
            <div class="form-group d-flex justify-content-center">
                <a href="<?php echo route('switch_output/create') ?>" class="btn btn-info text-center">Create Switch</a>
                <a href="<?php echo route('') ?>" class="btn btn-info text-center mx-1" type="button">Control Page</a>
            </div>
        </div>
    </div>
</div>

<div class="rounded d-flex justify-content-center pt-5">
    <div class="col-md-4 col-sm-12 shadow-sm  bg-light">
        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-border">
                    <thead>
                        <th>SL</th>
                        <th>Switch</th>
                        <th>Board</th>
                        <th>GPIO</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php 
                        if(!empty($all_switch)){
                            foreach($all_switch as $key=>$switch){ 
                        ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $switch['name']; ?></td>
                                <td><?php echo $switch['board']; ?></td>
                                <td><?php echo $switch['gpio']; ?></td>
                                <td>
                                    <a href="<?php echo route('switch_output/edit/').$switch['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?php echo route('switch_output/delete/').$switch['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            }
                        }else{
                            echo '<tr><td colspan="5" class="text-center h4">There is no switch!<br><a href="'.route('switch_output/create').'">Create Switch</a></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>