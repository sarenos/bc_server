<?php

class ViewAjax extends ViewTemplated
{
    public function fill()
    {
         parent::fill();
         $this-> set_template('result_ajax.tpl');
         $this-> assign('Result', $this->_get_model_result());
    }
    ///////////////////////////////////////////////////////////////////////////
    
    private function _get_model_result()
    {
        $model_result = $this-> Model-> get_result();
        $result = array();
        if (!isset($model_result['status']))
        {
            $result = array(
                            'status' => 0
                        );
        }
        if (!isset($model_result['statusMsg']))
        {
            $result += array(
                            'statusMsg' => 'ok'
                        );
        }
        if ($model_result === true)
        {
            return $result;
        }
        if ($model_result == 'ok')
        {
            return $model_result;
        }
        return $result + $model_result;
    }
    ///////////////////////////////////////////////////////////////////////////
}
