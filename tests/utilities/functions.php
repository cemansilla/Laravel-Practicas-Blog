<?php
/**
 * Helper para simplificar el factory de usuarios en test
 */
function create($class, $attr = []){
  return factory($class)->create($attr);
}
?>