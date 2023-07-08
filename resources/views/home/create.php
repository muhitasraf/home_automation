
        <div class="rounded d-flex justify-content-center pt-5">
            <div class="col-md-4 col-sm-12 shadow-sm  bg-light">
                <div class="p-3">
                    <div class="form-group d-flex justify-content-center">
                        <a href="<?php echo route('switch_list') ?>" class="btn btn-info text-center">Switch List</a>
                        <a href="<?php echo route('') ?>" class="btn btn-info text-center mx-1" type="button">Control Page</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded d-flex justify-content-center pt-4">
            <div class="col-md-4 col-sm-12 shadow-lg  bg-light">
                <div class="text-center pt-4">
                    <h3 class="text-primary">Create new switch</h3>
                </div>
                <form action="">
                    <?php echo _csrf(); ?>
                    <div class="p-4">
                        
                        <div class="form-group">
                            <label for="outputName">Name of the switch</label>
                            <input class="form-control" type="text" name="name" id="outputName">
                        </div>
                        <span class="badge bg-warning text-dark output_name"></span>

                        <div class="form-group">
                            <label for="outputBoard">Board ID</label>
                            <input class="form-control" type="number" name="board" min="0" id="outputBoard">
                        </div>
                        <span class="badge bg-warning text-dark board_id"></span>
                        
                        <div class="form-group">
                            <label for="outputGpio">GPIO Number</label>
                            <input class="form-control" type="number" name="gpio" min="0" id="outputGpio">
                        </div>
                        <span class="badge bg-warning text-dark gpio_name"></span>
                        
                        <div class="form-group">
                            <label for="outputState">Initial GPIO State</label>
                            <select class="form-control" id="outputState" name="state">
                                <option value="0">0 = OFF</option>
                                <option value="1">1 = ON</option>
                            </select>
                        </div>
                      
                        <div class="d-grid gap-2">
                            <button class="btn btn-info text-center create_output mt-2" type="button">Create Output</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <script>
        $('.create_output').click(function(event) {
            event.preventDefault();

            var outputName = $('#outputName').val();
            var outputBoard = $('#outputBoard').val();
            var outputGpio = $('#outputGpio').val();
            var outputState = $('#outputState').val();
            
            let _csrf = $('#_csrf').val();
            $.ajax({
                url: '<?php echo route('switch_output/store');?>',
                type: 'POST',
                data: {outputName, outputBoard, outputGpio, outputState, _csrf},
                success: function(result){
                    var output_data = JSON.parse(result);
                    console.log(output_data.status);
                    if(output_data.status == 403){
                        if(output_data['message'].name){
                            $('.output_name').text(output_data['message'].name);
                        }
                        if(output_data['message'].board){
                            $('.board_id').text(output_data['message'].board);
                        }
                        if(output_data['message'].gpio){
                            $('.gpio_name').text(output_data['message'].gpio);
                        }
                        toastr.error("Something went wrong!");
                    }
                    if(output_data.status == 200){
                        toastr.success(output_data['message']);
                        window.location.href = '<?php echo route('switch_list');?>';
                    }
                }
            });
        });
        
    </script>
    