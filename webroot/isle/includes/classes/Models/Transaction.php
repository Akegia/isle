<?php
  namespace ISLE\Models;
  
  use ISLE\Validate;
  use ISLE\UIException;
  
  class Transaction extends Node
  {
    const TABLE_NAME = 'transactions';
    
    const PURPOSE_LENGTH = 255;
    const NOTES_LENGTH = 255;
	
    static public function getProperties()
    {
      $props = parent::_getProperties();
      $props["type"] = array('type' => 'TransactionType', 'required' => TRUE, 'validator' => 'validateId');
      $props["user"] = array('type' => 'User', 'required' => TRUE, 'validator' => 'validateId', 'label' => 'User');
      $props["asset"] = array('type' => 'Asset', 'required' => TRUE, 'validator' => 'validateId', 'label' => 'Asset');
      $props["time"] = array('type' => 'string', 'required' => TRUE, 'validator' => 'validateTime', 'label' => 'Time');
      return $props;
    }
    
    static public function getForeignKeys()
    {
      $props["type"] = array('type' => 'TransactionType');
      $props["user"] = array('type' => 'User');
      $props["asset"] = array('type' => 'Asset');
      
      return $props;
    }
	
    /* Static validation methods */
    
    static protected function validateTime($time)
    {
      try
      {
        $t = new \DateTime($time, new \DateTimeZone('America/New_York'));
        return $t->format('Y-m-d H:i:s');
      }
      catch (\Exception $e)
      {
        throw new UIException('Invalid date.');
      }
    }
  }
?>