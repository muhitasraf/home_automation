
    <h2>Create New Switch</h2>
    <div>
        <form action="" id="output_form">
            <?php echo _csrf(); ?>
            <h3>Create New Output</h3>
            <label for="outputName">Name</label>
            <input type="text" name="name" id="outputName"><br>
            <span class="output_name"></span>
            <label for="outputBoard">Board ID</label>
            <input type="number" name="board" min="0" id="outputBoard">
            <label for="outputGpio">GPIO Number</label>
            <input type="number" name="gpio" min="0" id="outputGpio">
            <span class="gpio_name"></span>
            <label for="outputState">Initial GPIO State</label>
            <select id="outputState" name="state">
                <option value="0">0 = OFF</option>
                <option value="1">1 = ON</option>
            </select>
            <input type="submit" class="create_output" value="Create Output">
            <p><strong>Note:</strong> in some devices, you might need to refresh the page to see your newly created buttons or to remove deleted buttons.</p>
        </form>

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
                url: '<?php echo route('store');?>',
                type: 'POST',
                data: {outputName, outputBoard, outputGpio, outputState, _csrf},
                success: function(result){
                    // console.log(JSON.parse(result))
                    var output_data = JSON.parse(result);
                    console.log(output_data.status);
                    if(output_data.status == 403){
                        if(output_data['message'].name){
                            $('.output_name').text(output_data['message'].name);
                        }
                        if(output_data['message'].gpio){
                            $('.gpio_name').text(output_data['message'].gpio);
                        }
                    }
                }
            });
        });
        
    </script>
    