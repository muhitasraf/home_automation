

<div class="rounded d-flex justify-content-center pt-5">
    <div class="col-md-4 col-sm-12 shadow-sm  bg-light">
        <div class="p-3">
            <div class="form-group d-flex justify-content-center">
                <a href="<?php echo route('switch_output/create') ?>" class="btn btn-info text-center">Create Switch</a>
                <a href="<?php echo route('switch_list') ?>" class="btn btn-info text-center mx-1" type="button">Switch List</a>
            </div>
        </div>
    </div>
</div>

<div class="rounded d-flex justify-content-center pt-4">
    <div class="col-md-4 col-sm-12 shadow-lg  bg-light">
        <div class="p-3">
            <div class="row px-2">
                <form action="">
                    <?php echo _csrf(); ?>
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Switch</th>
                            <th>Board</th>
                            <th>GPIO</th>
                        </thead>
                        <tbody>
                        <?php
                        $html_buttons = ''; $html_boards = ''; $html_title = '';
                        if(!empty($esp_outputs)){
                            foreach($esp_outputs as $esp_output){
                                if ($esp_output["state"] == "1"){
                                    $button_checked = "checked";
                                } else {
                                    $button_checked = "";
                                }
                                $html_buttons =    '<label class="switch text-center">
                                                        <input type="checkbox" onchange="updateOutput(this)" id="'.$esp_output["id"].' "'.$button_checked.'>
                                                        <span class="slider"></span>
                                                    </label>';
                            ?>
                            <tr>
                                <td><?php echo $esp_output["name"];?></td>
                                <td><?php echo $html_buttons;?></td>
                                <td><?php echo $esp_output["board"];?></td>
                                <td><?php echo $esp_output["gpio"];?></td>
                                <td></td>
                            </tr>
                        <?php 
                            }
                        }else{
                            echo '<tr><td colspan="4" class="text-center h4">There is no switch!<br><a href="'.route('switch_output/create').'">Create Switch</a></td></tr>';
                        }
                         ?>
                        </tbody>
                    </table>
                    <br>
                    <?php
                        $html_boards .= '<h3>Boards</h3>';
                        foreach($esp_boards as $esp_board){
                            $row_reading_time = $esp_board["last_request"];
                            $html_boards .= '<p><strong>Board '.$esp_board["board"].'</strong> - Last Request Time: '.$row_reading_time.'</p>';
                        }
                        echo $html_boards; 
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateOutput(_this){
        var id = _this.id;
        var state = _this.checked == true ? 1 : 0;
        let _csrf = $('#_csrf').val();
        $.ajax({
            url: '<?php echo route('switch_output/change_state');?>',
            type: 'POST',
            data: {id, state, _csrf},
            success: function(result){
                var output_data = JSON.parse(result);
            }
        });
    }

</script>