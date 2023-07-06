
    <h2>ESP Output Control</h2>
    <?php 
        $html_buttons = ''; $html_boards = '';
        foreach($esp_outputs as $esp_output){
            if ($esp_output["state"] == "1"){
                $button_checked = "checked";
            } else {
                $button_checked = "";
            }
            $html_buttons .= '<h3>' . $esp_output["name"] . ' - Board '. $esp_output["board"] . ' - GPIO ' . $esp_output["gpio"] . ' (<i><a onclick="deleteOutput(this)" href="javascript:void(0);" id="' . $esp_output["id"] . '">Delete</a></i>)</h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $esp_output["id"] . '" ' . $button_checked . '><span class="slider"></span></label>';
        }
        echo $html_buttons;
    ?>
    <br><br>
    <?php
        $html_boards .= '<h3>Boards</h3>';
        foreach($esp_boards as $esp_board){
            $row_reading_time = $esp_board["last_request"];
            $html_boards .= '<p><strong>Board ' . $esp_board["board"] . '</strong> - Last Request Time: '. $row_reading_time . '</p>';
        }
        echo $html_boards; 
    ?>
