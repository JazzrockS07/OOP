    <tr<?php if(!empty($this->content[$key]['error'])) {echo ' style="background-color:#FAA"';} ?>>
      <td>
        <?php echo $this->content[$key]['title']; ?>
      </td>
      <td>
        <?php foreach($this->content[$key]['options'] as $k=>$v) { ?>
	      <label>
            <input type="radio" name="<?php echo $this->content[$key]['name']; ?>" value="<?php echo $k; ?>" <?php if($this->content[$key]['value'] == $k) echo 'checked="checked"'; ?>>
            <?php echo $v; ?>
          </label><br>
        <?php } ?>
      </td>
      <td>
        <?php echo $this->content[$key]['error']; ?>
      </td>
    </tr>
