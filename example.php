<?php

/**
* PHP_Text2Speech Class example
*/

include 'PHP_Text2Speech.class.php';

$t2s = new PHP_Text2Speech;

?>
<audio controls="controls" autoplay="autoplay">
  <source src="<?php echo $t2s->speak('ip address 143,, 21,, 435,, 14 had'); ?>" type="audio/mp3" />
</audio>