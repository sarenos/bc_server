<?php

require_once dirname(__FILE__) . '/int.inc.php';

class FieldAmount extends FieldInt {

    /////////////////////////////////////////////////////////////////////////////

    public function filter_pre() {
        if ($this->value < 0) {
            $this->set_input_data(0);
            return;
        }
        $this->set_value(floor($this->value * 100));
    }
    ///////////////////////////////////////////////////////////////////////////

    public function get_form_context() {
        if ($this->is_empty()) {
            return '';
        }
        return $this->value / 100.0;
    }
    ///////////////////////////////////////////////////////////////////////////
}